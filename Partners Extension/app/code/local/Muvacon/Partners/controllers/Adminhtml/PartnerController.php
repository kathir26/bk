<?php
 
class Muvacon_Partners_Adminhtml_PartnerController extends Mage_Adminhtml_Controller_Action
{
    public function addAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('partners')
            ->_title($this->__('Add Partners'));
 
        // my stuff
		echo $this->__('Our Add Partners is ready');
        $this->renderLayout();
    }
 
    public function listAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('partners')
            ->_title($this->__('List Partners'));
 
        // my stuff
		echo $this->__('Our List Partners is ready');
        $this->renderLayout();
    }
}