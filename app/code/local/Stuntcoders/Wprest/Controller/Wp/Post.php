<?php

class Stuntcoders_Wprest_Controller_Wp_Post extends Mage_Core_Controller_Varien_Router_Abstract
{
    public function initControllerRouters($observer)
    {
        $front = $observer->getEvent()->getFront();

        $front->addRouter('stuntcoders_wp_post', $this);
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
            'continue'   => true
        ));

        Mage::dispatchEvent('cms_controller_router_match_before', array(
            'router'    => $this,
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

        $api = Mage::getModel('stuntcoders_wprest/api');
        $posts = $api->getPosts(array('filter' => array('name' => $identifier)));
        if (empty($posts) || !is_array($posts)) {
            return false;
        }

        $request->setModuleName('stuntcoders_wprest')
            ->setControllerName('post')
            ->setActionName('view')
            ->setParam('post_name', $identifier)
            ->setParam('post', reset($posts))
            ->setParam('api', $api);

        $request->setAlias(
            Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
            $identifier
        );

        return true;
    }
}
