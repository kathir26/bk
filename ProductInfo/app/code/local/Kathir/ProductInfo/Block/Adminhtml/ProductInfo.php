<?php 
class Kathir_ProductInfo_Block_Adminhtml_ProductInfo extends Mage_Adminhtml_Block_Widget_Grid_Container {
 
    public function __construct() {
        $this->_controller = 'adminhtml_productInfo';
        $this->_blockGroup = 'productInfo';
        $this->_headerText = Mage::helper('kathir_productInfo')->__('Product Info List');
        parent::__construct();
		$this->_removeButton('add');
    }
}