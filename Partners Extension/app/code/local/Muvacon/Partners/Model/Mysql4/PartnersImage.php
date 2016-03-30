<?php 
class Muvacon_Partners_Model_Mysql4_PartnersImage extends Mage_Core_Model_Mysql4_Abstract {
 
    public function _construct() {
        $this->_init('partners/partnersImage', 'image_id');
    }
}