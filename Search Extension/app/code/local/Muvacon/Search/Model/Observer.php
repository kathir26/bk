<?php
class Muvacon_Search_Model_Observer
{
    public function onProductCollectionInit(Varien_Event_Observer $observer)
    {
        $collection = $observer->getEvent()->getCollection();
        $collection->addAttributeToFilter('name', array('notnull' => true))
            ->addAttributeToFilter('image', array('notnull' => true))
            ->addAttributeToFilter('url_path', array('notnull' => true))
            ->addStoreFilter()
            ->addPriceData()
            ->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInSiteIds());
    }
	public function addButton($observer) {
        $block = $observer->getEvent()->getBlock();
        if(get_class($block) == 'Mage_Adminhtml_Block_Cache') {
			$button = $block->addButton('muvacon_search', array(
                'label'     => Mage::helper('muvacon_search')->__('Reindex Search Results'),
                'onclick'   => 'setLocation(\'' .  Mage::helper("adminhtml")->getUrl('search') . '\')',
                'class'     => 'delete'
            ));
        }
	}
}