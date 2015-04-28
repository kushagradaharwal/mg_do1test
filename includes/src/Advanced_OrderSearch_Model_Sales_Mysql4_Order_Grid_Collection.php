<?php
class Advanced_OrderSearch_Model_Sales_Mysql4_Order_Grid_Collection extends Mage_Sales_Model_Mysql4_Order_Grid_Collection
{


	public function joinSkus(){
		$sales_flat_order_item = $this->getTable('sales/order_item');
		$this->getSelect()->join(array('t6'=>$sales_flat_order_item),  'main_table.entity_id =t6.order_id and t6.parent_item_id IS NULL',array('sku'=>'t6.sku'));
	}
	protected function _beforeLoad()
	{

		$sales_flat_order = $this->getTable('sales/order');
		$sales_flat_order_payment = $this->getTable('sales/order_payment');
	        $sales_flat_order_address = $this->getTable('sales/order_address');
		$sales_flat_order_item = $this->getTable('sales/order_item');
                
		//Shipping Method
		$this->getSelect()->join(array('t2'=>$sales_flat_order),  'main_table.entity_id =t2.entity_id',array('shipping_description'=>'t2.shipping_description'));

		//Payment Method
		$this->getSelect()->join(array('t3'=>$sales_flat_order_payment),  'main_table.entity_id =t3.parent_id',array('method'=>'t3.method'));


		$where = "t4.address_type = 'shipping'";
		//Shipping Address Fields
		$this->getSelect()->join(array('t4'=>$sales_flat_order_address),  'main_table.entity_id =t4.parent_id',array('shipping_telephone'=>'t4.telephone','shipping_region'=>'t4.region','shipping_postcode'=>'t4.postcode','shipping_city'=>'t4.city','email'=>'t4.email','resale'=>'t4.resale'));
		//echo '<pre>';
                //print_r($this->getSelect()->join(array('t4'=>$sales_flat_order_address),  'main_table.entity_id =t4.parent_id',array('shipping_telephone'=>'t4.telephone','shipping_region'=>'t4.region','shipping_postcode'=>'t4.postcode','shipping_city'=>'t4.city','email'=>'t4.email','resale'=>'t4.resale')));
                //die;
                $this->getSelect()->where($where);

		//Product Count
		$this->getSelect()->join(array('t5'=>$sales_flat_order_item),  'main_table.entity_id =t5.order_id and t5.parent_item_id IS NULL',array('product_count'=>new Zend_Db_Expr('count(t5.item_id)')));
		$this->getSelect()->group(array('t5.order_id'));
                
                //code to call customer first name and lastname.
                $fn = Mage::getModel('eav/entity_attribute')->loadByCode('1', 'firstname');
                $ln = Mage::getModel('eav/entity_attribute')->loadByCode('1', 'lastname');
                $cust_entitytable = Mage::getSingleton("core/resource")->getTableName("customer_entity_varchar");
                
                $this->getSelect()
                ->join(array('ce1' => $cust_entitytable), 'ce1.entity_id=main_table.customer_id', array('firstname' => 'value'))
                ->where('ce1.attribute_id='.$fn->getAttributeId())
                ->join(array('ce2' => $cust_entitytable), 'ce2.entity_id=main_table.customer_id', array('lastname' => 'value'))
                ->where('ce2.attribute_id='.$ln->getAttributeId())
                ->columns(new Zend_Db_Expr("CONCAT(`ce1`.`value`, ' ',`ce2`.`value`) AS customer_name"));
                
                
                
                

//code ended  to call customer first name and lastname.
		//echo $this->getSelect();die;
		return parent::_beforeLoad();
	}
	public function _afterLoad(){

		foreach($this as $object){
			$order_id = $object->getEntityId();

			$sales_flat_order_item = $this->getTable('sales/order_item');

			$adapter = $this->getResource()->getReadConnection();
			$select = $adapter->select()->from($sales_flat_order_item,array('sku'))->where("order_id = $order_id and parent_item_id IS NULL");
			$rows = $adapter->fetchAll($select);
			$skus = '';
			foreach($rows as $row){
				$skus .= $row['sku'].',';
			}
			$skus = substr($skus, 0,-1);
			$object->setSkus($skus);
		}

		return parent::_afterLoad();
	}
}
