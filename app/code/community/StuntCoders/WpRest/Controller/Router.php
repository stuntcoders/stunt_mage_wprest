<?php

class StuntCoders_WpRest_Controller_Router extends Mage_Core_Controller_Varien_Router_Abstract
{
    protected $_matchers = array(
        'post' => '_matchPost',
        'page' => '_matchPage',
        'category' => '_matchCategory',
    );

    /**
     * @param Varien_Event_Observer $observer
     */
    public function initControllerRouters($observer)
    {
        /* @var Mage_Core_Controller_Varien_Front $front */
        $front = $observer->getEvent()->getFront();

        $front->addRouter('stuntcoders_wprest', $this);
    }

    public function match(Zend_Controller_Request_Http $request)
    {
        if (!Mage::isInstalled()) {
            Mage::app()->getFrontController()->getResponse()
                ->setRedirect(Mage::getUrl('install'))
                ->sendResponse();
            exit;
        }

        $identifier = trim($request->getPathInfo(), '/');

        $condition = new Varien_Object(array(
            'identifier' => $identifier,
            'continue' => true
        ));

        Mage::dispatchEvent('stuntcoders_wprest_controller_router_match_before', array(
            'router' => $this,
            'condition' => $condition
        ));

        $identifier = $condition->getIdentifier();

        if ($condition->getRedirectUrl()) {
            Mage::app()->getFrontController()->getResponse()
                ->setRedirect($condition->getRedirectUrl())
                ->sendResponse();
            $request->setDispatched(true);
            return true;
        }

        if (!$condition->getContinue()) {
            return false;
        }

        foreach ($this->_matchers as $action => $callback) {
            try {
                if ($object = $this->$callback($identifier)) {
                    $request->setModuleName('stuntcoders_wprest')
                        ->setControllerName('index')
                        ->setActionName($action)
                        ->setParam('object', $object);

                    $request->setAlias(Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS, $identifier);

                    return true;
                }
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }

        return false;
    }

    /**
     * @param string $identifier
     * @return false|array
     */
    protected function _matchPost($identifier)
    {
        $posts = Mage::getSingleton('stuntcoders_wprest/api_post')->getCollection(array(
            'slug' => $identifier
        ));

        if (empty($posts)) {
            return false;
        }

        return reset($posts);
    }

    /**
     * @param string $identifier
     * @return false|array
     */
    protected function _matchPage($identifier)
    {
        $pages = Mage::getSingleton('stuntcoders_wprest/api_page')->getCollection(array(
            'slug' => $identifier
        ));

        if (empty($pages)) {
            return false;
        }

        return reset($pages);
    }

    /**
     * @param string $identifier
     * @return false|array
     */
    protected function _matchCategory($identifier)
    {
        $categories = Mage::getSingleton('stuntcoders_wprest/api_category')->getCollection(array(
            'slug' => $identifier
        ));

        if (empty($categories)) {
            return false;
        }

        return reset($categories);
    }
}
