<?php
/**
 * @category   Clarion
 * @package    Clarion_AbandonedCarts
 * @created    20th March, 2015
 * @author     Clarion magento team
 * @purpose    Admin manage abandoned carts controller
 */
class Clarion_AbandonedCarts_Adminhtml_AbandonedcartsController extends Mage_Adminhtml_Controller_Action
{
   /**
     * Init actions
     *
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->_title($this->__('Abandoned Carts'));
        
        $this->loadLayout()
            ->_setActiveMenu('sales/clarion_abandonedcarts')
            ->_addBreadcrumb(Mage::helper('clarion_abandonedcarts')->__('Abandoned Carts')
                    , Mage::helper('clarion_abandonedcarts')->__('Abandoned Carts'));
        return $this;
    }
    
    /**
     * Index action method
     */
    public function indexAction() 
    {
    $quote= Mage::getModel('sales/quote')->setStoreId(1)->loadByIdWithoutStore(9);
        /*$items = $quote->getAllItems();
        foreach($items as $item){
            echo $itemId = $item->getId();
        }*/
         $quoteItem = Mage::getModel('sales/quote_item')->load(37);
         $quoteItem->setStoreId(1);
        //$item1 = $quote->getItemById(37);
       // var_dump($quoteItem);
        //$quote->addItem($quoteItem);
       // var_dump($item);
        $productId = 2;
        //$myquoteId = Mage::getModel('sales/quote')->load(9);
        
        //$quote->removeAllItems();
        // echo "<pre>";
      //  print_r($var);
       // print_r(Mage::getSingleton('adminhtml/session_quote'));
      // echo "<pre>";  
        $this->_initAction();
        $this->renderLayout();
    }
    
     /**
     * Export abandoned carts report grid to CSV format
     */
    public function exportAbandonedCsvAction()
    {
        $fileName   = 'abandoned_carts.csv';
        $content    = $this->getLayout()->createBlock('clarion_abandonedcarts/adminhtml_abandonedcarts_grid')
            ->getCsvFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Export abandoned carts report to Excel XML format
     */
    public function exportAbandonedExcelAction()
    {
        $fileName   = 'abandoned_carts.xml';
        $content    = $this->getLayout()->createBlock('clarion_abandonedcarts/adminhtml_abandonedcarts_grid')
            ->getExcelFile($fileName);
       
        $this->_prepareDownloadResponse($fileName, $content);
    }
}