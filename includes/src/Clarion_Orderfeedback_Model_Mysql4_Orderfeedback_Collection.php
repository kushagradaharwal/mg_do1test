<?php

class Clarion_Orderfeedback_Model_Mysql4_Orderfeedback_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('orderfeedback/orderfeedback');
    }
}