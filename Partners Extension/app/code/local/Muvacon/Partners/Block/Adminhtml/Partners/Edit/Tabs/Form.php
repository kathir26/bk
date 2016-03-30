<?php 
class Muvacon_Partners_Block_Adminhtml_Partners_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form {
 
    protected function _prepareForm() {
 
        if (Mage::registry('partners_data')) {
            $data = Mage::registry('partners_data')->getData();
        } else {
            $data = array();
        }

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('partners_partners', array('legend' => Mage::helper('muvacon_partners')->__('Company Information')));
		//$fieldset->addType('image', 'Muvacon_Partners_Block_Adminhtml_Partners_Helper_Image');
        $fieldset->addField('company_name', 'text', array(
            'label' => Mage::helper('muvacon_partners')->__('Company Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'company_name',
        ));
		
		$fieldset->addField('company_language', 'multiselect', array(
            'label' => Mage::helper('muvacon_partners')->__('Language'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'company_language',
			'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true), 
        ));
 
        $fieldset->addField('company_logo', 'image', array(
            'label' => Mage::helper('muvacon_partners')->__('Company Logo'),
            'class' => 'required-entry',
            'required' => false,
            'name' => 'company_logo',
        ));
		
		$fieldset->addField('company_position', 'text', array(
            'label' => Mage::helper('muvacon_partners')->__('Position'),
            'class' => '',
            'required' => false,
            'name' => 'company_position',
        ));
		
		$fieldset->addField('company_status', 'select', array(
            'label' => Mage::helper('muvacon_partners')->__('Company Status'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'company_status',
			'values' => array(
					0 => 'Active',
					1 => 'Inactive',
				), 
        ));
		
		/*
         * Editing the form field in wysiwyg editor.
         */
 
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $wysiwygConfig->addData(array('add_variables' => false,
            'add_widgets' => true,
            'add_images' => true,
            'directives_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive'),
            'directives_url_quoted' => preg_quote(Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive')),
            'widget_window_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/widget/index'),
            'files_browser_window_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index'),
            'files_browser_window_width' => (int) Mage::getConfig()->getNode('adminhtml/cms/browser/window_width'),
            'files_browser_window_height' => (int) Mage::getConfig()->getNode('adminhtml/cms/browser/window_height')
        ));
 
 
        $fieldset->addField('company_description', 'editor', array(
            'name' => 'company_description',
            'label' => Mage::helper('muvacon_partners')->__('Company Description'),
            'title' => Mage::helper('muvacon_partners')->__('Company Description'),
            'style' => 'width:800px; height:500px;',
            'config' => $wysiwygConfig,
            'class' => 'required-entry',
            'required' => true,
            'wysiwyg' => true
        ));
 
        $form->setValues($data);
 
        return parent::_prepareForm();
    }
}