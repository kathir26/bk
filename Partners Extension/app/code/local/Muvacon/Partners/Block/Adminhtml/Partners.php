<?php 
class Muvacon_Partners_Block_Adminhtml_Partners extends Mage_Adminhtml_Block_Widget_Grid_Container {
 
    public function __construct() {
        $this->_controller = 'adminhtml_partners';
        $this->_blockGroup = 'partners';
		//die('in');
        $this->_headerText = Mage::helper('muvacon_partners')->__('Partners List');
       // $this->_addButtonLabel = Mage::helper('muvacon_partners')->__('Add Partners');
		$this->_addButton('add_partner', array(
			'label' => Mage::helper('muvacon_partners')->__('Add Partners'),
			'onclick' => "setLocation('" . $this->getUrl('*/*/add') . "')",
			'class' => 'add'
		));
        parent::__construct();
		$this->_removeButton('add');
    }
}