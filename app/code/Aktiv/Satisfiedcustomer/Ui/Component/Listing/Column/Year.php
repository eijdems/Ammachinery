<?php

namespace Aktiv\Satisfiedcustomer\Ui\Component\Listing\Column;

class Year extends \Magento\Ui\Component\Listing\Columns\Column {

    protected $_customerRepositoryInterface;
    protected $productModel;

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Eav\Api\Data\AttributeOptionInterfaceFactory $optionFactory,
        \Magento\Catalog\Model\Product $productModel,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\Collection $attributeOptionCollection,
        array $components = [],
        array $data = []
    ){
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->optionFactory = $optionFactory;
        $this->productModel = $productModel;
        $this->_attributeOptionCollection = $attributeOptionCollection;
    }

    public function prepareDataSource(array $dataSource) {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $optionId =  $item['yearid'];
                $attribute = $this->productModel->getResource()->getAttribute('build_year');
                $optionText='';
                if ($attribute->usesSource()) {
                    $optionText = $attribute->getSource()->getOptionText($optionId);
                }
                $item['yearid'] = $optionText;
                /*$optionValue = $item['manufectureid']; 
                $optionFactory = $this->optionFactory->create();
                $optionFactory->load($optionValue);
                $attributeId = $optionFactory->getAttributeId();
                $optionData = $this->_attributeOptionCollection
                ->setPositionOrder('asc')
                ->setAttributeFilter($attributeId)
                ->setIdFilter($optionValue)
                ->setStoreFilter()
                ->load();
                echo "<pre>"; print_r($optionData->getData()); exit;
                $item['customerid'] = $customer->getFirstname();*/
            }
        }
        return $dataSource;
    }
}
