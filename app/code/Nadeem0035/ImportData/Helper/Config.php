<?php

namespace Nadeem0035\ImportData\Helper;

use Magento\Store\Model\ScopeInterface;

class Config extends \Magento\Framework\App\Helper\AbstractHelper
{

    const XML_PATH_IGNORE_DUPLICATES      = 'ImportData/default/ignore_duplicates';
    const XML_PATH_BEHAVIOR               = 'ImportData/default/behavior';
    const XML_PATH_ENTITY                 = 'ImportData/default/entity';
    const XML_PATH_VALIDATION_STRATEGY    = 'ImportData/default/validation_strategy';
    const XML_PATH_ALLOWED_ERROR_COUNT    = 'ImportData/default/allowed_error_count';
    const XML_PATH_IMPORT_IMAGES_FILE_FIR = 'ImportData/default/import_images_file_dir';
    const XML_PATH_CATEGORY_PATH_SEPERATOR = 'ImportData/default/category_path_seperator';
    const XML_PATH_URL                     = 'ImportData/database/import_url';
    const XML_PATH_USERNAME                = 'ImportData/database/import_username';
    const XML_PATH_PASSWORD                = 'ImportData/database/import_password';

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
    }

    public function getCategoryPathSeperator() {
        return $this->scopeConfig->getValue(self::XML_PATH_CATEGORY_PATH_SEPERATOR, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getIgnoreDuplicates()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_IGNORE_DUPLICATES, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getBehavior()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_BEHAVIOR, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getEntity()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ENTITY, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getValidationStrategy()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_VALIDATION_STRATEGY, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getAllowedErrorCount()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ALLOWED_ERROR_COUNT, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getImportFileDir()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_IMPORT_IMAGES_FILE_FIR, ScopeInterface::SCOPE_STORE);
    }

    public function getImportUrl()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_URL, ScopeInterface::SCOPE_STORE);
    }

    public function getImportUserName()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_USERNAME, ScopeInterface::SCOPE_STORE);
    }

    public function getImportPassword()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_PASSWORD, ScopeInterface::SCOPE_STORE);
    }
}
