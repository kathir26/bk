<?php 
class Muvacon_Events_Block_Adminhtml_Events extends Mage_Adminhtml_Block_Widget_Grid_Container {
 
    public function __construct() {
        $this->_controller = 'adminhtml_events';
        $this->_blockGroup = 'events';
		//die('in');
        $this->_headerText = Mage::helper('muvacon_translate')->__('Events List');
		$this->_addButton('add_event', array(
			'label' => Mage::helper('muvacon_translate')->__('Add Event'),
			'onclick' => "setLocation('" . $this->getUrl('*/*/add') . "')",
			'class' => 'add'
		));
        parent::__construct();
		$this->_removeButton('add');
    }
}