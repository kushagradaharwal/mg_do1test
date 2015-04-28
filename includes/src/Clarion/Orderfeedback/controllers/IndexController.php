<?php
class Clarion_Orderfeedback_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
      
      
        $cus_model = Mage::helper('customer')->isLoggedIn(); //if customer is login or not

        if($cus_model)
        {
        $this->loadLayout();
        $getlayout = Mage::helper('orderfeedback')->getPagelaoutoption();
        $this->getLayout()
        ->getBlock('root')->setTemplate('page/'.$getlayout.'.phtml');   
        $this->renderLayout();
        }else{
        $this->_redirect('customer/account/login/');
        }
    }
    
    public function allordersAction()
    {

	$orderfeedback_id =$this->getRequest()->getParams();

   
        if (!$this->getRequest()->isXmlHttpRequest()) {
            $this->_redirect('/');
        }
        
        $this->getResponse()->setBody($this->getLayout()->createBlock('orderfeedback/orderdata')
        ->setOrderid($orderfeedback_id['entity'])
        ->setIncorderid($orderfeedback_id['incid'])        
        ->toHtml());
    }
    
    public function editAction()
    {

	
        $orderfeedback_id =$this->getRequest()->getParams();

        if (!$this->getRequest()->isXmlHttpRequest()) {
            $this->_redirect('/');
        }
        
     
        $this->getResponse()->setBody($this->getLayout()->createBlock('orderfeedback/editorder')
              ->setOrderid($orderfeedback_id['id'])
              ->toHtml());
     
     }
     
     public function submitAction()
    {
      $data = $this->getRequest()->getPost();
	//echo "<pre>";
        //print_r($_POST);
        //die;
        
        $feedbackid = $data['order_hiddenid'];
        $content = $data['content'];
        $model = Mage::getModel('orderfeedback/orderfeedback');		
	$model->setOrderfeedbackId($feedbackid);
        $model->setContent($content);      
	$model->setId($this->getRequest()->getParam('order_hiddenid'));
       
        try {
             $model->save();
       
           Mage::getSingleton('customer/session')->addSuccess(Mage::helper('orderfeedback')->__('Item was successfully saved'));
	   Mage::getSingleton('customer/session')->setFormData(false);
  
        $this->_redirect('orderfeedback/index/');
	return;
        }
        
        catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('orderfeedback')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	
     }
     
     
     public function paginationAction()
     {
            $page  = $_POST['page'];
            $order_id =  $_POST['orderid'];
      
            $this->loadLayout();
            $this->getResponse()->setBody($this->getLayout()->createBlock('orderfeedback/feedbackpagi')
            ->setPaginationval($page)
            ->setOrderidval($order_id)
            ->toHtml());  
     }
          
}