<?php
namespace Emizen\Synchannel\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ProductFactory;

class CustomAction extends Action
{
    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * CustomAction constructor.
     * @param Context $context
     * @param ProductFactory $productFactory
     */
    public function __construct(
        Context $context,
        ProductFactory $productFactory
    ) {
        parent::__construct($context);
        $this->productFactory = $productFactory;
    }

    public function execute()
    {
    	var_dump($this->getRequest());die;
        // Retrieve product data
        $productId = $this->getRequest()->getParam('id'); // Assuming you pass product id in request
        $product = $this->productFactory->create()->load($productId);
        echo $productId;
        die;
        //echo "<pre>";
        // Check if product exists
        if (!$product->getId()) {
            $this->messageManager->addErrorMessage(__('Product not found.'));
            return $this->_redirect('*/*/');
        }

        // Now you can work with the $product object
        echo $productName = $product->getName();
        echo $productSku = $product->getSku();

        //print_r($product->getData());
        // Add your custom code here
        $this->messageManager->addSuccessMessage(__('Custom Action Executed Successfully'));

        // Redirect to a specific page after execution
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/');
        return $resultRedirect;
    }
}
