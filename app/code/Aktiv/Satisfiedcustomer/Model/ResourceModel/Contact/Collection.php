<?php

namespace Aktiv\Satisfiedcustomer\Model\ResourceModel\Contact;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Aktiv\Satisfiedcustomer\Model\Contact',
            'Aktiv\Satisfiedcustomer\Model\ResourceModel\Contact'
        );
    }
}
