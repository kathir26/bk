<?php 
class Muvacon_Partners_Block_Adminhtml_Partners_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {
 
    public function __construct() {
        parent::__construct();
 
        $this->_objectId = 'id';
        $this->_blockGroup = 'partners';
        $this->_controller = 'adminhtml_partners';
        $this->_mode = 'edit';
		$data = array(
				'label' 	=>  'Back',
				'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/list') . '\')',
				'class'     =>  'back'
		   );
		$this->addButton ('partners_back', $data); 
        $this->_updateButton('save', 'label', Mage::helper('muvacon_partners')->__('Save Partners'));
        $this->_updateButton('delete', 'label', Mage::helper('muvacon_partners')->__('Delete'));
        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('muvacon_partners')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
                ), -100);
				
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('form_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'edit_form');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'edit_form');
                }
            }
 
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
		$this->_removeButton('back');
    }
/*
 * This function is responsible for Including TincyMCE in Head.
 */
    protected function _prepareLayout() {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        }
    } 
 
    public function getHeaderText() {
        if (Mage::registry('partners_data') && Mage::registry('partners_data')->getId()) {
            return Mage::helper('muvacon_partners')->__('Edit Partners "%s"', $this->htmlEscape(Mage::registry('partners_title')));
        } else {
            return Mage::helper('muvacon_partners')->__('Add Partners');
        }
    }
}