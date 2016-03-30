<?php

class Kathir_Tabapi_Model_Api extends Mage_Api_Model_Resource_Abstract
{   
	public function listapi() {
		$storeId				= Mage::app()->getStore()->getID();
		$collection 			= Mage::getModel('productInfo/productInfo')->getCollection()->setOrder('productInfo_id','DESC')->load();
		$jsonArray				= array();
		if(count($collection) > 0) {
			$el = 0;
			foreach($collection as $key => $value) {
				$jsonArray[$el]['firstname']		= $value->getFirstname();
				$jsonArray[$el]['lastname']			= $value->getLastname();
				$jsonArray[$el]['product_id']		= $value->getFkProductId();
				$jsonArray[$el]['locataion']		= $value->getLocation();
				$jsonArray[$el]['mobile']			= $value->getMobile();
				$jsonArray[$el]['created_at']		= $value->getCreatedDate();
				$el++;
			}
		} else {
			$jsonArray['error']		= "No Result found";
		}
		return json_encode($jsonArray);
	}
}

?>