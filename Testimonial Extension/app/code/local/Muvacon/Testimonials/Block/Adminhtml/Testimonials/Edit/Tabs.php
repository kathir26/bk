<?php 
class Muvacon_Testimonials_Block_Adminhtml_Testimonials_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {
 
    public function __construct() {
        parent::__construct();
        $this->setId('testimonials_tabs');
        $this->setDestElementId('edit_form'); // this should be same as the form id define above
        $this->setTitle(Mage::helper('muvacon_translate')->__('Testimonials Information'));
    }
 
    protected function _beforeToHtml() {
        $this->addTab('form_section', array(
            'label' => Mage::helper('muvacon_translate')->__('Testimonials Information'),
            'title' => Mage::helper('muvacon_translate')->__('Testimonials Information'),
            'content' => $this->getLayout()->createBlock('testimonials/adminhtml_testimonials_edit_tabs_form')->toHtml(),
			'active'    => true
        ));
 
        return parent::_beforeToHtml();
    }
}