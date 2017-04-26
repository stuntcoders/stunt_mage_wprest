<?php

class StuntCoders_WpRest_Model_Api_Category extends StuntCoders_WpRest_Model_Api_Abstract
{
    const ROUTE = '/wp/v2/categories/:id';

    protected function _getRoute($id = '')
    {
        return self::ROUTE;
    }
}
