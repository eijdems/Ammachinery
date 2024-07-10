<?php

namespace Aktiv\Satisfiedcustomer\Model\Contact;

use Aktiv\Satisfiedcustomer\Model\ResourceModel\Contact\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $contactCollectionFactory
     * @param array $meta
     * @param array $data
     */
    protected $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $contactCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $contactCollectionFactory->create();
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        $this->loadedData = array();
        /** @var Customer $customer */
        foreach ($items as $contact) {
            $_data = $contact->getData();
            if (isset($_data['image'])) {
                $imageName = $_data['image'];
                $_data['image'] = [
                    [
                        'name' => $imageName,
                        'url' => $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'image/image/' . $_data['image'],
                    ],
                ];
            }
            if (isset($_data['sourceimage'])) {
                $imageName = $_data['sourceimage'];
                $_data['sourceimage'] = [
                    [
                        'name' => $imageName,
                        'url' => $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'sourceimage/sourceimage/' . $_data['sourceimage'],
                    ],
                ];
            }
            $this->loadedData[$contact->getId()]['contact'] = $_data;
        }
        return $this->loadedData;
    }
}
