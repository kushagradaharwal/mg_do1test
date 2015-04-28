
<?php
class Clarion_Orderfeedback_Block_Allorderfeedback extends Mage_Sales_Block_Order_History
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('orderfeedback/allorderfeedback.phtml');
    }

    
    public function _prepareLayout()
    {
    $title = Mage::helper("orderfeedback")->getFeedbackpage_title();		
    $headBlock = $this->getLayout()->getBlock('head');
    $headBlock->setTitle($title);
    return parent::_prepareLayout();
    }
    
     public function getOrderfeedback()     
     { 
        if (!$this->hasData('orderfeedback')) {
            $this->setData('orderfeedback', Mage::registry('orderfeedback'));
        }
        return $this->getData('orderfeedback');
        
    }
    
    
    
    
}