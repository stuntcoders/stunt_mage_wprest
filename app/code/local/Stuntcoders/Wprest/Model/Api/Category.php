<?php

class Stuntcoders_Wprest_Model_Api_Category extends Stuntcoders_Wprest_Model_Api_Abstract
{
    const ROUTE = '/wp/v2/categories/:id';

    protected function _getRoute($id = '')
    {
        return self::ROUTE;
    }
}
