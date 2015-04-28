<?php

class Clarion_Orderfeedback_Model_Order extends Mage_Sales_Model_Order
{
    public function loadByIncrementId($incrementId)
    {
        
            
        print_r($this->loadByAttribute('increment_id', $incrementId));
    }
    
}