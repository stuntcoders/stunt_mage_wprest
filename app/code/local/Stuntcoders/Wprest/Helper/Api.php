<?php

class Stuntcoders_Wprest_Helper_Api extends Mage_Core_Helper_Abstract
{
    public function getPostTypes()
    {
        return array('type' => array_map(
            'trim',
            explode(',', Mage::getStoreConfig('stuntcoders_wprest/wordpress_options/post_types'))
        ));
    }

    public function getApiEndpoint()
    {
        return Mage::getStoreConfig('stuntcoders_wprest/wordpress_options/api_endpoint');
    }

    public function getUrl($slug, array $query = array())
    {
        return Mage::getUrl($slug, array('_query' => $query));
    }

    public function isHomepage($path)
    {
        return trim($path, '/') === $this->getHomepageSlug();
    }

    public function getHomepageSlug()
    {
        return trim(Mage::getStoreConfig('stuntcoders_wprest/wordpress_options/homepage'), '/');
    }
}
