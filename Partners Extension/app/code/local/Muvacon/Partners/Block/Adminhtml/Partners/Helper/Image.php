<?php 
class Muvacon_Partners_Block_Adminhtml_Partners_Helper_Image extends Varien_Data_Form_Element_Image{
    //make your renderer allow "multiple" attribute
    public function getHtmlAttributes(){
        return array_merge(parent::getHtmlAttributes(), array('multiple'));
    }
	public function getElementHtml() {
		$html = '';
		if ($this->getValue()) {           
			$media = Mage::getBaseUrl('media').'Muvacon/Partners/Logos/';
			$html = '<a onclick="imagePreview(\''.$this->getHtmlId().'_image\'); return false;" href="'.$this->getValue().'"><img id="'.$this->getHtmlId().'_image" style="border: 1px solid #d6d6d6;" class="small-image-preview v-middle" title="'.$this->getValue().'" src="'.$media.$this->getValue().'" alt="'.$this->getValue().'" width="22"></a> ';
		}
		$this->setClass('input-file');
		$html .= parent::getElementHtml();
		return $html;
	} 
}