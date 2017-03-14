<?php

/**
 * @method Stuntcoders_Wprest_Block_Post setPost(array $post)
 * @method array getPost()
 */
class Stuntcoders_Wprest_Block_Post extends Mage_Core_Block_Template
{
    public function getTitle()
    {
        $post = $this->getPost();

        return $post['title']['rendered'];
    }

    public function getExcerpt()
    {
        $post = $this->getPost();

        return $post['excerpt']['rendered'];
    }

    public function getContent()
    {
        $post = $this->getPost();

        return $post['content']['rendered'];
    }

    public function getPostUrl()
    {
        $post = $this->getPost();

        return $this->getUrl($post['slug']);
    }

    protected function _toHtml()
    {
        if (!$this->getPost()) {
            return '';
        }

        if (!$this->getTemplate()) {
            $this->setTemplate('stuntcoders/wprest/post.phtml');
        }

        return parent::_toHtml();
    }
}
