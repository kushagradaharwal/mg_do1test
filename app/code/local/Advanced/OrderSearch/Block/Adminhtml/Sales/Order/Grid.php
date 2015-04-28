<?php
class Advanced_OrderSearch_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid
{


	protected function _addColumnFilterToCollection($column)
	{
		if ($this->getCollection()) {
			if ($column->getId() == 'shipping_telephone') {
				$cond = $column->getFilter()->getCondition();
				$field = 't4.telephone';
				$this->getCollection()->addFieldToFilter($field , $cond);
				return $this;
			}else if ($column->getId() == 'shipping_city') {
				$cond = $column->getFilter()->getCondition();
				$field = 't4.city';
				$this->getCollection()->addFieldToFilter($field , $cond);
				return $this;
			}else if ($column->getId() == 'shipping_region') {
				$cond = $column->getFilter()->getCondition();
				$field = 't4.region';
				$this->getCollection()->addFieldToFilter($field , $cond);
				return $this;
			}else if ($column->getId() == 'shipping_postcode') {
				$cond = $column->getFilter()->getCondition();
				$field = 't4.postcode';
				$this->getCollection()->addFieldToFilter($field , $cond);
				return $this;
			}else if($column->getId() == 'product_count'){
				$cond = $column->getFilter()->getCondition();
				$field = ( $column->getFilterIndex() ) ? $column->getFilterIndex() : $column->getIndex();
				$this->getCollection()->getSelect()->having($this->getCollection()->getResource()->getReadConnection()->prepareSqlCondition($field, $cond));
				return $this;
			}else if($column->getId() == 'skus'){
				$cond = $column->getFilter()->getCondition();
				$field = 't6.sku';
				$this->getCollection()->joinSkus();
				$this->getCollection()->addFieldToFilter($field , $cond);
				return $this;
			}else{
				return parent::_addColumnFilterToCollection($column);
			}
		}
	}

	protected function _prepareColumns()
	{     $this->addColumn('real_order_id', array(
            'header'=> Mage::helper('sales')->__('Order #'),
            'width' => '20px',
            'type'  => 'text',
            'index' => 'increment_id',
        ));

            if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'    => Mage::helper('sales')->__('Purchased From (Store)'),
                'index'     => 'store_id',
                'type'      => 'store',
                'store_view'=> true,
                'display_deleted' => true,
            ));
        }
  
        $this->addColumn('resale', array(
            'header' => Mage::helper('sales')->__('Resale'),
            'index' => 'resale',
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('sales')->__('Purchased On'),
            'index' => 'created_at',
            'type' => 'datetime',
            'width' => '100px',
        ));
        
        $this->addColumn('billing_name', array(
            'header' => Mage::helper('sales')->__('Bill to Name'),
            'index' => 'billing_name',
        ));

        $this->addColumn('shipping_name', array(
            'header' => Mage::helper('sales')->__('Ship to Name'),
            'index' => 'shipping_name',
        ));
        
              $this->addColumn('base_grand_total', array(
            'header' => Mage::helper('sales')->__('G.T. (Base)'),
            'index' => 'base_grand_total',
            'type'  => 'currency',
            'currency' => 'base_currency_code',
        ));

        $this->addColumn('grand_total', array(
            'header' => Mage::helper('sales')->__('G.T. (Purchased)'),
            'index' => 'grand_total',
            'type'  => 'currency',
            'currency' => 'order_currency_code',
        ));
    $this->addColumn('status', array(
            'header' => Mage::helper('sales')->__('Status'),
            'index' => 'status',
            'type'  => 'options',
            'width' => '70px',
            'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
        ));
//		$this->addColumnAfter('shipping_description', array(
//				'header' => Mage::helper('sales')->__('Shipping Method'),
//				'index' => 'shipping_description',
//		),'shipping_name'
//		);
//                
                
//		$this->addColumnAfter('method', array(
//				'header' => Mage::helper('sales')->__('Payment Method'),
//				'index' => 'method',
//				'type'  => 'options',
//				'options' => Mage::helper('payment')->getPaymentMethodList()
//		),'shipping_description');

		        //$getallsavecolumns  = array();
				$getallsavecolumns = explode(",",Mage::helper('ordersearch')->getCustomgridcolumns()); 
				
				//echo '<pre>';
				//print_r($getallsavecolumns);
				//die;
				
				if(in_array("fname",$getallsavecolumns))
				{
						$this->addColumn('firstname', array(
						'header' => Mage::helper('ordersearch')->__('First Name'),
						'index' => 'firstname',
						'filter_name' => 'firstname'
                         ));
                }
				
    
				if(in_array("lname",$getallsavecolumns))
					{
					
					$this->addColumn('lastname', array(
					'header' => Mage::helper('ordersearch')->__('Last Name'),
					'index' => 'lastname',
					'filter_name' => 'lastname'
					));
				 }
			 
				 if(in_array("city",$getallsavecolumns))
					{
					   
					$this->addColumnAfter('shipping_city', array(
					'header' => Mage::helper('ordersearch')->__('City'),
					'index' => 'shipping_city',
			),'method');
					}
					
				
				
					if(in_array("region",$getallsavecolumns))
					{
					$this->addColumnAfter('shipping_region', array(
					'header' => Mage::helper('ordersearch')->__('Region'),
					'index' => 'shipping_region',
			),'method');
	
					 }
                
				
					 if(in_array("postco",$getallsavecolumns))
					{
					
						$this->addColumnAfter('shipping_postcode', array(
								'header' => Mage::helper('ordersearch')->__('Postcode'),
								'index' => 'shipping_postcode',
						),'method');
								  
					 }
					 
					 
					 if(in_array("tphone",$getallsavecolumns))
					{
					
							$this->addColumnAfter('shipping_telephone', array(
									'header' => Mage::helper('ordersearch')->__('Telephone'),
									'index' => 'shipping_telephone',
							),'method');
					}
					
						
					if(in_array("email",$getallsavecolumns))
					{
									
							 $this->addColumnAfter('email', array(
								'header' => Mage::helper('ordersearch')->__('Email'),
								'index' => 'email',
						),'method');
								
					 }
//		$this->addColumnAfter('product_count', array(
//				'header' => Mage::helper('sales')->__('Product Count'),
//				'index' => 'product_count',
//				'type' => 'number'
//		),'increment_id');
                
                

//		$this->addColumnAfter('skus', array(
//				'header' => Mage::helper('sales')->__('Product Purchased'),
//				'index' => 'skus',
//		),'increment_id');
                
                
                
		return parent::_prepareColumns();

	}


}