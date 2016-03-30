<?php
 
class Muvacon_Partners_Adminhtml_PartnersController extends Mage_Adminhtml_Controller_Action
{
    public function addAction()
    {
        $this->loadLayout()->_setActiveMenu('partners')->_title($this->__('Add Partners'));
        $this->_addContent($this->getLayout()->createBlock('partners/adminhtml_partners_edit'))->_addLeft($this->getLayout()->createBlock('partners/adminhtml_partners_edit_tabs'));
		//echo $this->__('Our Add Partners is ready');
        $this->renderLayout();
    }
	
    public function listAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('partners/list')
            ->_title($this->__('List Partners'));
		$this->_addContent($this->getLayout()->createBlock('partners/adminhtml_partners'));
		//echo $this->__('Our List Partners is ready');
        $this->renderLayout();
    }

	public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('partners/partners');
				$modelImage = Mage::getModel('partners/partnersImage');
				$collection = $modelImage->getCollection()->addFilter('fk_company_id', (int) $this->getRequest()->getParam('id'));
				$collection->walk('delete');
				$imageDir	= 'media/Muvacon/Partners/Sliders/' . $this->getRequest()->getParam('id');
				$this->deleteDir($imageDir);
                $model->setId($this->getRequest()->getParam('id'))
                        ->delete();
				
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/list');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/list');
    }
	public function deleteImageAction() {
        if ($this->getRequest()->getParam('delId') > 0) {
            $imageDelId = $this->getRequest()->getParam('delId');
			$modelImage = Mage::getModel('partners/partnersImage');
			try {
				$collection = Mage::getModel('partners/partnersImage')->getCollection()->addFilter('image_id', (int) $imageDelId);
				foreach($collection as $imag => $imagVal) {
					$imagePath	= 'media/Muvacon/Partners/Sliders/' . $imagVal->getFkCompanyId() . '/' . $imagVal->getImageName();
					$modelImage->setId($imageDelId)->delete();
					if(file_exists($imagePath)) {
						unlink(Mage::getBaseDir('media') . '/Muvacon/Partners/Sliders/' . $imagVal->getFkCompanyId() . '/' . $imagVal->getImageName());
					}
				}
				echo "Slider image deleted successfully.";

			} catch (Exception $e){
				echo $e->getMessage(); 
			}
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
            $model = Mage::getModel('partners/partners');
            $id = $this->getRequest()->getParam('id');
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $data[$key] = implode(',',$this->getRequest()->getParam($key));
                }
            }
			$fileArray = array('jpg','jpeg','gif','png');
			if(isset($_FILES['company_logo']['name']) && $_FILES['company_logo']['name'] != '') {
				try {
					$uploader = new Varien_File_Uploader('company_logo');
					$uploader->setAllowedExtensions($fileArray); // or pdf or anything
					$uploader->setAllowRenameFiles(false);
					$uploader->setFilesDispersion(false);
					$path 	= Mage::getBaseDir('media') . '/Muvacon/Partners/Logos/' ;
					$this->makeDirectory($path);
					$imgType	= end(explode(".", $_FILES['company_logo']['name']));
					if(in_array(strtolower($imgType), $fileArray) == false) {
						Mage::getSingleton('adminhtml/session')->addError(Mage::helper('muvacon_partners')->__("Disallowed file types"));
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
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('muvacon_partners')->__($e->getMessage()));
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
				$data['company_updated_date']	= date('Y-m-d H:i:s');
                $model->load($id);
            } else {
				$data['company_created_date']	= date('Y-m-d H:i:s');
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
                    Mage::throwException(Mage::helper('muvacon_partners')->__('Error saving partners details'));
                }
				if(isset($_FILES['company_logo']['name']) && $_FILES['company_logo']['name'] != '' && $errorFormCheck == '') {
					$imageName	= $model->getId().".".$imgType;
					$uploader->save($path, $imageName);
					$dataNew['company_logo']	= 'Muvacon/Partners/Logos/'.$imageName;
					$model->load($model->getId());
					$model->addData($dataNew);
					$model->setId($model->getId())->save();
				}
				if(isset($_FILES['slider_images']) && count($_FILES['slider_images']) > 0 && isset($_FILES['slider_images']['name'][0]) && $_FILES['slider_images']['name'][0] != '') {
					$modelImage = Mage::getModel('partners/partnersImage');
					if(!empty($_FILES['slider_images']['name']) && count($_FILES['slider_images']['name']) > 0) {
						$pathSliders 	= Mage::getBaseDir('media') . '/Muvacon/Partners/Sliders/'.$model->getId();
						$this->makeDirectory($pathSliders);
						foreach($_FILES['slider_images']['name'] as $fileKey => $fileValue) {
							$uploaderSliders = new Varien_File_Uploader(array(
								'name' => $_FILES['slider_images']['name'][$fileKey],
								'type' => $_FILES['slider_images']['type'][$fileKey],
								'tmp_name' => $_FILES['slider_images']['tmp_name'][$fileKey],
								'error' => $_FILES['slider_images']['error'][$fileKey],
								'size' => $_FILES['slider_images']['size'][$fileKey])
							);
							$uploaderSliders->setAllowedExtensions($fileArray); // or pdf or anything
							$uploaderSliders->setAllowRenameFiles(false);
							$uploaderSliders->setFilesDispersion(false);
							$dataImage		= array();
							$time			= microtime(true);
							$micro 			= sprintf("%06d",($time - floor($time)) * 1000000);
							$nowTime 		= new DateTime( date('Y-m-d H:i:s.'.$micro, $time) );
							$nowCurrentTime	= $nowTime->format("YmdHisu");
							$imgTypeSlide	= end(explode(".", $_FILES['slider_images']['name'][$fileKey]));
							$imageNameSlide	= $model->getId()."_".$fileKey."_".$nowCurrentTime.".".$imgTypeSlide;
							if(in_array(strtolower($imgTypeSlide), $fileArray) == true) {
								$uploaderSliders->save($pathSliders, $imageNameSlide);
								$dataImage['fk_company_id'] 		= $model->getId();
								$dataImage['image_name'] 			= $imageNameSlide;
								$dataImage['image_type'] 			= $imgTypeSlide;
								$dataImage['image_status'] 			= 1;
								$dataImage['image_created_date'] 	= date('Y-m-d H:i:s');
								$modelImage->setData($dataImage);
								$modelImage->save();								
							}
						}
					}
				}
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('muvacon_partners')->__('Details was successfully saved.'));
 
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('muvacon_partners')->__('No data found to save'));
        $this->_redirect('*/*/list');
    }
 
 
    public function editAction() {
 
        $id 		= $this->getRequest()->getParam('id', null);
        $model 		= Mage::getModel('partners/partners');
		$modelImage = '';
        if ($id) {
            $model->load((int) $id);
            if ($model->getId()) {
                $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
                if ($data) {
                    $model->setData($data)->setId($id);
                }
				$modelImage = Mage::getModel('partners/partnersImage')->getCollection()->addFilter('fk_company_id', (int) $id);
            } else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('muvacon_partners')->__('partners does not exist'));
                $this->_redirect('*/*/list');
            }
        }
		Mage::register('partners_image', $modelImage);
		Mage::register('partners_title', $model->getCompanyName());
        Mage::register('partners_data', $model);
 
        $this->_title($this->__('Partners'))->_title($this->__('Edit Partners'));
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
 
        $this->_addContent($this->getLayout()->createBlock('partners/adminhtml_partners_edit'))
                ->_addLeft($this->getLayout()->createBlock('partners/adminhtml_partners_edit_tabs'));
        $this->renderLayout();
    }  
}