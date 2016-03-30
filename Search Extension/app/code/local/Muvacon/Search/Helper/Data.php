<?php
class Muvacon_Search_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function isEnabled($store = null)
    {
        return Mage::getStoreConfigFlag('muvacon_search/general/enable', $store);
    }

    public function getLimit($store = null)
    {
        return (int) Mage::getStoreConfig('muvacon_search/general/limit', $store);
    }

    public function getMinLength($store = null)
    {
        return (int) Mage::getStoreConfig('muvacon_search/general/min_length', $store);
    }

    public function getCacheLifetime($store = null)
    {
        return (int) Mage::getStoreConfig('muvacon_search/general/cache_lifetime', $store);
    }

    public function getUseLocalStorage($store = null)
    {
        return Mage::getStoreConfigFlag('muvacon_search/general/use_local_storage', $store);
    }

    public function getJsPriceFormat()
    {
        return Mage::app()->getLocale()->getJsPriceFormat();
    }

    public function getBaseUrl()
    {
        return Mage::app()->getStore()->getBaseUrl();
    }

    public function getBaseUrlMedia()
    {
        return Mage::getSingleton('catalog/product_media_config')->getBaseMediaUrl();
    }
}