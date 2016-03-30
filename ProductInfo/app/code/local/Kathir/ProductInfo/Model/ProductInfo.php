<?php 
class Kathir_ProductInfo_Model_ProductInfo extends Mage_Core_Model_Abstract {
 
    public function _construct() {
        parent::_construct();
        $this->_init('productInfo/productInfo');
    }
}