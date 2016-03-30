<?php 
class Muvacon_Partners_Block_Adminhtml_Partners_Edit_Tabs_Content extends Mage_Adminhtml_Block_Template { //Mage_Adminhtml_Block_Widget_Form
 
    public function __construct()
    {
		parent::__construct();
		$this->setTemplate('Partners/gallery.phtml');
    }
	public function getImageTypes()
    {
        $imageTypes = array('jpg','jpeg','gif','png');
        return $imageTypes;
    }
}