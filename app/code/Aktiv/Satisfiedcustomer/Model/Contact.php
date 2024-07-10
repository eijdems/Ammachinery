<?php

namespace Aktiv\Satisfiedcustomer\Model;

use Magento\Framework\Model\AbstractModel;

class Contact extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Aktiv\Satisfiedcustomer\Model\ResourceModel\Contact');
    }
}
