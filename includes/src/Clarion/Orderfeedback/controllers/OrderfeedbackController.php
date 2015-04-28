<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Directory
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Currency controller
 *
 * @category   Mage
 * @package    Mage_Directory
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Clarion_Orderfeedback_OrderfeedbackController extends Mage_Core_Controller_Front_Action
{
  
    
    public function viewAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

  
    public function submitAction(){
     if ($data = $this->getRequest()->getPost())
     {  			
	
      
        $collection  = Mage::getModel('orderfeedback/orderfeedback')->getCollection();
        $orderid = array();
        foreach($collection as $value)
        {
        $orderid['orderid'] =  $value['orderid'];   

        }

        $model = Mage::getModel('orderfeedback/orderfeedback');
        if($data['created_time'] != NULL )
        {
        $toDateFormat = 'd/m/Y';
        $dateTimestamp = Mage::getModel('core/date')->timestamp(strtotime($data['created_time']));
        $model->setCreatedTime($toDateFormat, $dateTimestamp);
        }

        $model->setData($data)
            ->setId($this->getRequest()->getParam('id'));

        
         
        /////////////////email functinality /////////////////
        
     
        
        if(Mage::helper("orderfeedback")->getSenderemail())
        {
             $senderemail = Mage::helper("orderfeedback")->getSenderemail();
        }else{
             $senderemail = Mage::helper("orderfeedback")->getDefaultSenderemail();
        }
        
        if(Mage::helper("orderfeedback")->getSenderename())
        {
             $senderename = Mage::helper("orderfeedback")->getSenderename();
        }else{
             $senderename = Mage::helper("orderfeedback")->getDefaultSendername();
        }
         
      // echo $logourl = Mage::getSkinUrl();//('images/logo_email.gif');
   
        $customer = $data['fullname'];
        
        $recipient_emailzero = $data['customeremail']; // recevier email address
        
        $storename = Mage::app()->getStore()->getName();
        
        $logourl = Mage::getDesign()->getSkinUrl('images/logo_email.gif');//('images/logo_email.gif');
        
        
        $recipient_name = $customer; // recevier name
           try {
         
            $emailTemplate  = Mage::getModel('core/email_template')
                        ->loadDefault('order_feedback_email_customer');                                

            $sender_name =  $senderename;

            $recipient_name = $recipient_name; //reciver name
            
            $reci_one =  $senderemail;
            $recipient_email = array($recipient_emailzero,$reci_one);
            
            //print_r($recipient_email);
            //die;
            //$recipient_email = 'support@magerevol.com';
            
            $sender_email = $senderemail;
            //Create an array of variables to assign to template
            $emailTemplateVariables = array();

            $emailTemplateVariables['sender_name'] = $sender_name;
            $emailTemplateVariables['sender_email'] = $sender_email;
            $emailTemplateVariables['email_subject'] = Mage::helper("orderfeedback")->getEmailsubCustomer();
            $emailTemplateVariables['message'] = $data['content'];
            $emailTemplateVariables['receive_name'] = $recipient_name;
            $emailTemplateVariables['logo_url'] = $logourl;
            $emailTemplateVariables['store_name'] = $storename;
            
            

            $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);

            $email_subject = Mage::helper("orderfeedback")->getEmailsubCustomer();
            /*
             * Or you can send the email directly,
             * note getProcessedTemplate is called inside send()
             */
            $emailTemplate->setSenderName($sender_name);
            $emailTemplate->setSenderEmail($sender_email);
            $emailTemplate->setTemplateSubject($email_subject);
            $emailTemplate->send($recipient_email, $recipient_name, $emailTemplateVariables);
            $emailed = true;
            } catch(Exception $e) {
                Mage::getSingleton('core/session')->addError(Mage::helper('orderfeedback')->__('Unable to send message at this time. Please, try later.'));
                $this->_redirectReferer();
                return;
            }
            if($emailed)
            {
            $success_message = Mage::helper("orderfeedback")->getSucessmessage();
            Mage::getSingleton('core/session')->addSuccess(Mage::helper('orderfeedback')->__($success_message));
            }
        /////////////////email functinality /////////////////
        if($model->save())
        {
        Mage::getSingleton('core/session')->addSuccess(Mage::helper('orderfeedback')->__('Item was successfully saved'));
        }              }
       $this->_redirect("orderfeedback/index/index/");
     }


      public function submitMyOrderstabAction(){
     if ($data = $this->getRequest()->getPost())
     {  			
	
      
        $collection  = Mage::getModel('orderfeedback/orderfeedback')->getCollection();
        $orderid = array();
        foreach($collection as $value)
        {
        $orderid['orderid'] =  $value['orderid'];   

        }

        $model = Mage::getModel('orderfeedback/orderfeedback');
        if($data['created_time'] != NULL )
        {
        $toDateFormat = 'd/m/Y';
        $dateTimestamp = Mage::getModel('core/date')->timestamp(strtotime($data['created_time']));
        $model->setCreatedTime($toDateFormat, $dateTimestamp);
        }

        $model->setData($data)
            ->setId($this->getRequest()->getParam('id'));

        
         
        /////////////////email functinality /////////////////
        
     
        
        if(Mage::helper("orderfeedback")->getSenderemail())
        {
             $senderemail = Mage::helper("orderfeedback")->getSenderemail();
        }else{
             $senderemail = Mage::helper("orderfeedback")->getDefaultSenderemail();
        }
        
        if(Mage::helper("orderfeedback")->getSenderename())
        {
             $senderename = Mage::helper("orderfeedback")->getSenderename();
        }else{
             $senderename = Mage::helper("orderfeedback")->getDefaultSendername();
        }
         
      // echo $logourl = Mage::getSkinUrl();//('images/logo_email.gif');
   
        $customer = $data['fullname'];
        
        $recipient_emailzero = $data['customeremail']; // recevier email address
        
        $storename = Mage::app()->getStore()->getName();
        
        $logourl = Mage::getDesign()->getSkinUrl('images/logo_email.gif');//('images/logo_email.gif');
        
        
        $recipient_name = $customer; // recevier name
           try {
         
            $emailTemplate  = Mage::getModel('core/email_template')
                        ->loadDefault('order_feedback_email_customer');                                
            $sender_name =  $senderename;
            $recipient_name = $recipient_name; //reciver name
            $reci_one =  $senderemail;
            $recipient_email = array($recipient_emailzero,$reci_one);
            $sender_email = $senderemail;
            //Create an array of variables to assign to template
            $emailTemplateVariables = array();
            $emailTemplateVariables['sender_name'] = $sender_name;
            $emailTemplateVariables['sender_email'] = $sender_email;
            $emailTemplateVariables['email_subject'] = Mage::helper("orderfeedback")->getEmailsubCustomer();
            $emailTemplateVariables['message'] = $data['content'];
            $emailTemplateVariables['receive_name'] = $recipient_name;
            $emailTemplateVariables['logo_url'] = $logourl;
            $emailTemplateVariables['store_name'] = $storename;
            $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);

            $email_subject = Mage::helper("orderfeedback")->getEmailsubCustomer();
            /*
             * Or you can send the email directly,
             * note getProcessedTemplate is called inside send()
             */
            $emailTemplate->setSenderName($sender_name);
            $emailTemplate->setSenderEmail($sender_email);
            $emailTemplate->setTemplateSubject($email_subject);
            $emailTemplate->send($recipient_email, $recipient_name, $emailTemplateVariables);
            $emailed = true;
            } catch(Exception $e) {
                Mage::getSingleton('core/session')->addError(Mage::helper('orderfeedback')->__('Unable to send message at this time. Please, try later.'));
                $this->_redirectReferer();
                return;
            }
           // }//if email enabled
            
            if($emailed)
            {
            $success_message = Mage::helper("orderfeedback")->getSucessmessage();
            Mage::getSingleton('core/session')->addSuccess(Mage::helper('orderfeedback')->__($success_message));
            //$this->_redirectReferer();
           // return;
            }
            
        /////////////////email functinality /////////////////
        
        if($model->save())
        {
        Mage::getSingleton('core/session')->addSuccess(Mage::helper('orderfeedback')->__('Item was successfully saved'));
        }              }
       $coreoid =  $data['ordercoreid']; //current feedback order id
       
       $returnurl = Mage::getUrl("orderfeedback/orderfeedback/view/").'?order='.$coreoid;
       
       //echo $this->_redirectUrl("orderfeedback/orderfeedback/view/");
       //die;
       $this->_redirectUrl($returnurl);
     }

     
}