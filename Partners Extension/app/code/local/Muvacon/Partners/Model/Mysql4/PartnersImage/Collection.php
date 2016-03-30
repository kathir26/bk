<?php
class Muvacon_Partners_Model_Mysql4_PartnersImage_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {
	public function _construct()
	{
		//parent::__construct();
		$this->_init('partners/partnersImage');
	}
}