<?php
/**
 * @category   Clarion
 * @package    Clarion_AbandonedCarts
 * @created    20th March, 2015
 * @author     Clarion magento team
 * @purpose    Abandoned Carts grid block 
 */
class Clarion_AbandonedCarts_Block_Adminhtml_Abandonedcarts_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('gridAbandonedcarts');
        $this->setDefaultSort('updated_at');
        $this->setDefaultDir('DESC');
    }
    
    protected function _prepareCollection()
    {
        /** @var $collection Clarion_AbandonedCarts_Model_Resource_Quote_Collection */
        $collection = Mage::getResourceModel('clarion_abandonedcarts/quote_collection');

        $filter = $this->getParam($this->getVarNameFilter(), array());
        if ($filter) {
            $filter = base64_decode($filter);
            parse_str(urldecode($filter), $data);
        }

        if (!empty($data)) {
            $collection->prepareForAbandonedReport($this->_storeIds, $data);
        } else {
            $collection->prepareForAbandonedReport($this->_storeIds);
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _addColumnFilterToCollection($column)
    {
        $field = ( $column->getFilterIndex() ) ? $column->getFilterIndex() : $column->getIndex();
        $skip = array('subtotal', 'customer_name', 'email', 'entity_id'/*, 'created_at', 'updated_at'*/);

        if (in_array($field, $skip)) {
            return $this;
        }

        parent::_addColumnFilterToCollection($column);
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header'    =>Mage::helper('clarion_abandonedcarts')->__('Cart Id'),
            'index'     =>'entity_id',
            'sortable'  =>false
        ));
        
        $this->addColumn('customer_name', array(
            'header'    =>Mage::helper('clarion_abandonedcarts')->__('Customer Name'),
            'index'     =>'customer_name',
            'sortable'  =>false,
            'renderer'  => 'Clarion_AbandonedCarts_Block_Adminhtml_Abandonedcarts_Renderer_Customer',
        ));

        $this->addColumn('email', array(
            'header'    =>Mage::helper('clarion_abandonedcarts')->__('Email'),
            'index'     =>'email',
            'sortable'  =>false
        ));

        $this->addColumn('items_count', array(
            'header'    =>Mage::helper('clarion_abandonedcarts')->__('Number of Items'),
            'width'     =>'80px',
            'align'     =>'right',
            'index'     =>'items_count',
            'sortable'  =>false,
            'type'      =>'number'
        ));

        $this->addColumn('items_qty', array(
            'header'    =>Mage::helper('clarion_abandonedcarts')->__('Quantity of Items'),
            'width'     =>'80px',
            'align'     =>'right',
            'index'     =>'items_qty',
            'sortable'  =>false,
            'type'      =>'number'
        ));

        if ($this->getRequest()->getParam('website')) {
            $storeIds = Mage::app()->getWebsite($this->getRequest()->getParam('website'))->getStoreIds();
        } else if ($this->getRequest()->getParam('group')) {
            $storeIds = Mage::app()->getGroup($this->getRequest()->getParam('group'))->getStoreIds();
        } else if ($this->getRequest()->getParam('store')) {
            $storeIds = array((int)$this->getRequest()->getParam('store'));
        } else {
            $storeIds = array();
        }
        $this->setStoreIds($storeIds);
        $currencyCode = $this->getCurrentCurrencyCode();

        $this->addColumn('subtotal', array(
            'header'        => Mage::helper('clarion_abandonedcarts')->__('Subtotal'),
            'width'         => '80px',
            'type'          => 'currency',
            'currency_code' => $currencyCode,
            'index'         => 'subtotal',
            'sortable'      => false,
            'renderer'      => 'adminhtml/report_grid_column_renderer_currency',
            'rate'          => $this->getRate($currencyCode),
        ));

        $this->addColumn('coupon_code', array(
            'header'    =>Mage::helper('clarion_abandonedcarts')->__('Applied Coupon'),
            'width'     =>'80px',
            'index'     =>'coupon_code',
            'sortable'  =>false
        ));

        $this->addColumn('created_at', array(
            'header'    =>Mage::helper('clarion_abandonedcarts')->__('Created At'),
            'width'     =>'170px',
            'type'      =>'datetime',
            'index'     =>'created_at',
            'filter_index'=>'main_table.created_at',
            'sortable'  =>false
        ));

        $this->addColumn('updated_at', array(
            'header'    =>Mage::helper('clarion_abandonedcarts')->__('Updated At'),
            'width'     =>'170px',
            'type'      =>'datetime',
            'index'     =>'updated_at',
            'filter_index'=>'main_table.updated_at',
            'sortable'  =>false
        ));

        $this->addColumn('remote_ip', array(
            'header'    =>Mage::helper('clarion_abandonedcarts')->__('IP Address'),
            'width'     =>'80px',
            'index'     =>'remote_ip',
            'sortable'  =>false
        ));

        $this->addExportType('*/*/exportAbandonedCsv', Mage::helper('clarion_abandonedcarts')->__('CSV'));
        $this->addExportType('*/*/exportAbandonedExcel', Mage::helper('clarion_abandonedcarts')->__('Excel XML'));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        if($row->getCustomerId()){
            return $this->getUrl('*/customer/edit', array('id'=>$row->getCustomerId(), 'active_tab'=>'cart'));
        }else{
		   return $this->getUrl('*/sales_order_create/index');
        }
    }
}