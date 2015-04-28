<?php

class Clarion_Orderfeedback_Block_Adminhtml_Orderfeedback_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('orderfeedback_form', array('legend'=>Mage::helper('orderfeedback')->__('Item information')));
     
     $form->setHtmlIdPrefix('orderfeedback');

      $wysiwygConfig = Mage::getSingleton("cms/wysiwyg_config")->getConfig(array("add_variables" => false, "add_widgets" => false,"add_images" => false,"files_browser_window_url"=>$this->getBaseUrl()."admin/cms_wysiwyg_images/index/"));
      $fieldset->addField('orderid', 'text', array(
          'label'     => Mage::helper('orderfeedback')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'orderid',
      ));

     // $fieldset->addField('filename', 'file', array(
          //'label'     => Mage::helper('orderfeedback')->__('File'),
         //// 'required'  => false,
          //'name'      => 'filename',
	 // ));
		
     // $fieldset->addField('status', 'select', array(
          //'label'     => Mage::helper('orderfeedback')->__('Status'),
          //'name'      => 'status',
          //'values'    => array(
              //array(
                  //'value'     => 1,
                //  'label'     => Mage::helper('orderfeedback')->__('Enabled'),
              //),

              //array(
                 // 'value'     => 2,
                 // 'label'     => Mage::helper('orderfeedback')->__('Disabled'),
          //    ),
        //  ),
      //));
     
      $con = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
      
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('orderfeedback')->__('Content'),
          'title'     => Mage::helper('orderfeedback')->__('Content'),
          'style'     => 'width:500px; height:100px;',
          'wysiwyg'   => true,
          'required'  => true,
          //'state' => 'html',
          'config'=> $wysiwygConfig,
      ));
      
      
      $fieldset->addField('adminfeedback', 'editor', array(
          'name'      => 'adminfeedback',
          'label'     => Mage::helper('orderfeedback')->__('Admin Feedback'),
          'title'     => Mage::helper('orderfeedback')->__('Admin Feedback'),
          'style'     => 'width:500px; height:100px;',
          'wysiwyg'   => true,
          'required'  => false,
          'state' => 'html',
          'config'=> $wysiwygConfig,
      ));
     
      //date field added//
    $fieldset->addField('created_time', 'date', array(
    'label' => Mage::helper('orderfeedback')->__('Created Date'),
    'title' => Mage::helper('orderfeedback')->__('Created Date'),
    'tabindex' => 1,
    'name' => 'created_time',
   // 'image' =>   $this->getSkinUrl('images/grid-cal.gif'),
    'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT) ,
    'value' => date( Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT))
    ));



      if ( Mage::getSingleton('adminhtml/session')->getOrderfeedbackData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getOrderfeedbackData());
          Mage::getSingleton('adminhtml/session')->setOrderfeedbackData(null);
      } elseif ( Mage::registry('orderfeedback_data') ) {
          $form->setValues(Mage::registry('orderfeedback_data')->getData());
      }
      return parent::_prepareForm();
  }
}