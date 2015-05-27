<?php

class Stuntcoders_Wprest_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function renderPost($action, $post)
    {
        if (empty($post)) {
            return false;
        }

        $action->loadLayout();
        if (isset($post['title'])) {
            $action->getLayout()->getBlock('head')->setTitle($post['title']);
        }

        $block = $action->getLayout()
            ->createBlock('stuntcoders_wprest/post', 'stuntcoders_wprest_post')
            ->setPost($post)
            ->setApi($action->getRequest()->getParam('api', false));

        $action->getLayout()->getBlock('content')->append($block);
        $action->renderLayout();

        return true;
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
