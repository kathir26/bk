<?php
class Muvacon_Testimonials_Block_Adminhtml_Testimonials_Renderer_Color extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{
		$color = $row->getData($this->getColumn()->getIndex());
		return '<div style="color:#'.$color.';font-weight:bold;background:#'.$color.';border-radius:8px;width:25%;padding-left: 16px;margin: 0 auto;">'.$color.'</div>';
	}
}