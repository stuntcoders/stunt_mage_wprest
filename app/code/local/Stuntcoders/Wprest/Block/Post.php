<?php

class Stuntcoders_Wprest_Block_Post extends Mage_Core_Block_Template
{
    public function _construct()
    {
        $this->setTemplate('stuntcoders/wprest/post.phtml');
        parent::_construct();
    }

    public function getPostTitle()
    {
        if (!$this->hasPost()) {
            return '';
        }

        $post = $this->getPost();

        return isset($post['title']) ? $post['title'] : '';
    }

    public function getPostContent()
    {
        if (!$this->hasPost()) {
            return '';
        }

        $post = $this->getPost();

        return isset($post['content']) ? $post['content'] : '';
    }

    public function getPostUrl()
    {
        if (!$this->hasPost()) {
            return Mage::getUrl();
        }

        $post = $this->getPost();

        return Mage::helper('stuntcoders_wprest/api')->getUrl(isset($post['slug']) ? $post['slug'] : '');
    }

    protected function _toHtml()
    {
        if (!$this->hasPost()) {
            return '';
        }

        return parent::_toHtml();
    }
}
