<?php
 
class Muvacon_Events_Adminhtml_EventController extends Mage_Adminhtml_Controller_Action
{
    public function addAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('events')
            ->_title($this->__('Add Events'));
 
        // my stuff
		echo $this->__('Our Add Events is ready');
        $this->renderLayout();
    }
 
    public function listAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('events')
            ->_title($this->__('List Events'));
 
        // my stuff
		echo $this->__('Our List Events is ready');
        $this->renderLayout();
    }
}