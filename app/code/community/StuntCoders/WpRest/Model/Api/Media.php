<?php

class StuntCoders_WpRest_Model_Api_Media extends StuntCoders_WpRest_Model_Api_Abstract
{
    const ROUTE = '/wp/v2/media/:id';

    protected function _getRoute($id = '')
    {
        return self::ROUTE;
    }
}
