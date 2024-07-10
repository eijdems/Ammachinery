<?php

namespace Nadeem0035\MachineSearch\Model\Layer;

use Magento\Catalog\Model\Config\LayerCategoryConfig;
use Magento\Catalog\Model\Layer\FilterableAttributeListInterface;
use Magento\Framework\ObjectManagerInterface;

class FilterList extends \Magento\Catalog\Model\Layer\FilterList
{
    public function __construct(
        ObjectManagerInterface $objectManager,
        FilterableAttributeListInterface $filterableAttributes,
        LayerCategoryConfig $layerCategoryConfig,
        array $filters = []
    ) {
        parent::__construct($objectManager, $filterableAttributes, $layerCategoryConfig, $filters);
    }
}
