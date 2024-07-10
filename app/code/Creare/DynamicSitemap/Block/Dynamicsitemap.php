<?php 
namespace Creare\DynamicSitemap\Block;  
class Dynamicsitemap extends \Magento\Framework\View\Element\Template
{   

	protected $_storeManager;
	protected $_categoryHelper;
	protected $categoryFlatConfig;
	protected $topMenu;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,        
        \Magento\Catalog\Helper\Category $categoryHelper,
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Theme\Block\Html\Topmenu $topMenu,
        array $data = []
    )
    {
    	$this->_categoryHelper = $categoryHelper;
    	$this->topMenu = $topMenu;
    	$this->pageFactory = $pageFactory;
    	$this->categoryFlatConfig = $categoryFlatState;
        $this->_storeManager = $storeManager;
        parent::__construct($context, $data);
    }


	public function getCreareCMSPages(){

		$current_store_id = $this->getStoreId(); // current store id
		$page = $this->pageFactory->create();	    
	    $page->getCollection();
	    $html = "";
	    foreach($page->getCollection()->addStoreFilter(trim($current_store_id)) as $item)
	    {
	    	$url = $this->_storeManager->getStore()->getBaseUrl();
	    	$page = $item->getData();
	    	if($page['identifier'] == "no-route" || $page['identifier'] == "enable-cookies" || $page['identifier'] == "empty"){ // do nothing or something here
			} else {
				if($page['identifier'] == "home"){
					$html .= "<li><a href=\"$url\" title=\"".$page['title']."\">".$page['title']."</a></li>\n"; // this is for a nice local link to home
				} else {
					$html .= "<li><a href=\"$url".$page['identifier']."\" title=\"".$page['title']."\">".$page['title']."</a></li>\n";
				}
			}
	    }
	    return $html;
	} 
	public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }
    public function getStoreUrl($fromStore = true)
    {
        return $this->_storeManager->getStore()->getCurrentUrl($fromStore);
    }
    public function getBaseUrl()
    {
    	return $this->_storeManager->getStore()
           ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_LINK);
    }
    public function getCategoryHelper()
    {
        return $this->_categoryHelper;
    }
    public function getHtml()
    {
        return $this->topMenu->getHtml();
    }
    public function getStoreCategories($sorted = false, $asCollection = false, $toLoad = true)
    {
        return $this->_categoryHelper->getStoreCategories($sorted , $asCollection, $toLoad);
    }
    public function getChildCategories($category)
    {
           if ($this->categoryFlatConfig->isFlatEnabled() && $category->getUseFlatResource()) {
                $subcategories = (array)$category->getChildrenNodes();
            } else {
                $subcategories = $category->getChildren();
            }
            return $subcategories;
    }
}