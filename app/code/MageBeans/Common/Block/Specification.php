<?php
namespace MageBeans\Common\Block;

class Specification extends \Magento\Catalog\Block\Product\View
{
     protected $_groupCollection; 
     protected $_productFactory;    

public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
         \Magento\Framework\Url\EncoderInterface $urlEncoder,
         \Magento\Framework\Json\EncoderInterface $jsonEncoder,
         \Magento\Framework\Stdlib\StringUtils $string,
         \Magento\Catalog\Helper\Product $productHelper,
         \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
         \Magento\Framework\Locale\FormatInterface $localeFormat,
         \Magento\Customer\Model\Session $customerSession,
         \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
         \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\CollectionFactory $_groupCollection,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        array $data = []

) {
    $this->_groupCollection = $_groupCollection;
    $this->_productFactory = $productFactory;
    parent::__construct($context, $urlEncoder, $jsonEncoder, $string,
        $productHelper, $productTypeConfig, $localeFormat, $customerSession,
        $productRepository, $priceCurrency, $data);
}
public function getAttributeGroupId($attributeSetId)
{
     $groupCollection = $this->_groupCollection->create();
     $groupCollection->addFieldToFilter('attribute_set_id',$attributeSetId);
     $groupCollection->addFieldToFilter('attribute_group_name','Grid Attributes');


     return $groupCollection->getFirstItem(); 

}

	public function getProduct()
    {
        if (!$this->_coreRegistry->registry('product') && $this->getProductId()) {
            $product = $this->productRepository->getById($this->getProductId());
            $this->_coreRegistry->register('product', $product);
        }
        return $this->_coreRegistry->registry('product');
    }

public function getAttributeGroups($attributeSetId)
{
     $groupCollection = $this->_groupCollection->create();
     $groupCollection->addFieldToFilter('attribute_set_id',$attributeSetId);

     $groupCollection->setOrder('sort_order','ASC');
     return $groupCollection; 

}
 public function getGroupAttributes($pro,$groupId, $productAttributes){
    $data=[];
    $no =__('No');
    foreach ($productAttributes as $attribute){

      if ($attribute->isInGroup($pro->getAttributeSetId(), $groupId) && $attribute->getIsVisibleOnFront() ){
          if($attribute->getFrontend()->getValue($pro) && $attribute->getFrontend()->getValue($pro)!='' && $attribute->getFrontend()->getValue($pro)!=$no){
            $data[]=$attribute;
          }
      }

    }

  return $data;
 }
 public function getProductImages($productId) {
 $_product = $this->_productFactory->create()->load($productId);

 $productImages = $_product->getMediaGalleryImages();
 return $productImages;
}


}