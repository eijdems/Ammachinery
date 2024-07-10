<?php

namespace MageBeans\Pageimage\Block\Index;

use Magento\Cms\Model\Page;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;
use MageBeans\Pageimage\Helper\Data;

class Index extends \Magento\Framework\View\Element\Template
{

	protected $collection;

	private $collectionFactory;

    protected $_storeManager;

    protected $_productloader;

    protected $_helperData;

    public function __construct(
		CollectionFactory $pageCollectionFactory,
		\Magento\Framework\View\Element\Template\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\Product $_productloader,
        Data $helperData,
        array $data = []
    ) {
        parent::__construct($context, $data);
    	$this->collection = $pageCollectionFactory->create();
        $this->collectionFactory = $pageCollectionFactory;
        $this->_storeManager = $storeManager;
        $this->_productloader = $_productloader;
        $this->_helperData = $helperData;

    }
    public function getPages() {
       	//echo "<pre>";
        $imagepath = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
       	$this->collection = $this->collectionFactory->create()->setOrder(
                'creation_time',
                'desc'
            );
        $datas = array();
        $items = $this->collection->setPageSize(3)->getItems();
        foreach ($items as $item) {

                $datas[$item['identifier']] = array('extra_image' => $imagepath.'magebeans/image/'.$item['extra_image'], 'page_heading' => $item['page_headng'], 'page_subheading' => $item['page_subheading']);
        }
        return $datas;
    }

    public function getProductData() {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $_product_ids = explode(',',$this->_helperData->getHomeproduct());
        $productdata = array();
        $imagepath = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        foreach($_product_ids  as $_product_id) {
           //www echo ;
           // $product = $objectManager->get('Magento\Catalog\Model\Product')->load('3566');
            $_product = $this->_productloader->load($this->_productloader->getIdBySku($_product_id));

            $productdata[$_product->getId()] = array('name' => $_product->getName(),'sku' => $_product->getSku(), "price" => $_product->getFormattedPrice(),"special-price" => $_product->getSpecialPrice() , "url" => $_product->getProductUrl(),'image' => $imagepath.'catalog/product/'.$_product->getThumbnail());
           // exit;
        }
        return $productdata;
    }


}


