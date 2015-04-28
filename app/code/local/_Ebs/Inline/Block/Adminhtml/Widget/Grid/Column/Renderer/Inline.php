
<script type="text/javascript">
function updateField(button, fieldId)
{
    new Ajax.Request('<?php echo Mage::helper('adminhtml')->getUrl('*/*/updateTitle') ?>', {
        method: 'post',
        parameters: { id: fieldId, price: $(button).previous('input').getValue() }
    });
}
</script>
            
 <?php
class Ebs_Inline_Block_Adminhtml_Widget_Grid_Column_Renderer_Inline
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Input
{
    public function render(Varien_Object $row)
    {
        $html = parent::render($row);
   
        
        $html .= '<button onclick="updateField(this, '. $row->getId() .'); return false">' . Mage::helper('catalog')->__('Update') . '</button>';
 
        return $html;
    }
 
}
?>
