<?php

class StuntCoders_WpRest_Helper_Data extends Mage_Core_Helper_Abstract
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

    /**
     * @param $link
     *
     * @return mixed
     */
    public function getPermaLink($link)
    {
        return Mage::getUrl(
            str_replace($this->getBaseUri(), '', $link)
        );
    }
}
