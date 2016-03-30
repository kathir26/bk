<?php
 
class Muvacon_Testimonials_Adminhtml_TestimonialController extends Mage_Adminhtml_Controller_Action
{
    public function addAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('testimonials')
            ->_title($this->__('Add Testimonials'));
 
        // my stuff
		echo $this->__('Our Add Testimonials is ready');
        $this->renderLayout();
    }
 
    public function listAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('testimonials')
            ->_title($this->__('List Testimonials'));
 
        // my stuff
		echo $this->__('Our List Testimonials is ready');
        $this->renderLayout();
    }
}