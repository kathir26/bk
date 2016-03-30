<?php 
class Muvacon_Testimonials_Block_Adminhtml_Testimonials_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {
 
    protected function _prepareForm() {
 
        if (Mage::registry('testimonials_data')) {
            $data = Mage::registry('testimonials_data')->getData();
        } else {
            $data = array();
        }
 
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
                )
        );
 
        $form->setUseContainer(true);
        $this->setForm($form);
        $form->setValues($data);
        return parent::_prepareForm();
    }
}