<?php 
class Muvacon_Events_Block_Adminhtml_Events_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form {
 
    protected function _prepareForm() {
 
        if (Mage::registry('events_data')) {
            $data = Mage::registry('events_data')->getData();
        } else {
            $data = array();
        }

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('events_events', array('legend' => Mage::helper('muvacon_translate')->__('Event Information')));
        $fieldset->addField('event_name', 'text', array(
            'label' => Mage::helper('muvacon_translate')->__('Event Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'event_name',
        ));
		
		$fieldset->addField('event_language', 'multiselect', array(
            'label' => Mage::helper('muvacon_translate')->__('Language'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'event_language',
			'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true), 
        ));
 
        $fieldset->addField('event_image', 'image', array(
            'label' => Mage::helper('muvacon_translate')->__('Event Image'),
            'class' => 'required-entry',
            'required' => false,
            'name' => 'event_image',
        ));
		
		$fieldset->addField('event_place', 'text', array(
            'label' => Mage::helper('muvacon_translate')->__('Event Place'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'event_place',
        ));
		
		$fieldset->addField('event_start_date', 'date', array(
            'label' => Mage::helper('muvacon_translate')->__('Event Start Date'),
			'image'              => $this->getSkinUrl('images/grid-cal.gif'),
			'format'             => 'MM/dd/yyyy',
			'note'      		=> $this->__('MM/dd/yyyy'),
            'required'  		=> true,
            'name' => 'event_start_date',
			'class'    => 'required-entry validate-date validate-date-range date-range-event_start_date-from',
        ));
		
		$fieldset->addField('event_end_date', 'date', array(
            'label' => Mage::helper('muvacon_translate')->__('Event End Date'),
			'image'              => $this->getSkinUrl('images/grid-cal.gif'),
			'format'             => 'MM/dd/yyyy',
			'note'      		=> $this->__('MM/dd/yyyy'),
            'required'  		=> true,
            'name' => 'event_end_date',
			'class'     => 'required-entry validate-date validate-date-range date-range-event_start_date-to',
        ));
		
		$fieldset->addField('event_banner', 'select', array(
            'label' => Mage::helper('muvacon_translate')->__('Event Banner'),
			'style' => 'width:275px',
            'options' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
            'name' => 'event_banner',
        ));
		
		$fieldset->addField('event_url', 'text', array(
            'label' => Mage::helper('muvacon_translate')->__('Event URL'),
			'maxlength' => '250',
            'name' => 'event_url',
        ));
		
		$fieldset->addField('event_day1', 'text', array(
            'label' => Mage::helper('muvacon_translate')->__('Event Day 1'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'event_day1',
			'note' => '<small>Ex: Mo - Fr 10 - 15 Uhr | Mo 10 - 15 Uhr</small>',
        ));
		
		$fieldset->addField('event_day2', 'text', array(
            'label' => Mage::helper('muvacon_translate')->__('Event Day 2'),
            'name' => 'event_day2',
			'note' => '<small>Ex: Tu 11 - 15 Uhr</small>'
        ));
		
		$fieldset->addField('event_day3', 'text', array(
            'label' => Mage::helper('muvacon_translate')->__('Event Day 3'),
            'name' => 'event_day3',
        ));
		
		$fieldset->addField('event_day4', 'text', array(
            'label' => Mage::helper('muvacon_translate')->__('Event Day 4'),
            'name' => 'event_day4',
        ));
		
		$fieldset->addField('event_day5', 'text', array(
            'label' => Mage::helper('muvacon_translate')->__('Event Day 5'),
            'name' => 'event_day5',
        ));
		
		$fieldset->addField('event_day6', 'text', array(
            'label' => Mage::helper('muvacon_translate')->__('Event Day 6'),
            'name' => 'event_day6',
        ));
		
		$fieldset->addField('event_day7', 'text', array(
            'label' => Mage::helper('muvacon_translate')->__('Event Day 7'),
            'name' => 'event_day7',
        ));
		
		$fieldset->addField('event_position', 'text', array(
            'label' => Mage::helper('muvacon_translate')->__('Position'),
            'class' => '',
            'required' => false,
            'name' => 'event_position',
        ));
		
		$fieldset->addField('event_status', 'select', array(
            'label' => Mage::helper('muvacon_translate')->__('Event Status'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'event_status',
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
 
 
        $fieldset->addField('event_description', 'editor', array(
            'name' => 'event_description',
            'label' => Mage::helper('muvacon_translate')->__('Event Description'),
            'title' => Mage::helper('muvacon_translate')->__('Event Description'),
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