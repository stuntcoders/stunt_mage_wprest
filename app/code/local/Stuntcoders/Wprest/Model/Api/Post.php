<?php

class Stuntcoders_Wprest_Model_Api_Post extends Stuntcoders_Wprest_Model_Api_Abstract
{
    const ROUTE = '/wp/v2/posts/:id';

    protected function _getRoute($id = '')
    {
        return self::ROUTE;
    }
}
