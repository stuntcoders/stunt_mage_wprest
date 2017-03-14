<?php

class Stuntcoders_Wprest_Model_Api_Page extends Stuntcoders_Wprest_Model_Api_Abstract
{
    const ROUTE = '/wp/v2/pages/:id';

    protected function _getRoute($id = '')
    {
        return self::ROUTE;
    }
}
