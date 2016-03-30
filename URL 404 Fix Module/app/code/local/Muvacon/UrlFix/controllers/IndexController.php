<?php 
require_once Mage::getModuleDir('controllers', 'Mage_Cms').DS.'IndexController.php';
class Muvacon_UrlFix_IndexController extends Mage_Cms_IndexController
{
	public function noRouteAction($coreRoute = null)
    {
		$currentUrl 			= Mage::helper('core/url')->getCurrentUrl();
		$relUrl 				= str_replace(Mage::getBaseUrl(), '', $currentUrl);
		$url 					= Mage::getSingleton('core/url')->parseUrl($currentUrl);
		$path 					= $url->getPath();
		$path					= ltrim($path, "/");
		$getQueryUrl			= $url->getQuery();
		$resource 				= Mage::getSingleton('core/resource');
		$readConnection 		= $resource->getConnection('core_read');
		$storeId 				= Mage::app()->getStore()->getStoreId();
		$query 					= 'select * from ' . $resource->getTableName('core_url_rewrite'). ' where request_path="'.$path.'" limit 1';
		$productResults 		= $readConnection->fetchAll($query);
		$visibility 			= array(
			Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
			Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG
        );
		$urlCatProExists		= $storeCode = $urlexists = "";
		/* get the results */
		if(count($productResults) > 0) {
			foreach($productResults as $proKey => $proValue) {
				$productId			= $proValue['product_id'];
				$goStoreId			= $proValue['store_id'];
				$categoryId			= $proValue['category_id'];
				if($productId > 0) {
					$productObj 	= Mage::getModel('catalog/product')
                        ->getCollection()
                        ->addAttributeToSelect('*')
                        ->addAttributeToFilter('status', array('eq' => '1'))
                        ->addAttributeToFilter('visibility', $visibility)
                        ->addAttributeToFilter('is_saleable', TRUE)
						->addAttributeToFilter('entity_id', array('eq' => $productId));
					if(count($productObj) > 0) {
						$urlCatProExists		= 1;
					}
				} else if($categoryId > 0) {
					$categoryObj 	= Mage::getModel('catalog/category')->getCollection()
						->addAttributeToSelect('*')
						->addAttributeToFilter('is_active', array('eq' => '1'))
						->addAttributeToFilter('entity_id', array('eq' => $categoryId));
					if(count($categoryObj) > 0) {
						$urlCatProExists		= 1;
					}
				}
				if($urlCatProExists == 1) {
					$getStoreInformation 	= Mage::getModel('core/store')->load($goStoreId);
					if(count($getStoreInformation) > 0) {
						if($getQueryUrl != '') {
							$codeUrl = "&";
						} else {
							$codeUrl = "?";
						}
						$storeCode		= $codeUrl."___store=".$getStoreInformation->getCode();
					} else {
						$queryResults		= 'select * from ' . $resource->getTableName('core_url_rewrite'). ' where target_path="'.$proValue['target_path'].'" and store_id= "'.$storeId.'"';
						$productFetResults 	= $readConnection->fetchAll($queryResults);
						if(count($productFetResults) > 0) {
							foreach($productFetResults as $proFeKey => $proFeValue) {
								$urlexists			= $proFeValue['request_path'];
							}
						}
					}
				}
			}
		}
		if($storeCode != '') {
			header('location:'.$currentUrl.$storeCode); die();
		} else if($urlexists != '') {
			$newUrl		= Mage::getBaseUrl().$urlexists;
			if($newUrl) {
				header('location:'.$newUrl); die();
			}
		} else {
			$this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
			$this->getResponse()->setHeader('Status','404 File not found');

			$pageId = Mage::getStoreConfig(Mage_Cms_Helper_Page::XML_PATH_NO_ROUTE_PAGE);
			if (!Mage::helper('cms/page')->renderPage($this, $pageId)) {
				$this->_forward('defaultNoRoute');
			}
		}
    }
	public function noRouteActionOld($coreRoute = null)
    {
		$currentUrl 			= Mage::helper('core/url')->getCurrentUrl();
		$relUrl 				= str_replace(Mage::getBaseUrl(), '', $currentUrl);
		$url 					= Mage::getSingleton('core/url')->parseUrl($currentUrl);
		$path 					= $url->getPath();
		$resource 				= Mage::getSingleton('core/resource');
		$readConnection 		= $resource->getConnection('core_read');
		$storeId 				= Mage::app()->getStore()->getStoreId();
		$query 					= 'select * from ' . $resource->getTableName('catalog_product_entity_varchar'). ' where value="'.$relUrl.'"';
		$productResults 		= $readConnection->fetchAll($query);
		$urlexists				= "";
		/* get the results */
		if(count($productResults) > 0) {
			foreach($productResults as $proKey => $proValue) {
				$productId 				= $proValue['entity_id'];
				$queryUrl				= 'select a.value, a.store_id, b.value from ' . $resource->getTableName('catalog_product_entity_varchar'). ' as a left join ' . $resource->getTableName('catalog_product_entity_int'). ' as b on (b.entity_id = a.entity_id)  where a.entity_id="'.$productId.'" and a.store_id = "'.$storeId.'" and a.attribute_id = "98" and b.attribute_id = "102" and b.value > 1';
				$productResultsUrl		= $readConnection->fetchAll($queryUrl);
				foreach($productResultsUrl as $proUrl => $proUrlVal) {
					$urlexists			= $proUrlVal['value'];
				}
			}
		} else {
			$queryCat 				= 'select * from ' . $resource->getTableName('catalog_category_entity_varchar'). ' where value="'.$relUrl.'"';
			$categoryResults 		= $readConnection->fetchAll($queryCat);
			if(count($categoryResults) > 0) {
				foreach($categoryResults as $proKey => $proValue) {
					$categoryId 			= $proValue['entity_id'];
					$queryUrl				= 'select * from ' . $resource->getTableName('catalog_category_entity_varchar'). ' where entity_id="'.$categoryId.'" and store_id = "'.$storeId.'" and attribute_id = "57"';
					$productResultsUrl		= $readConnection->fetchAll($queryUrl);
					foreach($productResultsUrl as $proUrl => $proUrlVal) {
						$urlexists			= $proUrlVal['value'];
					}
				}
			}
		}
		if($urlexists != '') {
			$newUrl		= Mage::getBaseUrl().$urlexists;
			if($newUrl) {
				header('location:'.$newUrl); die();
			}
		} else {
			$this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
			$this->getResponse()->setHeader('Status','404 File not found');

			$pageId = Mage::getStoreConfig(Mage_Cms_Helper_Page::XML_PATH_NO_ROUTE_PAGE);
			if (!Mage::helper('cms/page')->renderPage($this, $pageId)) {
				$this->_forward('defaultNoRoute');
			}
		}
    }
	
}
?>