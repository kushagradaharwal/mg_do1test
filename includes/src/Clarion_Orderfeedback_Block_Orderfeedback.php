<?php
class Clarion_Orderfeedback_Block_Orderfeedback extends Mage_Sales_Block_Order_History
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('orderfeedback/orderfeedback.phtml');
    }

    
    public function _prepareLayout()
    {
        if (Mage::getSingleton("cms/wysiwyg_config")->isEnabled() && ($block = $this->getLayout()->getBlock("head"))) {
        $block->setCanLoadTinyMce(true);
        }
        return parent::_prepareLayout();		
    }
    
     public function getOrderfeedback()     
     { 
        if (!$this->hasData('orderfeedback')) {
            $this->setData('orderfeedback', Mage::registry('orderfeedback'));
        }
        return $this->getData('orderfeedback');
        
    }
    
    
    
    
}