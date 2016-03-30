<?php 
//include controller to override it
require_once(Mage::getBaseDir('app') . DS .'code'. DS .'core'. DS .'Mage'. DS .'Contacts'. DS .'controllers'. DS .'IndexController.php');

class Muvacon_Recaptcha_IndexController extends Mage_Contacts_IndexController {
	const XML_PATH_CFC_ENABLED     	= 'recaptcha/recaptcha_group/recaptcha_enabled';
    const XML_PATH_CFC_SITE_KEY  	= 'recaptcha/recaptcha_group/recaptcha_site_key';
    const XML_PATH_CFC_SECRET_KEY 	= 'recaptcha/recaptcha_group/recaptcha_secret_key';
	
	/**
     * Check if "Contacts Form Captcha" is enabled
     */
    public function preDispatch() {
        parent::preDispatch();
    }
	
	public function indexAction() {
        $this->loadLayout();

        $this->getLayout()->getBlock('contactForm')->setFormAction(Mage::getUrl('*/*/post'));
		$enabledCaptcha	= Mage::getStoreConfigFlag(self::XML_PATH_CFC_ENABLED);
        if ($enabledCaptcha) {
            
            //create captcha html-code
            $siteKey 	= Mage::getStoreConfig(self::XML_PATH_CFC_SITE_KEY);
            $secretKey 	= Mage::getStoreConfig(self::XML_PATH_CFC_SECRET_KEY);  
            //small hack for language feature - because it's not working as described in documentation

            $this->getLayout()->getBlock('contactForm')->setCaptchaEnabled($enabledCaptcha)
                                                        ->setCaptchaSiteKey($siteKey)
                                                        ->setCaptchaSecretKey($secretKey);
        }

        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->renderLayout();
    }
	public function postAction() {
        if (Mage::getStoreConfig(self::XML_PATH_CFC_ENABLED)) {
            try {
                $post = $this->getRequest()->getPost();
                $formData = new Varien_Object();
                $formData->setData($post);
                Mage::getSingleton('core/session')->setData('contactForm', $formData);

                if ($post) {
					if(isset($post['g-recaptcha-response']) && $post['g-recaptcha-response'] != '') {
						$url = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".Mage::getStoreConfig(self::XML_PATH_CFC_SECRET_KEY)."&response=".$post['g-recaptcha-response']);
						$newUrl = json_decode($url);
						if ($newUrl->success != 1) {
							throw new Exception($this->__("The reCAPTCHA wasn't entered correctly. Go back and try it again."), 1);
						}
						Mage::getSingleton('core/session')->unsetData('contactForm');
					} else {
						throw new Exception($this->__("Recaptcha is required."), 1);
					}
                }
                else {
                    throw new Exception('', 1);
                }
            }
            catch (Exception $e) {
                if (strlen($e->getMessage()) > 0) {
                    Mage::getSingleton('customer/session')->addError($this->__($e->getMessage()));
                }
                $this->_redirect('*/*/');
                return;
            }
        }

        //everything is OK - call parent action
        parent::postAction();
    }
}