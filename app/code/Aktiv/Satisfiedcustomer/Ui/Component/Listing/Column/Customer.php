<?php

namespace Aktiv\Satisfiedcustomer\Ui\Component\Listing\Column;

class Customer extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected $_customerRepositoryInterface;

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {

            foreach ($dataSource['data']['items'] as & $item) {
                $id = $item['customerid'];
                $customer = $this->_customerRepositoryInterface->getById($id);
                $item['customerid'] = $customer->getFirstname();
            }
        }
        return $dataSource;
    }
}
