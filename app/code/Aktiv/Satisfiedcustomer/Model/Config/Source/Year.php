<?php

namespace Aktiv\Satisfiedcustomer\Model\Config\Source;

class Year implements \Magento\Framework\Option\ArrayInterface
{
    protected $year;

    public function __construct(
        \Magento\Catalog\Api\ProductAttributeRepositoryInterface $year
    ) {
        $this->year = $year;
    }

    public function toOptionArray()
    {
        $options = [];
        $years = $this->year->get('build_year');
        foreach ($years->getOptions() as $year) {
            $options[] = ['label' => $year->getLabel(), 'value' => $year->getValue()];
        }
        return $options;
    }
}
