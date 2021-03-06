<?php

class Muvacon_Search_IndexController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction() {
		$getAllStores	= Mage::app()->getStores();
		foreach($getAllStores as $storeKey => $storeValue) {
			$storeId = $storeValue->getId();
			Mage::app()->setCurrentStore($storeId);
			$cacheId = 'muvacon_search_' . $storeId;
			$collection = Mage::getModel('catalog/product')->getCollection();
			Mage::dispatchEvent('muvacon_search_product_collection_init', array('collection' => $collection));
			$collectionArray	= array();
			$eli				= $ek = 0;
			foreach($collection as $collKey => $collValue) {
				$ratingOb		= Mage::getModel('rating/rating')->getEntitySummary($collValue['entity_id'], $storeId);
				$ratings		= $ratingOb->getSum()/$ratingOb->getCount();
				$collectionArray[$eli]['ratings']		= $ratings;
				/*$groupPrices 	= $productObject->getData('group_price');
				$customerGroupArray 	= array();
				if (!is_null($groupPrices) || is_array($groupPrices)) {
					foreach ($groupPrices as $groupPrice) {  
						$customerGroupArray[$ek]['website_price'] 	= $groupPrice['website_price'];
						$customerGroupArray[$ek]['cust_group'] 		= $groupPrice['cust_group'];
					}

				}*/
				$collectionArray[$eli]['name']			= $collValue['name'];
				$collectionArray[$eli]['url']			= $collValue['url_path'];
				$collectionArray[$eli]['id']			= $collValue['entity_id'];
				$collectionArray[$eli]['image']			= $collValue['image'];
				$collectionArray[$eli]['price']			= $collValue['price'];
				$collectionArray[$eli]['max_price']		= $collValue['max_price'];
				$collectionArray[$eli]['final_price']	= $collValue['final_price'];
				$collectionArray[$eli]['minimal_price']	= $collValue['minimal_price'];
				$collectionArray[$eli]['min_price']		= $collValue['min_price'];
				$collectionArray[$eli]['sku']			= $collValue['sku'];
				//$collectionArray[$eli]['customer']		= $customerGroupArray;
				$eli++;
			}
			$data = json_encode($collectionArray);
			
			$lifetime = Mage::helper('muvacon_search')->getCacheLifetime();
			Mage::app()->saveCache($data, $cacheId, array('block_html'), $lifetime);
		}
		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Reindex saved successfully'));
		$this->_redirectReferer();
	}
}