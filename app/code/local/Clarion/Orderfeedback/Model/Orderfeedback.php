<?php

class Clarion_Orderfeedback_Model_Orderfeedback extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('orderfeedback/orderfeedback');
    }
}