<?php

class Stuntcoders_Wprest_Helper_Api extends Mage_Core_Helper_Abstract
{
    public function getUrl($slug, array $query = array())
    {
        return Mage::getUrl($slug, array('_query' => $query));
    }
}
