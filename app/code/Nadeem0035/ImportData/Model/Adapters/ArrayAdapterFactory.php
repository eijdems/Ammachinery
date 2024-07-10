<?php

namespace Nadeem0035\ImportData\Model\Adapters;
class ArrayAdapterFactory implements ImportAdapterFactoryInterface
{
    protected $_objectManager = null;

    protected $_instanceName = null;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        $instanceName = 'Nadeem0035\ImportData\Model\Adapters\ArrayAdapter'
    )
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * @param array $data
     * @return \Nadeem0035\ImportData\Model\Adapters\ArrayAdapter
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}