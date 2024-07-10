<?php 
namespace MageBeans\Pageimage\Observer;

class SaveImageObserver implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $pageModel = $observer->getData('page');
  
        $imageAttributes = ['extra_image'];
       
        $otherAttribute = ['page_headng,page_subheading'];

        $data = $observer->getData('request')->getPostValue();
    
        foreach($imageAttributes as $attributeCode){
            if(
                isset($data[$attributeCode])
                && is_array($data[$attributeCode])
            ) {
                $pageModel->setData($attributeCode, $data[$attributeCode][0]['name']);
            }
        }
        foreach($otherAttribute as $otherAttr){
            if(
                isset($data[$otherAttr])
                && is_array($data[$otherAttr])
            ) {
                $pageModel->setData($otherAttr, $data[$otherAttr][0]['name']);
            }
        }
        return $this;
    }
}