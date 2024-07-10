<?php

namespace Aktiv\Satisfiedcustomer\Model\Config\Source;

class Country implements \Magento\Framework\Option\ArrayInterface
{
    protected $countryCollectionFactory;

    public function __construct(
        \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollectionFactory
    ) {
        $this->_countryCollectionFactory = $countryCollectionFactory;
    }

    public function toOptionArray()
    {
        $options = [];
        $countries = $this->_countryCollectionFactory->create();
        $countries->addFieldToSelect('*');
        foreach ($countries as $country) {
            $options[] = ['label' => $country->getName(), 'value' => $country->getCountryId()];
        }
        return $options;
    }
}
