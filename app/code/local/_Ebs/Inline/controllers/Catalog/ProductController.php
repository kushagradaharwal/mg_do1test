<?php
include_once("Mage/Adminhtml/controllers/Catalog/ProductController.php");
 

 class Ebs_Inline_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController   
 {
	public function updateTitleAction()
	{
	  $fieldId = (int) $this->getRequest()->getParam('id');
	  $price = $this->getRequest()->getParam('price');
		if ($fieldId) {
			$model =  Mage::getModel('catalog/product')->load($fieldId);
		   
			$model->setPrice($price);
			$model->save();
		}
	}
  
  
  }