<?php

namespace Nadeem0035\ImportData\ResourceModel;

use Magento\Framework\App\Config\ScopeConfigInterface;



class ImportData extends \Magento\ImportExport\Model\ResourceModel\Import\Data
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        ScopeConfigInterface $scopeConfig,
        $connectionName = null
    )
    {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $jsonHelper, $connectionName);
    }

    protected function _construct()
    {
        if ($this->scopeConfig->isSetFlag('importdata/database/import_temp_table')) {
            $this->getConnection()->createTemporaryTableLike(
                'importexport_importdata_tmp',
                'importexport_importdata',
                true
            );
            $this->_init('importexport_importdata_tmp', 'id');
        } else {
            parent::_construct();
        }
    }

}