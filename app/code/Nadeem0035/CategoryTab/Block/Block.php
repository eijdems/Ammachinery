<?php

namespace Nadeem0035\CategoryTab\Block;

use Magento\Catalog\Model\CategoryRepository;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Eav\Model\Config;
use Magento\Framework\App\Request\Http;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Element\Template;

class Block extends Template
{

    public $_storeManager;
    protected $_categoryRepository;
    protected $_eavConfig;
    protected $_request;
    protected $_collection;
    protected $_productVisibility;
    private $_objectManager;

    public function __construct(Context $context, ObjectManagerInterface $objectManager, StoreManagerInterface $storeManager, CategoryRepository $categoryRepository, Config $eavConfig, Http $request, Collection $collection, Visibility $productVisibility, array $data = [])
    {
        $this->_objectManager = $objectManager;
        $this->_categoryRepository = $categoryRepository;
        $this->_eavConfig = $eavConfig;
        $this->_request = $request;
        $this->_collection = $collection;
        $this->_productVisibility = $productVisibility;
        $this->_storeManager = $storeManager;
        parent::__construct($context, $data);
    }


    public function getParam($name)
    {
        return $this->_request->getParam($name);
    }

    public function getFormAction()
    {
        return $this->getBaseUrl() . 'category_product/index/products';
    }

    public function getWebsiteUrl()
    {
        return $this->getBaseUrl();
    }

    public function getMediaUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    public function getLoadedProductCollection($category)
    {

        if (empty($category)) {
           return false;
        }

        $productCollection = $this->_collection;
        /** Apply filters here */
        $productCollection->addAttributeToSelect('*');
        $productCollection->addAttributeToFilter('status', '1');
        //$productCollection->addAttributeToFilter('show_on_ondersteuning', array('eq' => 1));
        $productCollection->addWebsiteFilter();
        $productCollection->addStoreFilter();
        $productCollection->setVisibility($this->_productVisibility->getVisibleInSiteIds());
        $productCollection->setPageSize(4);
        $productCollection->addCategoriesFilter(array('in' => array($category)));

        $productCollection->getSelect()->orderRand();
        //$productCollection->load();
        return $productCollection;
    }

    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
}