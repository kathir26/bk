<?php 
class Muvacon_Testimonials_Block_Adminhtml_Testimonials_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form {
 
    protected function _prepareForm() {
 
        if (Mage::registry('testimonials_data')) {
            $data = Mage::registry('testimonials_data')->getData();
        } else {
            $data = array();
        }

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('testimonials_testimonials', array('legend' => Mage::helper('muvacon_translate')->__('Testimonials Information')));
        $fieldset->addField('testimonials_name', 'text', array(
            'label' => Mage::helper('muvacon_translate')->__('Testimonial Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'testimonials_name',
        ));
		
		$fieldset->addField('testimonials_language', 'multiselect', array(
            'label' => Mage::helper('muvacon_translate')->__('Language'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'testimonials_language',
			'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true), 
        ));
 
        $fieldset->addField('testimonials_image', 'image', array(
            'label' => Mage::helper('muvacon_translate')->__('Testimonial Image'),
            'class' => 'required-entry',
            'required' => false,
            'name' => 'testimonials_image',
        ));
		
		$fieldset->addField('testimonials_color', 'text', array(
            'label' => Mage::helper('muvacon_translate')->__('Color Code'),
            'class' => 'required-entry jscolor',
            'required' => true,
            'name' => 'testimonials_color',
        ));
		
		$fieldset->addField('testimonials_position', 'text', array(
            'label' => Mage::helper('muvacon_translate')->__('Position'),
            'class' => '',
            'required' => false,
            'name' => 'testimonials_position',
        ));
		
		$fieldset->addField('testimonials_status', 'select', array(
            'label' => Mage::helper('muvacon_translate')->__('Testimonial Status'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'testimonials_status',
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
 
 
        $fieldset->addField('testimonials_content', 'editor', array(
            'name' => 'testimonials_content',
            'label' => Mage::helper('muvacon_translate')->__('Testimonial Content'),
            'title' => Mage::helper('muvacon_translate')->__('Testimonial Content'),
            'style' => 'width:800px; height:500px;',
            'config' => $wysiwygConfig,
            'class' => 'required-entry',
            'required' => true,
            'wysiwyg' => true
        ));
 
        $form->setValues($data);
 
        return parent::_prepareForm();
    }
	private function escDates() {
        return 'yyyy-MM-dd HH:mm:ss';   
    }
}