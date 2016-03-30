<?php 
class Muvacon_Testimonials_Block_Adminhtml_Testimonials extends Mage_Adminhtml_Block_Widget_Grid_Container {
 
    public function __construct() {
        $this->_controller = 'adminhtml_testimonials';
        $this->_blockGroup = 'testimonials';
		//die('in');
        $this->_headerText = Mage::helper('muvacon_translate')->__('Testimonials List');
		$this->_addButton('add_testimonials', array(
			'label' => Mage::helper('muvacon_translate')->__('Add Testimonials'),
			'onclick' => "setLocation('" . $this->getUrl('*/*/add') . "')",
			'class' => 'add'
		));
        parent::__construct();
		$this->_removeButton('add');
    }
}