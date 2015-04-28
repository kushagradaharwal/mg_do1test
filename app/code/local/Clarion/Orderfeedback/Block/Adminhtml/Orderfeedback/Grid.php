<?php

class Clarion_Orderfeedback_Block_Adminhtml_Orderfeedback_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('orderfeedbackGrid');
      $this->setDefaultSort('orderfeedback_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
      $this->setUseAjax(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('orderfeedback/orderfeedback')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }
  
  public function getGridUrl()
    {
    return $this->getUrl('*/*/grid', array('_current'=>'true'));
    }

  protected function _prepareColumns()
  {
      $this->addColumn('orderfeedback_id', array(
          'header'    => Mage::helper('orderfeedback')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'orderfeedback_id',
      ));

      $this->addColumn('orderid', array(
          'header'    => Mage::helper('orderfeedback')->__('Title'),
          'align'     =>'left',
          'index'     => 'orderid',
      ));

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('orderfeedback')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */
      
      $this->addColumn('content', array(
          'header'    => Mage::helper('orderfeedback')->__('Customer Comment'),
          'align'     =>'left',
          'index'     => 'content',
      ));

          
      $this->addColumn('adminfeedback', array(
          'header'    => Mage::helper('orderfeedback')->__('Admin Feedback'),
          'align'     =>'left',
          'index'     => 'adminfeedback',
      ));

//      $this->addColumn('status', array(
//          'header'    => Mage::helper('orderfeedback')->__('Status'),
//          'align'     => 'left',
//          'width'     => '80px',
//          'index'     => 'status',
//          'type'      => 'options',
//          'options'   => array(
//              1 => 'Enabled',
//              2 => 'Disabled',
//          ),
//      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('orderfeedback')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('orderfeedback')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('orderfeedback')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('orderfeedback')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('orderfeedback_id');
        $this->getMassactionBlock()->setFormFieldName('orderfeedback');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('orderfeedback')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('orderfeedback')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('orderfeedback/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('orderfeedback')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('orderfeedback')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}