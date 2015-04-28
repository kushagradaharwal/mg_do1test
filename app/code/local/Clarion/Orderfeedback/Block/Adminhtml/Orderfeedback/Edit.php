<?php

class Clarion_Orderfeedback_Block_Adminhtml_Orderfeedback_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->getstylefeedback();         
        $this->_objectId = 'id';
        $this->_blockGroup = 'orderfeedback';
        $this->_controller = 'adminhtml_orderfeedback';
        $this->_updateButton('save', 'label', Mage::helper('orderfeedback')->__('Send Email'));
        $this->_updateButton('delete', 'label', Mage::helper('orderfeedback')->__('Delete Item'));
        		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
        

        
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('orderfeedback_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'orderfeedback_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'orderfeedback_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
            
          
            
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('orderfeedback_data') && Mage::registry('orderfeedback_data')->getId() ) {
                    return Mage::helper('orderfeedback')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('orderfeedback_data')->getTitle()));
        } else {
            return Mage::helper('orderfeedback')->__('Add Item');
        }
    }

  
}