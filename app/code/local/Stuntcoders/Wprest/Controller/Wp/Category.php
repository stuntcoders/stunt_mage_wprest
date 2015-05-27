<?php

class Stuntcoders_Wprest_Controller_Wp_Category extends Mage_Core_Controller_Varien_Router_Abstract
{
    public function initControllerRouters($observer)
    {
        $front = $observer->getEvent()->getFront();

        $front->addRouter('stuntcoders_wp_category', $this);
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
        if (Mage::helper('stuntcoders_wprest/api')->isHomepage($identifier)) {
            $category = array(
                'slug' => Mage::helper('stuntcoders_wprest/api')->getHomepageSlug()
            );
            $filter = array(
                'filter' => array(
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                ),
                'type' => array('post'),
                'page' => $request->getParam('page', 1)
            );
        } else {
            $category = $api->getCategoryBySlug($identifier);
            $filter = array(
                'filter' => array(
                    'category_name' => $identifier
                ),
                'page' => $request->getParam('page', 1)
            );
        }

        $posts = $api->getPosts($filter);
        if (empty($posts)) {
            return false;
        }

        $request->setModuleName('stuntcoders_wprest')
            ->setControllerName('category')
            ->setActionName('view')
            ->setParam('category', $category)
            ->setParam('posts', $posts)
            ->setParam('api', $api);

        $request->setAlias(
            Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
            $identifier
        );

        return true;
    }
}
