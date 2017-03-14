<?php

class Stuntcoders_Wprest_Model_Api_Category extends Stuntcoders_Wprest_Model_Api
{
    const ROUTE = '/wp/v2/categories/:id';

    public function getCollection($params = array())
    {
        return $this->_request($this->_getRoute(), $params);
    }

    public function getMember($id)
    {
        return $this->_request($this->_getRoute($id));
    }

    protected function _getRoute($id = '')
    {
        return str_replace(':id', $id, self::ROUTE);
    }
}
