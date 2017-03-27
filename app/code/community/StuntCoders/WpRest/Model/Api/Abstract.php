<?php

/**
 * @method StuntCoders_Wprest_Model_Api_Abstract setBaseUri(string $uri)
 * @method string getBaseUri()
 * @method StuntCoders_Wprest_Model_Api_Abstract setNextLink(string $link)
 * @method string getNextLink()
 * @method StuntCoders_Wprest_Model_Api_Abstract setPrevLink(string $link)
 * @method string getPrevLink()
 * @method StuntCoders_Wprest_Model_Api_Abstract setCurrentPage(int $page)
 * @method int getCurrentPage()
 */
abstract class StuntCoders_WpRest_Model_Api_Abstract extends Varien_Object
{
    /**
     * set API cache lifetime to 2 hours
     */
    const CACHE_LIFETIME = 7200;

    const CACHE_TAG = 'STUNTCODERS_WPREST_API_CACHE';

    const API_DIR = 'wp-json/';

    protected $_cache;

    protected $_cacheEnabled;

    protected $_cacheGroup = 'stuntcoders_wprest';

    /**
     * @param string $id
     * @return string
     */
    protected abstract function _getRoute($id = '');

    /**
     * Check if cache is enabled
     */
    public function __construct()
    {
        $this->_cacheEnabled = Mage::app()->useCache($this->_cacheGroup);
        $this->_cache = Mage::app()->getCache();
    }

    /**
     * @param array $params
     * @return array
     */
    public function getCollection($params = array())
    {
        return $this->_request($this->_parseRoute(), $params);
    }

    /**
     * @param string|int $id
     * @return array
     */
    public function getMember($id)
    {
        return $this->_request($this->_parseRoute($id));
    }

    /**
     * @param string|int $id
     * @return string
     */
    protected function _parseRoute($id = '')
    {
        return str_replace(':id', $id, $this->_getRoute());
    }

    /**
     * @return int
     */
    public function getNextPageIndex()
    {
        return (int) $this->getCurrentPage() + 1;
    }

    /**
     * @return int
     */
    public function getPrevPageIndex()
    {
        return (int) $this->getCurrentPage() - 1;
    }

    /**
     * @param string $route
     * @param array $params
     * @return array
     * @throws Zend_Http_Client_Exception|Mage_Core_Exception
     */
    protected function _request($route, $params = array())
    {
        $cacheKey = $this->_getCacheKey($route, $params);

        if ($this->_cacheEnabled) {
            if ($cached = $this->_loadCache($cacheKey) ) {
                return unserialize($cached);
            }
        }

        $this->_getHttpClient()->resetParameters();
        $this->_getHttpClient()->setUri($this->_getEndpointUri($route));
        $this->_getHttpClient()->setParameterGet($params);
        $response = $this->_getHttpClient()->request(Zend_Http_Client::GET);

        $headers = $response->getHeaders();
        if (isset($headers['Link'])) {
            $this->_parseLinkHeader($headers['Link']);
        }

        $responseBody = $response->getBody();
        if ($response->getStatus() !== 200) {
            Mage::throwException($responseBody);
        }

        $responseBody = Mage::helper('core')->jsonDecode($responseBody);

        if($this->_cacheEnabled) {
            $this->_saveCache(serialize($responseBody), $cacheKey, self::CACHE_LIFETIME);
        }

        return empty($responseBody) ? array() : $responseBody;
    }

    /**
     * @return Zend_Http_Client
     * @throws Zend_Http_Client_Exception
     */
    protected function _getHttpClient()
    {
        if (!$this->getData('_http_client')) {
            $client = new Zend_Http_Client();
            $client->setHeaders(array('Content-Type: application/json'));
            $client->setConfig(array(
                'keepalive' => true,
                'timeout' => 10,
            ));

            $this->setBaseUri(Mage::helper('stuntcoders_wprest')->getBaseUri() . self::API_DIR);

            $this->setData('_http_client', $client);
        }

        return $this->getData('_http_client');
    }

    /**
     * @param string $route
     * @return string
     */
    protected function _getEndpointUri($route)
    {
        return "{$this->getBaseUri()}" . ltrim($route, '/');
    }

    /**
     * @param string $linkHeader
     * @return bool
     */
    protected function _parseLinkHeader($linkHeader)
    {
        if (empty($linkHeader)) {
            return false;
        }

        foreach (explode(',', $linkHeader) as $link) {
            $segments = explode(';', $link);

            if (count($segments) < 2) {
                continue;
            }

            $linkPart = trim($segments[0]);
            if($linkPart[0] !== '<' && $linkPart[strlen($linkPart) - 1] !== '>') {
                continue;
            }

            $linkPart = substr($linkPart, 1, -1);
            for ($i = 1; $i < count($segments); $i++) {
                $rel = explode('=', trim($segments[$i]));

                if (count($rel) < 2 || 'rel' !== $rel[0]) {
                    continue;
                }

                $relValue = $rel[1];
                if($relValue[0] == '"' && $relValue[strlen($relValue) - 1] === '"') {
                    $relValue = substr($relValue, 1, -1);
                }

                if ('next' === $relValue) {
                    $this->setNextLink($linkPart);
                } else if ('prev' === $relValue) {
                    $this->setPrevLink($linkPart);
                }
            }

        }

        return true;
    }

    /**
     * Generate a cache key for the API path and query params
     *
     * @param       $route
     * @param array $params
     *
     * @return string
     */
    protected function _getCacheKey($route, array $params = array())
    {
        $key = $route;
        $key .= md5(serialize($params));
        return $key;
    }

    /**
     * Cache an API response
     *
     * @param $response
     * @param $cacheKey
     *
     * @return $this
     */
    protected function _saveCache($response, $cacheKey, $lifeTime)
    {
        $this->_cache->save($response, $cacheKey, array(self::CACHE_TAG), $lifeTime);
        return $this;
    }

    /**
     * Load cached API response
     *
     * @param $cacheKey
     *
     * @return bool|string
     */
    protected function _loadCache($cacheKey)
    {
        return $this->_cache->load($cacheKey);
    }
}
