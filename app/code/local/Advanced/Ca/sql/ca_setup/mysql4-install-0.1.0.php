<?php
$installer = $this;
$installer->startSetup();
 
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
 
$entityTypeId     = $setup->getEntityTypeId('customer');
$attributeSetId   = $setup->getDefaultAttributeSetId($entityTypeId);
$attributeGroupId = $setup->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);
 
$setup->addAttribute('customer', 'resale', array(
    'input'         => 'text',
    'type'          => 'varchar',
    'label'         => 'Resale number',
    'visible'       => 1,
    'required'      => 1,
    'user_defined' => 1,
    'global' =>1,
    'visible_on_front'  => 1,
));


$setup->addAttributeToGroup(
 $entityTypeId,
 $attributeSetId,
 $attributeGroupId,
 'resale',
 '999'  //sort_order
);
 
$Attribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'resale');
$Attribute->setData('used_in_forms', array('adminhtml_customer','customer_account_create','customer_account_edit'));
$Attribute->save();

  /**
         * Add field1 column in sales_flat_quote_address table
         **/
        $installer->getConnection()->addColumn(
        $installer->getTable('sales_flat_quote_address'),
        'resale',
        'varchar(200) NULL DEFAULT NULL'
        );
         
        /**
     * Add field1 column in sales_flat_order_address table
     **/
    $installer->getConnection()->addColumn(
    $installer->getTable('sales_flat_order_address'),
        'resale',
        'varchar(200) NULL DEFAULT NULL'
        );
     
    
$installer->endSetup();