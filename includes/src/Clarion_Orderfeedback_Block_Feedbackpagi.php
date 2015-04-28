<?php
class Clarion_Orderfeedback_Block_Feedbackpagi extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('orderfeedback/feedbackpagi.phtml');
        
      
    }

    
     public function getConnect()
    {
         return  $connect = Mage::getSingleton("core/resource")->getConnection("core_write");
    }
    
    public function setFeedbackcollection()
    {
        
      
        $item_per_page = 5;
         //sanitize post value
        $page_number = filter_var($_POST['page'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

        //validate page number is really numaric
        if(!is_numeric($page_number)){die('Invalid page number!');}

        //get current starting point of records
        $position = ($page_number * $item_per_page);

        
        $results  =   $this->getConnect()->query("SELECT *  FROM orderfeedback where orderid='".$_POST['orderid']."'  ORDER BY orderfeedback_id ASC LIMIT $position, $item_per_page");
   
        $get_total_rows = $results->fetchAll(); //total records
        
        return $get_total_rows;
    }
    
      public function getFeedbackcollection()
    {
      
           return $this->setFeedbackcollection();
     }  
    
}