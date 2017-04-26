<?php

/**
 * @method StuntCoders_Wprest_Block_Post setPost(array $post)
 * @method array getPost()
 */
class StuntCoders_WpRest_Block_Post extends Mage_Core_Block_Template
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

    public function getFeaturedImage()
    {
        if (!$this->hasData('_featured_image')) {
            $post = $this->getPost();

            if (empty($post['featured_media'])) {
                $this->setData('_featured_image', '');
            } else {
                $media = Mage::getSingleton('stuntcoders_wprest/api_media')->getMember($post['featured_media']);
                $this->setData('_featured_image', $media['source_url']);
            }
        }

        return $this->getData('_featured_image');
    }

    public function getPosts($filter = array())
    {
        $posts = Mage::getSingleton('stuntcoders_wprest/api_post')->getCollection($filter);

        return $posts;
    }
}
