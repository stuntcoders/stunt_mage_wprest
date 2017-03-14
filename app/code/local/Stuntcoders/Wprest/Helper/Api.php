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

    public function getUrl($slug, array $query = array())
    {
        return Mage::getUrl($slug, array('_query' => $query));
    }
}
