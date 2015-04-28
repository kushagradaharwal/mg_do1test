<?php
class Clarion_Orderfeedback_Block_Adminhtml_Orderfeedback extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_orderfeedback';
    $this->_blockGroup = 'orderfeedback';
    $this->_headerText = Mage::helper('orderfeedback')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('orderfeedback')->__('Add Item');
    parent::__construct();
  }
}