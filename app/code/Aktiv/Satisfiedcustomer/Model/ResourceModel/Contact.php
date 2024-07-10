<?php

namespace Aktiv\Satisfiedcustomer\Model\ResourceModel;

class Contact extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('satisfied_customer', 'id');
    }
}
