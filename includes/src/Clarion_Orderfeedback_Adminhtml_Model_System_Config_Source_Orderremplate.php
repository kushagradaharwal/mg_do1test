<?php

class Clarion_Orderfeedback_Adminhtml_Model_System_Config_Source_Orderremplate extends Mage_Adminhtml_Model_System_Config_Source_Email_Template
{
   
   public function toOptionArray()
    {
         if(!$collection = Mage::registry('config_system_email_template')) {
            $collection = Mage::getResourceModel('core/email_template_collection')
                ->load();

            Mage::register('config_system_email_template', $collection);
        }
        $options = $collection->toOptionArray();
        $templateName = Mage::helper('orderfeedback')->__('Default Template from Locale');
        $nodeName = str_replace('/', '_', $this->getPath());
        $templateLabelNode = Mage::app()->getConfig()->getNode(self::XML_PATH_TEMPLATE_EMAIL . $nodeName . '/label');
        if ($templateLabelNode) {
            $templateName = Mage::helper('orderfeedback')->__((string)$templateLabelNode);
            $templateName = Mage::helper('orderfeedback')->__('%s (Default Template from Locale)', $templateName);
        }
        array_unshift(
            $options,
            array(
                'value'=> $nodeName,
                'label' => $templateName
            )
        );
        return $options;
}
}