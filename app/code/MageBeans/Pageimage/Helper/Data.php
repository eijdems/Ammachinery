<?php
/**
 * Copyright © 2015 GravityShift . All rights reserved.
 */
namespace MageBeans\Pageimage\Helper;

use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    protected $_backendUrl;

    protected $_request;

    protected $_scopeConfig;

    protected $_storeManager;

    protected $_categoryFactory;

    const XML_PATH_HOME_CATEGORIES = 'magebeans_section/categories/categorylist';

    const XML_PATH_HOME_PRODUCT = 'magebeans_section/product/productlist';

    const XML_PATH_HOME_YOUTUBE = 'magebeans_section/product/youtube';

    const XML_PATH_HOME_PAGE_TWO_PRODUCT = 'magebeans_section/twoproductright/twoproduct';
    protected $_stockFilter;

    


    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    protected $storeManager;
    protected $_productCollectionFactory;
    protected $_attributeRepository;
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $_storeManager,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\CatalogInventory\Helper\Stock $stockFilter,
        \Magento\Catalog\Model\Product\Attribute\Repository $attributeRepository
    ) {
        parent::__construct($context);
        $this->_backendUrl = $backendUrl;
        $this->_request = $request;
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $_storeManager;
        $this->_categoryFactory = $categoryFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_stockFilter = $stockFilter;
        $this->_attributeRepository = $attributeRepository;

    }
    public function getHomecategories()
    {
         $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->_scopeConfig->getValue(self::XML_PATH_HOME_CATEGORIES, $storeScope);
    }
    public function getHomeproduct() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->_scopeConfig->getValue(self::XML_PATH_HOME_PRODUCT, $storeScope);
    }
     public function getHomeyoutube() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::XML_PATH_HOME_YOUTUBE, $storeScope);
    }
    public function getProductCollectionByCategories()
    {
        $categories = explode(",",$this->getHomecategories());//category ids array
        $categories = array_reverse($categories);
        $finalCollection = [];
        foreach($categories as $category){
            $categoryName = $this->_categoryFactory->create()->load($category)->getName();
            if ($category == 99) {   

                $optionId = $this->getOptionIdbyAttributeCodeandLabel('machine_status', 'Inspected');       
                $collection = $this->_productCollectionFactory->create();
                $collection->addAttributeToSelect('*')->addAttributeToFilter('machine_status',  $optionId);
                $collection->addAttributeToFilter('status','1');
                $collection->addStoreFilter($this->_storeManager->getStore());
                $collection->addCategoriesFilter(['eq' => $category]);            
                $this->_stockFilter->addInStockFilterToCollection($collection);
                $collection->setOrder('entity_id','asc');

            }else{

                $collection = $this->_productCollectionFactory->create();
                $collection->addAttributeToSelect('*');
                $collection->addStoreFilter($this->_storeManager->getStore());
                $collection->addCategoriesFilter(['eq' => $category]);      
                $this->_stockFilter->addInStockFilterToCollection($collection);
                $collection->setOrder('entity_id','asc');
            }

            $finalCollection[$categoryName] = $collection;
        }
        
        return $finalCollection;
    }

    public function getOptionIdbyAttributeCodeandLabel($attr_code,$optionText)
    {
       $attribute = $this->_attributeRepository->get($attr_code);
       $optionId = $attribute->getSource()->getOptionId($optionText);
       return $optionId;
    }

    public function getTwoProducts(){
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->_scopeConfig->getValue(self::XML_PATH_HOME_PAGE_TWO_PRODUCT, $storeScope);   
    }
    public function getTwoProductCollection()
    {   
        $productsArray = explode(",", $this->getTwoProducts());
        // echo "<pre>"; print_r($productsArray); exit();
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addStoreFilter($this->_storeManager->getStore());
        $collection->addAttributeToFilter('sku', ['in' => $productsArray]);
        $collection->setPageSize(2);
        return $collection;
    }
    public function getConfig($path)
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->_scopeConfig->getValue($path, $storeScope);
    }

    public function getBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    public function getStoreCode()
    {
        return $this->_storeManager->getStore()->getCode();
    }
}
