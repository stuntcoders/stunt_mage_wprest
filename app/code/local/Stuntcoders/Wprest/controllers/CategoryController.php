<?php

class Stuntcoders_Wprest_CategoryController extends Mage_Core_Controller_Front_Action
{
    public function viewAction()
    {
        if (!Mage::helper('stuntcoders_wprest')->renderCategory($this, $this->getRequest()->getParam('posts', false))) {
            $this->_forward('noRoute');
        }
    }
}
