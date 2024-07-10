<?php

namespace Aktiv\Satisfiedcustomer\Model\Config\Source;

class Customer implements \Magento\Framework\Option\ArrayInterface
{
    protected $_customerFactory;

    public function __construct(
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerFactory
    ) {
        $this->_customerFactory = $customerFactory;
    }

    public function toOptionArray()
    {
        $options = [];
        $customers = $this->_customerFactory->create();
        foreach ($customers as $customer) {
            $options[] = ['label' => $customer->getFirstname(), 'value' => $customer->getId()];
        }
        return $options;
    }
}
