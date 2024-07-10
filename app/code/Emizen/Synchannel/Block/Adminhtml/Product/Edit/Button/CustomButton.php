<?php 
namespace Emizen\Synchannel\Block\Adminhtml\Product\Edit\Button;
use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class CustomButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData()
    {
        return [
            'label' => __('Sync Channel'),
            'on_click' => sprintf("location.href = '%s';", $this->getButtonUrl()),
            'sort_order' => 100
        ];
    }
    public function getButtonUrl()
    {   //var_dump($this->getCurrentProduct());die;
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $product = $objectManager->get('Magento\Framework\Registry')->registry('current_product');
            
            $productId = $product->getId(); // Assuming getCurrentProduct() returns the product object
            //echo $productId;
            return $this->getUrl('emizen_synchannel/index/index', ['id' => $productId]);
        // Replace 'route/controller/action' with your desired route, controller, and action
    }
}
