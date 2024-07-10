<?php
/**
 * Created By : Rohan Hapani
 */
namespace RH\MultiSelectCategory\Model\Source;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\Option\ArrayInterface;

class Attribute implements ArrayInterface
{
    protected $collectionFactory;

    /**
     * @param EavConfig $eavConfig
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    public function toOptionArray()
    {
        $optionArray = [];
        $arr = $this->collectionFactory->create()
            ->setStoreId(2)
            ->addAttributeToSelect('*');
        foreach ($arr as $value => $label) {
            $optionArray[] = [
                    'value' => $label->getId(),
                    'label' => $label->getName(),
                ];
        }
        return $optionArray;
    }
}
