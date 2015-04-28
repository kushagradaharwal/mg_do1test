<?php
class Gareport_Emailform_ConsultingController extends Mage_Core_Controller_Front_Action
{
      public function indexAction()
    {
    	
		$this->loadLayout();     
		$this->renderLayout();
    }
	
	public function imagecaptchaAction() {
		require_once(Mage::getBaseDir('lib') . DS .'captcha'. DS .'class.simplecaptcha.php');
		$config['BackgroundImage'] = Mage::getBaseDir('lib') . DS .'captcha'. DS . "white.png";
		$config['BackgroundColor'] = "FF0000";
		$config['Height']=30;
		$config['Width']=100;
		$config['Font_Size']=23;
		$config['Font']= Mage::getBaseDir('lib') . DS .'captcha'. DS . "ARLRDBD.TTF";
		$config['TextMinimumAngle']=0;
		$config['TextMaximumAngle']=0;
		$config['TextColor']='000000';
		$config['TextLength']=4;
		$config['Transparency']=80;
		$captcha = new SimpleCaptcha($config);
		$_SESSION['captcha_code'] = $captcha->Code;
	}
	
	
	public function refreshcaptchaAction() {
		$result = Mage::getModel('core/url')->getUrl('*/*/imageCaptcha/') .  now();//rand(5,20);
		echo $result;
	}
	
	
	protected function isValidCaptcha($data) {
	
		if(!isset($_SESSION['captcha_code'])) {
			return false;
		}
		
		$captchaCode = trim($_SESSION['captcha_code']);
		$captchaText = trim($data['captcha_text']);
		if(strtolower($captchaText) != strtolower($captchaCode)) {
			return false;
		}
		return true;

		
	}
	
	public   function submitAction()
	{
	$data = $_POST;
			if($data) try {
				if(!$this->isValidCaptcha($data)) {
					throw new Exception();
				} else {
					
					echo "calling";
				
					Mage::getSingleton('catalog/session')->addSuccess("send successfully");
					$this->_redirect("counslting");
					return;
				}
			} catch (Exception $e) {
				Mage::getSingleton('catalog/session')->addError("error");
                $this->_redirect("home");
                return;
			}
			
	//	echo  '<pre>'; print_r($_POST);
			//$uploadfilename = '';
//			
//			if( !empty($_FILES["attachment"]["name"])) 
//			{
//			
//			$uploadfilename = md5(substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, rand(1,100).rand(1,100))).str_replace(" ","_",$_FILES["attachment"]["name"]); 
//			$source_upl         = $_FILES["attachment"]["tmp_name"];
//			$target_path_upl = Mage::getBaseDir('media').DS.'requestquote'.DS.$uploadfilename;  
//			//if(in_array($image_ext ,$allowed_ext ) ) {
//			@move_uploaded_file($source_upl, $target_path_upl);
//			//	}
//			
//			}
//			
//			$senderName = Mage::getStoreConfig('trans_email/ident_general/name');
//			$senderEmail = Mage::getStoreConfig('trans_email/ident_general/email');
//			
//			$templateId = 4;
//			$sender = Array('name' => $senderName,'email' => $senderEmail);
//			
//			
//			$requestquotesvars = array(
//			'name'     =>  $_POST['name'],
//			'emailreceiver'     =>  $_POST['email'],
//			'address'     =>  $_POST['address'],
//			'telephone'     =>  $_POST['telephone'],
//			'comment'     =>  $_POST['comment']
//			);
//			
//			
//			
//			$emailName = $_POST['name'];
//			
//			$storeId = Mage::app()->getStore()->getId();
//			
//			$companymail = "kushagra.daharwal@hotmail.com";
//			
//			$translate = Mage::getSingleton('core/translate');
//			
//			$transactionalEmail = Mage::getModel('core/email_template');
//			
//			if(file_exists(Mage::getBaseDir('media').DS.'requestquote'.DS.$uploadfilename) )
//			{
//			$transactionalEmail->getMail()
//			->createAttachment(
//			file_get_contents(Mage::getBaseDir('media').DS.'requestquote'.DS.$uploadfilename),
//			Zend_Mime::TYPE_OCTETSTREAM,
//			Zend_Mime::DISPOSITION_ATTACHMENT,
//			Zend_Mime::ENCODING_BASE64,
//			basename($uploadfilename)
//			);
//			}
//			$transactionalEmail->sendTransactional($templateId, $sender, $companymail, $emailName, $requestquotesvars, $storeId);
//			if($translate->setTranslateInline(true))
//			
//			{
//			
//			Mage::getSingleton('core/session')->addSuccess('Email Was Successfully Sent');
//			$this->_redirect('contact_customer');
//			
//			}
//			
	
	}
	
  	
}