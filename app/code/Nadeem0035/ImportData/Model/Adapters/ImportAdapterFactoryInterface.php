<?php


namespace Nadeem0035\ImportData\Model\Adapters;
interface ImportAdapterFactoryInterface{
    /**
     * @return \Magento\ImportExport\Model\Import\AbstractSource
     */
    public function create(array $data = []);
}