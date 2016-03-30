<?php
class Muvacon_CustomSearch_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  /*$this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("CustomSearch"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("customsearch", array(
                "label" => $this->__("CustomSearch"),
                "title" => $this->__("CustomSearch")
		   ));

      $this->renderLayout(); */
	  
	  $this->loadLayout();   
	  $this->getLayout()->getBlock('root')->setTemplate('customsearch/index.phtml');  //changes the root template
	  $this->renderLayout(); 
	  
    }
}