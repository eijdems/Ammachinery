<?php

namespace Nadeem0035\MachineSearch\Block\Product;

class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \Nadeem0035\MachineSearch\Model\Layer\Resolver $layerResolver,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        array $data = []
    )
    {
        parent::__construct($context, $postDataHelper, $layerResolver,
            $categoryRepository, $urlHelper, $data);
    }

    public function getLoadedProductCollection()
    {
        $collection = $this->_getProductCollection();
        $collection->clear();
        // $collection->addAttributeToFilter('manufacturer','213');
        // $collection->setPageSize(5);
        // $collection->setCurPage(1);
        return $collection;
    }
    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Machine Search'));
    }
}