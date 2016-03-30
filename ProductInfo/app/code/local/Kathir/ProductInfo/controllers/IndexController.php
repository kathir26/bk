<?php 
class Kathir_ProductInfo_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction() {
		$errorFormCheck = '';
		if ($data = $this->getRequest()->getPost()) {
			if($productId = $this->getRequest()->getParam('id')) {
				$model = Mage::getModel('productInfo/productInfo');
				foreach ($data as $key => $value) {
					if (is_array($value)) {
						$data[$key] = implode(',',$this->getRequest()->getParam($key));
					}
				}
				$data['fk_product_id']	= $productId;
				$data['created_date']	= date('Y-m-d H:i:s');
				$model->setData($data);
				$redirectUrl = Mage::helper('core/http')->getHttpReferer() ? Mage::helper('core/http')->getHttpReferer()  : Mage::getUrl();
				Mage::app()->getFrontController()->getResponse()->setRedirect($redirectUrl);
				try {
					if($errorFormCheck == '') {
						$model->save();
					}
					Mage::getSingleton('core/session')->addSuccess(Mage::helper('kathir_productInfo')->__('Details was successfully saved.'));
					Mage::getSingleton('core/session')->setFormData(false);
					Mage::app()->getResponse()->sendResponse();
				} catch (Exception $e) {
					Mage::getSingleton('core/session')->addError($e->getMessage());
					Mage::app()->getResponse()->sendResponse();
				}
				return;
			}
		}
		Mage::getSingleton('core/session')->addError(Mage::helper('kathir_productInfo')->__('No data found to save'));
        Mage::app()->getResponse()->sendResponse();
    } 
}