<?php

class Clarion_Orderfeedback_Model_Allemailtemplate
{
 /**
 * Config xpath to email template node
 *
 */
const XML_PATH_TEMPLATE_EMAIL = 'global/template/email/';
/**
 * Generate list of email templates
 *
 * @return array
 */
public function toOptionArray()
{
    $result = array();
   $asHash="";
    $collection = Mage::getResourceModel('core/email_template_collection')
        ->load();
    $options = $collection->toOptionArray();
    $defOptions = Mage_Core_Model_Email_Template::getDefaultTemplatesAsOptionsArray();
    foreach ($defOptions as $v) {
        $options[] = $v;
    }
    foreach ($options as $v) {
        $result[$v['value']] = $v['label'];
    }
    // sort by names alphabetically
    asort($result);
    if (!$asHash) {
        $options = array();
        $options[] = array('value' => '', 'label' => '----Choose Email Template----');
        foreach ($result as $k => $v) {
            if ($k == '')
                continue;
            $options[] = array('value' => $k, 'label' => $v);
        }

        $result = $options;
    }
    return $result;
}
}