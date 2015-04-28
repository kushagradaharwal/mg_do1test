<?php
/**
 * Customer renderer block
 * 
 * @category    Clarion
 * @package     Clarion_AbandonedCarts
 */
class Clarion_AbandonedCarts_Block_Adminhtml_Abandonedcarts_Renderer_Customer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Render customer name
     * @param object $row abandoned cart object
     * @return string image html
     */ 
    public function render(Varien_Object $row)
    {
        if($row->getData($this->getColumn()->getIndex())==""){
            return "guest";
        }
        else{
           return $row->getData($this->getColumn()->getIndex());
        }
    }
}
