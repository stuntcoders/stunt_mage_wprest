<?php

/**
 * @method Stuntcoders_Wprest_Block_Category setCategory(array $category)
 * @method array getCategory()
 */
class Stuntcoders_Wprest_Block_Category extends Mage_Core_Block_Template
{
    protected function getSlug()
    {
        $category = $this->getCategory();

        return $category['slug'];
    }

    public function getNextPageUrl()
    {
        $api = Mage::getSingleton('stuntcoders_wprest/api_category');
        if (!$api->getNextLink()) {
            return false;
        }

        return $this->getUrl($this->getSlug(), array('_query' => array('page' => $api->getNextPageIndex())));
    }

    public function getPrevPageUrl()
    {
        $api = Mage::getSingleton('stuntcoders_wprest/api_category');
        if (!$api->getPrevLink()) {
            return false;
        }

        return $this->getUrl($this->getSlug(), array('_query' => array('page' => $api->getPrevPageIndex())));
    }

    protected function _toHtml()
    {
        if (!$this->getCategory()) {
            return '';
        }

        if (!$this->getTemplate()) {
            $this->setTemplate('stuntcoders/wprest/category.phtml');
        }

        return parent::_toHtml();
    }
}
