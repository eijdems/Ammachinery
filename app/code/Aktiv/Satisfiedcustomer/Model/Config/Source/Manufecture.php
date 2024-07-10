<?php

namespace Aktiv\Satisfiedcustomer\Model\Config\Source;

class Manufecture implements \Magento\Framework\Option\ArrayInterface
{
    protected $manufecture;

    public function __construct(
        \Magento\Catalog\Api\ProductAttributeRepositoryInterface $manufecture
    ) {
        $this->manufecture = $manufecture;
    }

    public function toOptionArray()
    {
        $options = [];
        $attributes = $this->manufecture->get('manufacturer');
        foreach ($attributes->getOptions() as $attribute) {
            $options[] = ['label' => $attribute->getLabel(), 'value' => $attribute->getValue()];
        }
        return $options;
    }
}
