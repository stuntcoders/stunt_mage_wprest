<?php

class Stuntcoders_Wprest_Model_Api_Media extends Stuntcoders_Wprest_Model_Api_Abstract
{
    const ROUTE = '/wp/v2/media/:id';

    protected function _getRoute($id = '')
    {
        return self::ROUTE;
    }
}
