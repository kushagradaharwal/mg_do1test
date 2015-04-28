<?php
class Clarion_Orderfeedback_Block_Editorder extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('orderfeedback/editorder.phtml');
    }

    
  public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
    
    
    
}