<?php
class Advanced_OrderSearch_Model_Adminhtml_System_Config_Source_Columnscollection
{
    public function toOptionArray($isMultiselect = null)
    {
      $options = array(
 
						array('value' => 'fname', 'label'=>Mage::helper('ordersearch')->__('First Name')),
						
						array('value' => 'lname', 'label'=>Mage::helper('ordersearch')->__('Last Name')),
						array('value' => 'city', 'label'=>Mage::helper('ordersearch')->__('City')),
						
						array('value' => 'region', 'label'=>Mage::helper('ordersearch')->__('Region')),
						array('value' => 'postco', 'label'=>Mage::helper('ordersearch')->__('Postcode')),
						
						array('value' => 'tphone', 'label'=>Mage::helper('ordersearch')->__('Telephone')),
						array('value' => 'email', 'label'=>Mage::helper('ordersearch')->__('Email')),
                                                array('value' => 'resale', 'label'=>Mage::helper('ordersearch')->__('Resale')),
 

 
        );
 
        if(!$isMultiselect){
 
            array_unshift($options, array('value'=>'', 'label'=>Mage::helper('ordersearch')->__('--Please Select--')));
 
        }
 
        return $options;
 
    }
 
}
