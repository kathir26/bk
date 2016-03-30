<?php 
class Muvacon_Partners_Model_PartnersImage extends Mage_Core_Model_Abstract {
 
    public function _construct() {
        parent::_construct();
        $this->_init('partners/partnersImage');
    }
}