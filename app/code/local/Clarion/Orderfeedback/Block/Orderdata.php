<?php
class Clarion_Orderfeedback_Block_Orderdata extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('orderfeedback/orderdata.phtml');
    }

    
    public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
    
    public function getConnect()
    {
         return  $connect = Mage::getSingleton("core/resource")->getConnection("core_write");
    }
    
    public function getRecord()
    {

    $incid = $this->getIncorderid(); //get value of order from controller to block php file
   
    static  $item_per_page=5;  // per page items value define here 

    $results  =   $this->getConnect()->query("SELECT * FROM orderfeedback where  orderid ='".$incid."'");
   
    $get_total_rows = $results->fetchAll(); //total records
    
   // print_r(count($get_total_rows));
     $pages = ceil(count($get_total_rows)/$item_per_page);
    
    return $pages;
    }
}