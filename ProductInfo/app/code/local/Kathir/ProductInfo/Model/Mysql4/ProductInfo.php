<?php 
class Kathir_ProductInfo_Model_Mysql4_ProductInfo extends Mage_Core_Model_Mysql4_Abstract {
 
    public function _construct() {
        $this->_init('productInfo/productInfo', 'productInfo_id');
    }
}