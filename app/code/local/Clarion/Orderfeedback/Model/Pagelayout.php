<?php

class Clarion_Orderfeedback_Model_Pagelayout extends Mage_Core_Model_Abstract
{
   

   public function toOptionArray(){
       return array(
                    array('value' => '1column', 'label'=>Mage::helper('orderfeedback')->__('1column')),
                    array('value' => '2columns-left', 'label'=>Mage::helper('orderfeedback')->__('2columns-left')),
                    array('value' => '2columns-right', 'label'=>Mage::helper('orderfeedback')->__('2columns-right')),
                    array('value' => '3columns', 'label'=>Mage::helper('orderfeedback')->__('3columns')),
                   
        );
    
    
   }    
}