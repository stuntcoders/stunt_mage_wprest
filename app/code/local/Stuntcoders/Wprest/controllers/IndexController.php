<?php

class Stuntcoders_Wprest_IndexController extends Mage_Core_Controller_Front_Action
{
    public function postAction()
    {
        $post = $this->getRequest()->getParam('object', false);

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($post['title']['rendered']);

        $block = $this->getLayout()->createBlock('stuntcoders_wprest/post', 'stuntcoders_wprest_post')
            ->setPost($post);

        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }

    public function pageAction()
    {
        $page = $this->getRequest()->getParam('object', false);

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($page['title']['rendered']);

        $block = $this->getLayout()->createBlock('stuntcoders_wprest/page', 'stuntcoders_wprest_page')
            ->setPage($page);

        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }

    public function categoryAction()
    {
        $category = $this->getRequest()->getParam('object', false);

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($category['name']);

        $block = $this->getLayout()->createBlock('stuntcoders_wprest/category', 'stuntcoders_wprest_category')
            ->setCategory($category);

        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }
}
