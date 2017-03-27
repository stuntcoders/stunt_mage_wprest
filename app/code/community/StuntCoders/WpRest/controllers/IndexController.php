<?php

class StuntCoders_WpRest_IndexController extends Mage_Core_Controller_Front_Action
{
    public function postAction()
    {
        $post = $this->getRequest()->getParam('object', false);

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($post['title']['rendered']);

        $this->getLayout()->getBlock('stuntcoders_wprest_post')->setPost($post);

        $this->renderLayout();
    }

    public function pageAction()
    {
        $page = $this->getRequest()->getParam('object', false);

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($page['title']['rendered']);

        $this->getLayout()->getBlock('stuntcoders_wprest_page')->setPage($page);

        $this->renderLayout();
    }

    public function categoryAction()
    {
        $category = $this->getRequest()->getParam('object', false);

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($category['name']);

        $this->getLayout()->getBlock('stuntcoders_wprest_category')->setCategory($category);

        $this->renderLayout();
    }
}
