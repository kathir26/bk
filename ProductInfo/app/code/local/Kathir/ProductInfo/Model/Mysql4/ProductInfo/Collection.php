<?php
class Kathir_ProductInfo_Model_Mysql4_ProductInfo_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {
	public function _construct()
	{
		//parent::__construct();
		$this->_init('productInfo/productInfo');
	}
	
	public function addStoreFilter($store, $withAdmin = true){

		if ($store instanceof Mage_Core_Model_Store) {
			$store = array($store->getId());
		}

		if (!is_array($store)) {
			$store = array($store);
		}
		$this->addFilter('language', array('finset' => $store));

		return $this;
	}
}