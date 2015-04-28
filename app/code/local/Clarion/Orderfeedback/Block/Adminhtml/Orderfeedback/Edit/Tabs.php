<?php

class Clarion_Orderfeedback_Block_Adminhtml_Orderfeedback_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('orderfeedback_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('orderfeedback')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('orderfeedback')->__('Item Information'),
          'title'     => Mage::helper('orderfeedback')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('orderfeedback/adminhtml_orderfeedback_edit_tab_form')->toHtml(),
      ));

         
         
      return parent::_beforeToHtml();
  }
}