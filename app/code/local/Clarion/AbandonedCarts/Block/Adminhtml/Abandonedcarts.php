<?php
/**
 * Grid container block
 * 
 * @category    Clarion
 * @package     Clarion_AbandonedCarts
 * @author      Clarion Magento Team
 * 
 */
class Clarion_AbandonedCarts_Block_Adminhtml_Abandonedcarts extends Mage_Adminhtml_Block_Widget_Grid_Container
{       
    public function __construct()
    {
        /*both these variables tell magento the location of our Grid.php(grid block) file.
         * $this->_blockGroup.'/' . $this->_controller . '_grid'
         * i.e  clarion_abandonedcarts/adminhtml_abandonedcarts_grid
         * $_blockGroup - is your module's name.
         * $_controller - is the path to your grid block. 
         */
        $this->_controller = 'adminhtml_abandonedcarts';
        $this->_blockGroup = 'clarion_abandonedcarts';
        $this->_headerText = Mage::helper('clarion_abandonedcarts')->__('Abandoned Carts');

        parent::__construct();

        $this->_removeButton('add');
    }
  
    protected function _prepareLayout()
    {
        $this->setChild('store_switcher',
            $this->getLayout()->createBlock('adminhtml/store_switcher')
                ->setUseConfirm(false)
                ->setSwitchUrl($this->getUrl('*/*/*', array('store'=>null)))
                ->setTemplate('report/store/switcher.phtml')
        );

        return parent::_prepareLayout();
    }

    public function getStoreSwitcherHtml()
    {
        if (Mage::app()->isSingleStoreMode()) {
            return '';
        }
        return $this->getChildHtml('store_switcher');
    }

    public function getGridHtml()
    {
        return $this->getStoreSwitcherHtml() . parent::getGridHtml();
    }

}