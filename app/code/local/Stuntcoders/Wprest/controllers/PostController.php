<?php

class Stuntcoders_Wprest_PostController extends Mage_Core_Controller_Front_Action
{
    public function viewAction()
    {
        if (!Mage::helper('stuntcoders_wprest')->renderPost($this, $this->getRequest()->getParam('post', false))) {
            $this->_forward('noRoute');
        }
    }
}
