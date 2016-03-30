<?php 
class Muvacon_Events_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction() {
		$this->loadLayout()->_title($this->__('Events'));
		$block = $this->getLayout()->createBlock(
            'Mage_Core_Block_Template',
            'events',
            array('template' => 'Events/content.phtml')
        );
        $this->getLayout()->getBlock('root')->setTemplate('page/1column.phtml');
        $this->getLayout()->getBlock('content')->append($block);
		$storeId		= Mage::app()->getStore()->getID();
		$cId			= '';
		if($this->getRequest()->getParam('name')) {
			$cId		= $this->getRequest()->getParam('name');
		}
		$model		 	= Mage::getModel('events/events')->getCollection()->addFieldToFilter('event_language', array('finset' => $storeId))->setOrder('event_position','ASC')->load();
		Mage::register('events_collection', $model);
        $this->_initLayoutMessages('core/session'); 
        $this->renderLayout();
    }
}