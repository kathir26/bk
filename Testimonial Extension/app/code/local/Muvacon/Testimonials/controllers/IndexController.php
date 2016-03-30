<?php 
class Muvacon_Testimonials_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction() {
		$this->loadLayout()->_title($this->__('Testimonials'));
		$block = $this->getLayout()->createBlock(
            'Mage_Core_Block_Template',
            'testimonials',
            array('template' => 'Testimonials/content.phtml')
        );
        $this->getLayout()->getBlock('root')->setTemplate('page/1column.phtml');
        $this->getLayout()->getBlock('content')->append($block);
		$storeId		= Mage::app()->getStore()->getID();
		$cId			= '';
		if($this->getRequest()->getParam('name')) {
			$cId		= $this->getRequest()->getParam('name');
		}
		$model		 	= Mage::getModel('testimonials/testimonials')->getCollection()->addFieldToFilter('testimonials_language', array('finset' => $storeId))->setOrder('testimonials_position','ASC')->load();
		Mage::register('testimonials_collection', $model);
        $this->_initLayoutMessages('core/session'); 
        $this->renderLayout();
    }
}