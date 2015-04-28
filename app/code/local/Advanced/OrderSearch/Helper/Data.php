<?php

class Advanced_OrderSearch_Helper_Data extends Mage_Core_Helper_Abstract
{
   public function getCustomgridcolumns()
   {
     return  Mage::getStoreConfig("ordersearch/salescol/gridcolumns");
   }

}