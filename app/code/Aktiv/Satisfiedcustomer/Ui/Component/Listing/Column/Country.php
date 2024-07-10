<?php

namespace Aktiv\Satisfiedcustomer\Ui\Component\Listing\Column;

class Country extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected $countryFactory;

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Directory\Model\CountryFactory $countryFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->_countryFactory = $countryFactory;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $id = $item['countryid'];
                $country = $this->_countryFactory->create()->loadByCode($id);
                $item['countryid'] = $country->getName();
            }
        }
        return $dataSource;
    }
}
