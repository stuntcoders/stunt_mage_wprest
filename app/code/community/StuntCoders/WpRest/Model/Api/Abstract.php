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
     * @param string $id
     * @return string
     */
    protected abstract function _getRoute($id = '');

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

            $this->setBaseUri(Mage::helper('stuntcoders_wprest')->getBaseUri());

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
}
