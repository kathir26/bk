<?php 
class Muvacon_Events_Block_Adminhtml_Events_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {
 
    public function __construct() {
        parent::__construct();
 
        $this->_objectId = 'id';
        $this->_blockGroup = 'events';
        $this->_controller = 'adminhtml_events';
        $this->_mode = 'edit';
		$this->_updateButton('back', 'onclick', 'setLocation(\'' . $this->getUrl('*/*/list') . '\')');
        $this->_updateButton('save', 'label', Mage::helper('muvacon_translate')->__('Save Event'));
        $this->_updateButton('delete', 'label', Mage::helper('muvacon_translate')->__('Delete'));
        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('muvacon_translate')->__('Save And Continue Edit'),
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
        if (Mage::registry('events_data') && Mage::registry('events_data')->getId()) {
            return Mage::helper('muvacon_translate')->__('Edit Events "%s"', $this->htmlEscape(Mage::registry('event_title')));
        } else {
            return Mage::helper('muvacon_translate')->__('Add Events');
        }
    }
}