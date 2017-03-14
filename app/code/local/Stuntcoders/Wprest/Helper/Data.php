<?php

class Stuntcoders_Wprest_Helper_Data extends Mage_Core_Helper_Abstract
{
    const BASE_URI_CONFIG_PATH = 'stuntcoders_wprest/general/base_uri';

    /**
     * @param null|string|bool|int|Mage_Core_Model_Store $store
     * @return string
     */
    public function getBaseUri($store = null)
    {
        return Mage::getStoreConfig(self::BASE_URI_CONFIG_PATH, $store);
    }

    public function renderCategory($action, $posts)
    {
        if (empty($posts)) {
            return false;
        }

        $api = $action->getRequest()->getParam('api', false);
        $category = $action->getRequest()->getParam('category', false);
        if (!$api) {
            return false;
        }

        $action->loadLayout();
        if (isset($category['name'])) {
            $action->getLayout()->getBlock('head')->setTitle($category['name']);
        }

        $block = $action->getLayout()
            ->createBlock('stuntcoders_wprest/category', 'stuntcoders_wprest_category')
            ->setPosts($posts)
            ->setCategory($category)
            ->setApi($action->getRequest()->getParam('api', false));

        $action->getLayout()->getBlock('content')->append($block);
        $action->renderLayout();

        return true;
    }
}
