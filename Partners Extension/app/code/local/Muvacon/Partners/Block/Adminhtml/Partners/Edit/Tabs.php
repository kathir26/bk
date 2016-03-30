<?php 
class Muvacon_Partners_Block_Adminhtml_Partners_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {
 
    public function __construct() {
        parent::__construct();
        $this->setId('partners_tabs');
        $this->setDestElementId('edit_form'); // this should be same as the form id define above
        $this->setTitle(Mage::helper('muvacon_partners')->__('Partners Information'));
    }
 
    protected function _beforeToHtml() {
        $this->addTab('form_section', array(
            'label' => Mage::helper('muvacon_partners')->__('Company Information'),
            'title' => Mage::helper('muvacon_partners')->__('Company Information'),
            'content' => $this->getLayout()->createBlock('partners/adminhtml_partners_edit_tabs_form')->toHtml(),
			'active'    => true
        ));
 
        $this->addTab('form_section1', array(
            'label' => Mage::helper('muvacon_partners')->__('Slider Images'),
            'title' => Mage::helper('muvacon_partners')->__('Slider Images'),
            'content' => $this->getLayout()->createBlock('partners/adminhtml_partners_edit_tabs_content')->toHtml(),
			'active'    => false
        ));
 
        return parent::_beforeToHtml();
    }
}