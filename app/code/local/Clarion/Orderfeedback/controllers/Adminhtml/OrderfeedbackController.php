<?php

class Clarion_Orderfeedback_Adminhtml_OrderfeedbackController extends Mage_Adminhtml_Controller_action
{
       protected $adminemail;
       public function gridAction()
        {
        $this->loadLayout();
        $this->getResponse()->setBody(
        $this->getLayout()->createBlock('orderfeedback/adminhtml_orderfeedback_grid')->toHtml()
        );
        }

       
       protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('orderfeedback/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
            
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('orderfeedback/orderfeedback')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('orderfeedback_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('orderfeedback/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
                        $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
          
			$this->_addContent($this->getLayout()->createBlock('orderfeedback/adminhtml_orderfeedback_edit'))
				->_addLeft($this->getLayout()->createBlock('orderfeedback/adminhtml_orderfeedback_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('orderfeedback')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
        
         
        public function newAction() {
		$this->_forward('edit');
	}

 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
            
		$titleid = $data['orderid'];
                    
                $ordermodel = Mage::getModel('sales/order')
                              ->getCollection() 
                              ->addAttributeToFilter('increment_id', $titleid )
                              ->getFirstItem(); 
     

//echo '<pre>';
               //print_r($ordermodel);
              // die;
          
                    if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
							
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS ;
					$uploader->save($path, $_FILES['filename']['name'] );
					
				} catch (Exception $e) {
		      
		        }
	        
		        //this way the name is saved in DB
	  			$data['filename'] = $_FILES['filename']['name'];
			}
	  			
	  			
			$model = Mage::getModel('orderfeedback/orderfeedback');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
                        
              
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
                                
                              
                                
                                    
                                
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
   
        $customer = $ordermodel['customer_firstname'].'&nbsp;'.$ordermodel['customer_lastname']; 
        
        $recipient_emailzero = $ordermodel['customer_email'] ;// recevier email address
        
        $storename = Mage::app()->getStore()->getName();
        
        $logourl = Mage::getDesign()->getSkinUrl('images/logo_email.gif');//('images/logo_email.gif');
        
        
        $recipient_name = $customer; // recevier name
           try {
         
            $emailTemplate  = Mage::getModel('core/email_template')
                        ->loadDefault('order_feedback_email_adminfeedback');                                

            $sender_name =  $senderename;

            $recipient_name = $recipient_name; //reciver name
            
             $recipient_email = array($recipient_emailzero,$senderemail);
            echo Mage::helper("orderfeedback")->getEmailsubadmin();
            //print_r($recipient_email);
            //die;
            //$recipient_email = 'support@magerevol.com';
            
            $sender_email = $senderemail;
            //Create an array of variables to assign to template
            $emailTemplateVariables = array();

            $emailTemplateVariables['sender_name'] = $sender_name;
            $emailTemplateVariables['sender_email'] = $sender_email;
            $emailTemplateVariables['email_subject'] = Mage::helper("orderfeedback")->getEmailsubadmin()."&nbsp;".$data['orderid'];
            $emailTemplateVariables['message'] = $data['content'];
            $emailTemplateVariables['receive_name'] = $recipient_name;
            $emailTemplateVariables['logo_url'] = $logourl;
            $emailTemplateVariables['store_name'] = $storename;
            $emailTemplateVariables['adminfeedback'] =$data['adminfeedback'];
            
            

            $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);

            $email_subject = Mage::helper("orderfeedback")->getEmailsubadmin();
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
        ////////////////////////////////////////////////////
           if( $model->save())
           {
             Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('orderfeedback')->__('Item was successfully saved'));  
           }
           
           Mage::getSingleton('adminhtml/session')->setFormData(false);

                    if ($this->getRequest()->getParam('back')) {
                           $this->_redirect('*/*/edit', array('id' => $model->getId()));
                           return;
                       }
              $this->_redirect('*/*/');
               return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('orderfeedback')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('orderfeedback/orderfeedback');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $orderfeedbackIds = $this->getRequest()->getParam('orderfeedback');
        if(!is_array($orderfeedbackIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($orderfeedbackIds as $orderfeedbackId) {
                    $orderfeedback = Mage::getModel('orderfeedback/orderfeedback')->load($orderfeedbackId);
                    $orderfeedback->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($orderfeedbackIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $orderfeedbackIds = $this->getRequest()->getParam('orderfeedback');
        if(!is_array($orderfeedbackIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($orderfeedbackIds as $orderfeedbackId) {
                    $orderfeedback = Mage::getSingleton('orderfeedback/orderfeedback')
                        ->load($orderfeedbackId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($orderfeedbackIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'orderfeedback.csv';
        $content    = $this->getLayout()->createBlock('orderfeedback/adminhtml_orderfeedback_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'orderfeedback.xml';
        $content    = $this->getLayout()->createBlock('orderfeedback/adminhtml_orderfeedback_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}