<?php
 
class Kathir_ProductInfo_Adminhtml_ProductInfoController extends Mage_Adminhtml_Controller_Action
{
    public function listAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('productInfo/list')
            ->_title($this->__('List Product Info'));
		$this->_addContent($this->getLayout()->createBlock('productInfo/adminhtml_productInfo'));
        $this->renderLayout();
    }

	public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('productInfo/productInfo');
                $model->setId($this->getRequest()->getParam('id'))
                        ->delete();
				
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/list');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/list');
    }
}