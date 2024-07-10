<?php
namespace MageBeans\Pageimage\Model\Config;
 
use Magento\Framework\Option\ArrayInterface;
 
class Productlist implements ArrayInterface
{
    protected $collectionFactory;
 
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }
 
    public function toOptionArray()
    {
        $collection = $this->collectionFactory->create();
        $collection
         ->addAttributeToSelect('sku')
            ->addAttributeToSelect('name');
 
        $ret        = [];
        foreach ($collection as $product) {
            $ret[] = [
                'value' => $product->getSku(),
                'label' => $product->getName(),
            ];
        }
        return $ret;
    }
}