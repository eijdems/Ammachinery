<?php
namespace Emizen\Synchannel\Block\Adminhtml\Product\Edit\Button;

use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\Registry;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    protected $urlBuilder;
    protected $registry;

    public function __construct(
        UrlInterface $urlBuilder,
        Registry $registry
    ) { 
        $this->urlBuilder = $urlBuilder;
        $this->registry = $registry;
    }

    public function getButtonData()
    {
        return [
            'label' => __('Delete Sync Product'),
            'on_click' => sprintf("deleteConfirm('%s', '%s')", __('Are you sure you want to delete this product?'), $this->getButtonUrl()),
            'class' => 'delete',
            'sort_order' => 100
        ];
    }

    public function getButtonUrl()
    {
        $product = $this->registry->registry('current_product');
        $productId = $product->getId();
        return $this->urlBuilder->getUrl('emizen_synchannel/index/delete', ['id' => $productId]);
    }
}
