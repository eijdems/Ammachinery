<?php

namespace Nadeem0035\MachineSearch\Model;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory as AttributeCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class Layer extends \Magento\Catalog\Model\Layer
{

    protected $productCollectionFactory;
    protected $_productVisibility;
    protected $request;

    public function __construct(
        \Magento\Catalog\Model\Layer\ContextInterface $context,
        \Magento\Catalog\Model\Layer\StateFactory $layerStateFactory,
        AttributeCollectionFactory $attributeCollectionFactory,
        \Magento\Catalog\Model\ResourceModel\Product $catalogProduct,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Registry $registry,
        CategoryRepositoryInterface $categoryRepository,
        CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $productVisibility,
        \Magento\Framework\App\Request\Http $request,
        array $data = []
    )
    {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->_productVisibility = $productVisibility;
        $this->request = $request;
        parent::__construct(
            $context,
            $layerStateFactory,
            $attributeCollectionFactory,
            $catalogProduct,
            $storeManager,
            $registry,
            $categoryRepository,
            $data
        );
    }

    public function getProductCollection()
    {

        $collection = $this->productCollectionFactory->create();

        $collection->addAttributeToSelect('*');

        // filter current website products
        $collection->addWebsiteFilter();

        // filter current store products
        $collection->addStoreFilter();


        // set visibility filter
        $collection->setVisibility($this->_productVisibility->getVisibleInSiteIds());

        $catalogId = trim($this->request->getParam('cat'));

        if (!empty($catalogId)) {
            $collection->addCategoriesFilter(array('in' => array($catalogId)));
        }

        $manufacturer = trim($this->request->getParam('manufacturer'));
        if (!empty($manufacturer)) {
            $collection->addAttributeToFilter('manufacturer', $manufacturer);
        }


        $type = trim($this->request->getParam('type'));
        if (!empty($type)) {
            //$collection->addAttributeToFilter('sku', array('like' => '%' . $type . '%'));
             $collection->addAttributeToFilter(
                 [
                     ['attribute' => 'name', 'like' => '%'.$type.'%']
                 ]);
        }

        $this->prepareProductCollection($collection);

        return $collection;
    }

}