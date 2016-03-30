<?php 
class Muvacon_Partners_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction() {
		$this->loadLayout()->_title($this->__('Partners'));
		$block = $this->getLayout()->createBlock(
            'Mage_Core_Block_Template',
            'partners',
            array('template' => 'Partners/content.phtml')
        );
        $this->getLayout()->getBlock('root')->setTemplate('page/1column.phtml');
        $this->getLayout()->getBlock('content')->append($block);
		$storeId		= Mage::app()->getStore()->getID();
		$cId			= '';
		if($this->getRequest()->getParam('name')) {
			$cId		= $this->getRequest()->getParam('name');
		}
		$model		 	= Mage::getModel('partners/partners')->getCollection()->addFieldToFilter('company_language', array('finset' => $storeId))->setOrder('company_position','ASC')->load();
		$modelImage 	= Mage::getModel('partners/partnersImage')->getCollection();
		$modelImage->getSelect()->join( array('partners'=> 'partners'), 'partners.partners_id = main_table.fk_company_id', array('partners.partners_id'), null, 'left')->where('FIND_IN_SET('.$storeId.',partners.company_language)');
		/*$sqlQuery 		= "SELECT DISTINCT `main_table`.*, `image`.* FROM `partners` AS `main_table` LEFT JOIN `partnersimage` AS `image` ON image.fk_company_id = main_table.partners_id";
		$db 			= Mage::getResourceSingleton('core/resource')->getReadConnection();
        $result		 	= $db->query($sqlQuery);
		$collection		= $result->fetchAll(PDO::FETCH_ASSOC);*/
		$partnersImageArray 	= array();
		if (!empty($modelImage) && count($modelImage) > 0) {
			foreach ($modelImage as $modelImgKey => $modelImgValue) {
				$partnersImageArray[$modelImgValue->getFkCompanyId()][]	= $modelImgValue;
			}
		}
		Mage::register('partners_img_collection', $partnersImageArray);
		Mage::register('partners_collection', $model);
		Mage::register('partners_cId', $cId);
        $this->_initLayoutMessages('core/session'); 
        $this->renderLayout();
    }
}