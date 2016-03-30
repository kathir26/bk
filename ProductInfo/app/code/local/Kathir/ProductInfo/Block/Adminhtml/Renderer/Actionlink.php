<?php 
	class Kathir_ProductInfo_Block_Adminhtml_Renderer_Actionlink extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
		public function render(Varien_Object $row) {
			$proUrl	= $this->getUrl('adminhtml/catalog_product/edit', array('id'=>$row->getFkProductId(), 'storeId' => $row->getStoreId()));
			$delUrl	= $this->getUrl('adminhtml/productInfo/delete', array('id'=>$row['productInfo_id'], 'storeId' => $row->getStoreId())); 
			return sprintf("<a href='%s' onclick=\"popWin(this.href,'_blank','resizable=1,scrollbars=1');return false;\">%s</a>", $proUrl, Mage::helper('catalog')->__('Edit')).'&nbsp;&nbsp;'.sprintf("<a href='%s' onclick=\"if(confirm('Are you sure want to delete?')){return true;} else {return false;};\">%s</a>", $delUrl, Mage::helper('catalog')->__('Delete'));
		}
	}
?>