<?php

namespace Nadeem0035\ImportData\Model\Adapters;
class NestedArrayAdapterFactory implements ImportAdapterFactoryInterface
{
    protected $_objectManager = null;

    protected $_instanceName = null;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        $instanceName = 'Nadeem0035\ImportData\Model\Adapters\NestedArrayAdapter'
    )
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * @param array $data
     * @return \Nadeem0035\ImportData\Model\Adapters\NestedArrayAdapter
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}