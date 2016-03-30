<?php 
class Muvacon_Events_Block_Adminhtml_Events_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {
 
    public function __construct() {
        parent::__construct();
        $this->setId('events_tabs');
        $this->setDestElementId('edit_form'); // this should be same as the form id define above
        $this->setTitle(Mage::helper('muvacon_translate')->__('Event Information'));
    }
 
    protected function _beforeToHtml() {
        $this->addTab('form_section', array(
            'label' => Mage::helper('muvacon_translate')->__('Event Information'),
            'title' => Mage::helper('muvacon_translate')->__('Event Information'),
            'content' => $this->getLayout()->createBlock('events/adminhtml_events_edit_tabs_form')->toHtml(),
			'active'    => true
        ));
 
        return parent::_beforeToHtml();
    }
}