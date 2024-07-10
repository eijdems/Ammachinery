<?php

namespace Emizen\Restrictcountry\Block;
use Magento\Catalog\Model\ProductCategoryList;

class Restrict extends \Magento\Framework\View\Element\Template
{

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param array $data
     */
    public $storeManager;
    public $scopeConfig;
    protected $_registry;
    protected $productCategory;
    protected $customerSession;
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $_messageManager;
 
    /**
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     */

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Registry $registry,
        ProductCategoryList $productCategory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        array $data = []
    ) {
        $this->storeManager     = $storeManager;
        $this->scopeConfig      = $scopeConfig;
        $this->_registry        = $registry;
        $this->productCategory  = $productCategory;
        $this->customerSession  = $customerSession;
        $this->_messageManager  = $messageManager;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getRestrictCountry()
    {
        $valueFromConfig = $this->scopeConfig->getValue('restrict/countries/codes',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $arrayvalue = explode(',', $valueFromConfig);
        return $arrayvalue;
    }
    public function getStoreId()
    {
        return $this->storeManager->getStore()->getId();
    }
    public function getCategorys()
    {
        $valueFromConfig = $this->scopeConfig->getValue('restrict/categories/ids',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $arrayvalue = explode(',', $valueFromConfig);
        return $arrayvalue;
    }
    public function getCurrentCategory(){
        $category = $this->_registry->registry('current_category');//get current category
        return $category;
    }
    /**
     * get all the category id
     *
     * @param int $productId
     * @return array
     */
    public function getCategoryIds(int $productId)
    {
        $categoryIds = $this->productCategory->getCategoryIds($productId);
        $category = [];
        if ($categoryIds) {
            $category = array_unique($categoryIds);
        }
        
        return $category;
    }
    public function getSession()
    {
        return $this->customerSession;
    }
    public function getGroupId(){
        return $this->customerSession->getCustomer()->getGroupId();
    }
    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }
}