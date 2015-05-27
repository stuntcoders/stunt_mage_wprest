<?php

class Stuntcoders_Wprest_Block_Category extends Mage_Core_Block_Template
{
    public function _construct()
    {
        $this->setTemplate('stuntcoders/wprest/category.phtml');
        parent::_construct();
    }

    public function getNextPageUrl()
    {
        $api = $this->getApi();
        if (!$api) {
            return '';
        }

        if (!$api->hasNextLink()) {
            return '';
        }

        return Mage::helper('stuntcoders_wprest/api')
            ->getUrl($this->_getCategorySlug(), array('page' => $api->getNextPageIndex()));
    }

    public function getPrevPageUrl()
    {
        $api = $this->getApi();
        if (!$api) {
            return '';
        }

        if (!$api->hasPrevLink()) {
            return '';
        }

        return Mage::helper('stuntcoders_wprest/api')
            ->getUrl($this->_getCategorySlug(), array('page' => $api->getPrevPageIndex()));
    }

    protected function _toHtml()
    {
        if (!$this->hasPosts()) {
            return '';
        }

        return parent::_toHtml();
    }

    protected function _getCategorySlug()
    {
        $category = $this->getCategory();

        return isset($category['slug']) ? $category['slug'] : '';
    }
}
