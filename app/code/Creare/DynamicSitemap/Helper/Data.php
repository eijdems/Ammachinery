<?php
namespace Creare\DynamicSitemap\Helper;


class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }
    public function showCMS()
	{
		return $this->scopeConfig->getValue('dynamicsitemap/dynamicsitemap/showcms', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	}

	public function showCategories()
	{
		return $this->scopeConfig->getValue('dynamicsitemap/dynamicsitemap/showcategories', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	}

	public function showXMLSitemap()
	{
		return $this->scopeConfig->getValue('dynamicsitemap/dynamicsitemap/showxml', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	}

	public function showAccount()
	{
		return $this->scopeConfig->getValue('dynamicsitemap/dynamicsitemap/showaccount', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	}

	public function showContact()
	{
		return $this->scopeConfig->getValue('dynamicsitemap/dynamicsitemap/showcontact', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	}
}