<?php

/**
 * @method StuntCoders_Wprest_Block_Category setCategory(array $category)
 * @method array getCategory()
 */
class StuntCoders_Wprest_Block_Category extends Mage_Core_Block_Template
{
    /**
     * @return string
     */
    protected function getSlug()
    {
        $category = $this->getCategory();

        return $category['slug'];
    }

    /**
     * @return array
     */
    public function getPosts()
    {
        return $this->getData('_posts');
    }

    /**
     * @return false|string
     */
    public function getNextPageUrl()
    {
        $api = Mage::getSingleton('stuntcoders_wprest/api_post');
        if ($api->getCurrentPage() >= $api->getTotalPages()) {
            return false;
        }

        return $this->getUrl($this->getSlug(), array('_query' => array('page' => $api->getNextPageIndex())));
    }

    /**
     * @return false|string
     */
    public function getPrevPageUrl()
    {
        $api = Mage::getSingleton('stuntcoders_wprest/api_post');
        if ($api->getCurrentPage() <= 1) {
            return false;
        }

        return $this->getUrl($this->getSlug(), array('_query' => array('page' => $api->getPrevPageIndex())));
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->getCategory()) {
            return '';
        }

        if (!$this->getTemplate()) {
            $this->setTemplate('stuntcoders/wprest/category.phtml');
        }

        $this->_fetchPosts();

        return parent::_toHtml();
    }

    protected function _fetchPosts()
    {
        if (!$this->getData('_posts')) {
            $category = $this->getCategory();
            $posts = Mage::getSingleton('stuntcoders_wprest/api_post')->getCollection(array(
                'categories' => $category['id'],
                'page' => Mage::app()->getRequest()->getParam('page', 1),
            ));

            $this->setData('_posts', $posts);
        }
    }
}
