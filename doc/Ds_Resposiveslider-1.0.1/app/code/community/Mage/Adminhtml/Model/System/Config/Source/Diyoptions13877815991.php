<?php
class Mage_Adminhtml_Model_System_Config_Source_Diyoptions13877815991
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
		
            array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('horizontal')),
            array('value' => 2, 'label'=>Mage::helper('adminhtml')->__('vertical')),
            array('value' => 3, 'label'=>Mage::helper('adminhtml')->__('fade')),
        );
    }

}
