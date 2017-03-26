<?php

class StuntCoders_WpRest_Model_Api_Post extends StuntCoders_Wprest_Model_Api_Abstract
{
    const ROUTE = '/wp/v2/posts/:id';

    protected function _getRoute($id = '')
    {
        return self::ROUTE;
    }
}
