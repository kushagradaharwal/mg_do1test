<?php

class Clarion_Orderfeedback_Helper_Data extends Mage_Core_Helper_Abstract
{

    protected $fieldval; 
    public function getFormurl()
    {
          return Mage::getBaseUrl()."orderfeedback/orderfeedback/submit";
    }
    
     public function getEditurl()
    {
          return Mage::getBaseUrl()."orderfeedback/orderfeedback/edit";
    }
    
    public function correctdate($fromDate)
    {
    $toDateFormat = 'd/m/Y';
    $dateTimestamp = Mage::getModel('core/date')->timestamp(strtotime($fromDate));

   return date($toDateFormat, $dateTimestamp);
    }
    
    public function getFieldenabledisable()
    {
           return Mage::getStoreConfig("orderfeedback/orderfeedback/enable");
    }
    
    public function getEmailtemplateid()
    {
           return Mage::getStoreConfig("orderfeedback/orderfeedback/email_template");
    }
    
     public function getSenderemail()
    {
           return Mage::getStoreConfig("orderfeedback/orderfeedback/sender_email");
    }
   
    public function getSenderename()
    {
           return Mage::getStoreConfig("orderfeedback/orderfeedback/sender_name");
    }
 
    
      public function getDefaultSenderemail()
    {
           return Mage::getStoreConfig("trans_email/ident_general/email");
    }
 
    
      public function getDefaultSendername()
    {
           return Mage::getStoreConfig("trans_email/ident_general/name");
    }
 
   
      public function getEmailsubCustomer()
    {
           return Mage::getStoreConfig("orderfeedback/orderfeedback/email_tempalte_subject_frontend");
    }
 
    
      public function getEmailsubadmin()
    {
           return Mage::getStoreConfig("orderfeedback/orderfeedback/email_tempalte_subject_admin");
    }
 
    
      public function getSucessmessage()
    {
           return Mage::getStoreConfig("orderfeedback/orderfeedback/successmessage");
    }
 
  
      public function getFeedbackpage_title()
    {
           return Mage::getStoreConfig("orderfeedback/orderfeedback/feedbackpage_title");
    }
 
      public function getPagelaoutoption()
    {
           return Mage::getStoreConfig("orderfeedback/orderfeedback/page_layout_option");
    }
 
     public function getOrderViewTabFormurl()
    {
          return Mage::getBaseUrl()."orderfeedback/orderfeedback/submitMyOrderstab";
    }
    
}