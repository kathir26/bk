<?php 
class Muvacon_Events_Model_Mysql4_Events extends Mage_Core_Model_Mysql4_Abstract {
 
    public function _construct() {
        $this->_init('events/events', 'event_id');
    }
}