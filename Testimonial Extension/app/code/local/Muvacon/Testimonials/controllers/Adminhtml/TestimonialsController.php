<?php
 
class Muvacon_Testimonials_Adminhtml_TestimonialsController extends Mage_Adminhtml_Controller_Action
{
    public function addAction()
    {
        $this->loadLayout()->_setActiveMenu('testimonials')->_title($this->__('Add Testimonials'));
        $this->_addContent($this->getLayout()->createBlock('testimonials/adminhtml_testimonials_edit'))->_addLeft($this->getLayout()->createBlock('testimonials/adminhtml_testimonials_edit_tabs'));
        $this->renderLayout();
    }
	
    public function listAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('testimonials/list')
            ->_title($this->__('List Testimonials'));
		$this->_addContent($this->getLayout()->createBlock('testimonials/adminhtml_testimonials'));
        $this->renderLayout();
    }

	public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('testimonials/testimonials');
				$model->load((int) $this->getRequest()->getParam('id'));
				$imageToDelete	= $model->getTestimonialsImage();
				$testimonialsTitle		= $model->getTestimonialsName();
				$imageDir	= 'media/' . $imageToDelete;
				$this->deleteImage($imageDir);
                $model->setId($this->getRequest()->getParam('id'))
                        ->delete();
				
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Testimonials was successfully deleted'));
                $this->_redirect('*/*/list');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/list');
    }
	public function deleteImage($path = '') {
		if (file_exists($path)) {
			unlink($path);
		}
		return true;
	}
	public function makeDirectory($path = '') {
		if (!file_exists($path)) {
			@mkdir($path, 0777, true);
		}
		return true;
	}
	public function deleteDir($dirPath) {
		if (! is_dir($dirPath)) {
			throw new InvalidArgumentException("$dirPath must be a directory");
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dirPath);
	}
    public function saveAction() {
 
        $errorFormCheck = '';
		if ($data = $this->getRequest()->getPost())
        {
            $model = Mage::getModel('testimonials/testimonials');
            $id = $this->getRequest()->getParam('id');
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $data[$key] = implode(',',$this->getRequest()->getParam($key));
                }
            }
			$fileArray = array('jpg','jpeg','gif','png');
			if(isset($_FILES['testimonials_image']['name']) && $_FILES['testimonials_image']['name'] != '') {
				try {
					$uploader = new Varien_File_Uploader('testimonials_image');
					$uploader->setAllowedExtensions($fileArray); // or pdf or anything
					$uploader->setAllowRenameFiles(false);
					$uploader->setFilesDispersion(false);
					$path 	= Mage::getBaseDir('media') . '/Muvacon/Testimonials/' ;
					$this->makeDirectory($path);
					$imgType	= end(explode(".", $_FILES['testimonials_image']['name']));
					if(in_array(strtolower($imgType), $fileArray) == false) {
						Mage::getSingleton('adminhtml/session')->addError(Mage::helper('muvacon_translate')->__("Disallowed file types"));
						Mage::getSingleton('adminhtml/session')->setFormData(true);
						if ($id) {
							$this->_redirect('*/*/edit', array('id' => $model->getId()));
						} else {
							$this->_redirect('*/*/add');
						}
						return true;
					}
				} catch(Exception $e) {
					$errorFormCheck = 1;
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('muvacon_translate')->__($e->getMessage()));
					Mage::getSingleton('adminhtml/session')->setFormData(true);
					if ($id) {
						$this->_redirect('*/*/edit', array('id' => $model->getId()));
					} else {
						$this->_redirect('*/*/add');
					}
					return true;
				}
			}
            if ($id) {
				$data['testimonials_updated_date']	= date('Y-m-d H:i:s');
                $model->load($id);
            } else {
				$data['testimonials_created_date']	= date('Y-m-d H:i:s');
			}
            $model->setData($data);
 
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            try {
                if ($id) {
                    $model->setId($id);
                }
				if($errorFormCheck == '') {
					$model->save();
				}
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('muvacon_translate')->__('Error saving testimonials details'));
                }
				if(isset($_FILES['testimonials_image']['name']) && $_FILES['testimonials_image']['name'] != '' && $errorFormCheck == '') {
					$imageName	= $model->getId().".".$imgType;
					$uploader->save($path, $imageName);
					$dataNew['testimonials_image']	= 'Muvacon/Testimonials/'.$imageName;
					$model->load($model->getId());
					$model->addData($dataNew);
					$model->setId($model->getId())->save();
				}
				
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('muvacon_translate')->__('Testimonials was successfully saved.'));
 
                Mage::getSingleton('adminhtml/session')->setFormData(false);
 
                // The following line decides if it is a "save" or "save and continue"
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                } else {
                    $this->_redirect('*/*/list');
                }
 
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                if ($model && $model->getId()) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                } else {
                    $this->_redirect('*/*/list');
                }
            }
 
          return;
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('muvacon_translate')->__('No data found to save'));
        $this->_redirect('*/*/list');
    }
 
 
    public function editAction() {
 
        $id 		= $this->getRequest()->getParam('id', null);
        $model 		= Mage::getModel('testimonials/testimonials');
        if ($id) {
            $model->load((int) $id);
            if ($model->getId()) {
                $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
                if ($data) {
                    $model->setData($data)->setId($id);
                }
				
            } else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('muvacon_translate')->__('Testimonials does not exist'));
                $this->_redirect('*/*/list');
            }
        }
		Mage::register('testimonials_name', $model->getTestimonialsName());
        Mage::register('testimonials_data', $model);
 
        $this->_title($this->__('Testimonials'))->_title($this->__('Edit Testimonials'));
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
 
        $this->_addContent($this->getLayout()->createBlock('testimonials/adminhtml_testimonials_edit'))
                ->_addLeft($this->getLayout()->createBlock('testimonials/adminhtml_testimonials_edit_tabs'));
        $this->renderLayout();
    }  
}