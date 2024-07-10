<?php

namespace Nadeem0035\General\Block;

use Magento\Catalog\Helper\Category;
use Magento\Catalog\Model\Product\Attribute\Repository;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\View\Element\Template\Context;

class Block extends \Magento\Framework\View\Element\Template
{
    protected $_categoryCollectionFactory;

    protected $_categoryHelper;
    protected $_websiteRepositoryInterface;
    protected $_storeManager;
    protected $_urlInterface;
    protected $_eavConfig;
    protected $_productcollection;

    public function __construct(
        Context $context,
        CollectionFactory $categoryCollectionFactory,
        Category $categoryHelper,
        Repository $productAttributeRepository,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $urlInterface,
        \Magento\Catalog\Model\ResourceModel\Product\Collection $productcollection,
        array $data = []
    ) {
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_categoryHelper = $categoryHelper;
        $this->_productAttributeRepository = $productAttributeRepository;
        $this->_eavConfig = $eavConfig;
        $this->_storeManager = $storeManager;
        $this->_urlInterface = $urlInterface;
        $this->_productcollection = $productcollection;
        parent::__construct($context, $data);
    }

    public function getCategoryCollection($isActive = true, $level = false, $sortBy = false, $pageSize = false, $categoryId = false, $parentCategoryId = false)
    {
        $collection = $this->_categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');

        // select only active categories
        if ($isActive) {
            $collection->addIsActiveFilter();
        }

        // select categories of certain level
        if ($level) {
            $collection->addLevelFilter($level);
        }

        //Exclude category

        if (!empty($categoryId)) {
            $collection->addAttributeToFilter('entity_id', ['neq' => $categoryId]);
        }

        if (!empty($parentCategoryId)) {
            $collection->addAttributeToFilter('parent_id', ['eq'=>$parentCategoryId]);
        }

        // sort categories by some value
        if ($sortBy) {
            $collection->addOrderField($sortBy);
        }

        // set pagination
        if ($pageSize) {
            $collection->setPageSize($pageSize);
        }

        return $collection;
    }

    public function getProductAttributeByCode($code)
    {
        $storeName     = $this->_storeManager->getStore()->getCode();
        if($storeName == "am") {
            $websiteIds = array('2');
            $collection = $this->_productcollection->addAttributeToSelect('*')->addWebsiteFilter($websiteIds)->load();
            $customManufacturesList = [];
            foreach ($collection as $product){
                $label = $product->getResource()->getAttribute('manufacturer');
                if ($label->usesSource()) {
                    $customManufacturesList[] = $label->getSource()->getOptionText($product->getManufacturer());
                }
            }
            $customManufacturesList=array_unique(array_filter($customManufacturesList));
        }
        else {
            $customManufacturesList = ["John Deere","Claas","Krohne","New Holland","Kemper","Veenhuis","Schuitemaker","Compost Systems","Massey Ferguson","Caterpillar","JCB","Case","Capello","Bomag"];
        }
        $options = [];
        $attribute = $this->_eavConfig->getAttribute('catalog_product', $code);
        $options = $attribute->getSource()->getAllOptions();
        $arr = [];
        foreach ($options as $option) {
            if ($option['value'] > 0 && in_array($option['label'], $customManufacturesList)) {
                $arr[$option['value']] = $option['label'];
            }
        }
        return $arr;
    }

    public function getStoreCategories($sorted = false, $asCollection = false, $toLoad = true)
    {
        return $this->_categoryHelper->getStoreCategories($sorted = false, $asCollection = false, $toLoad = true);
    }

    public function getResultUrl($query = null)
    {
        return $this->_storeManager->getStore()->getUrl('machinesearch');
    }
}
