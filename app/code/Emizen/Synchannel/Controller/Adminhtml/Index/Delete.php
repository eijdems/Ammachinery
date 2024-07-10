<?php
namespace Emizen\Synchannel\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;

class Delete extends Action
{   
    protected $resultFactory;
    protected $productRepository;
    protected $messageManager;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\ResultFactory $resultFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->resultFactory = $resultFactory;
        $this->productRepository = $productRepository;
        $this->messageManager = $messageManager;
        parent::__construct($context);
    }

    public function execute()
    {       
        $productId = $this->getRequest()->getParam('id');
        
        try {
            $product = $this->productRepository->getById($productId);
            $syncProduct = $product->getData('sync_product_on_hexon');
            $sku = $product->getSku();

            $this->deleteHexonProduct($sku);

            $this->messageManager->addNoticeMessage(__('Deleted Hexon product successfully !'));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl()); // Redirect to the previous page
        return $resultRedirect;
    }

    protected function deleteHexonProduct($sku) {
        $url = 'https://api.hexon.nl/spi/api/v4/rest/vehicle/'.urlencode($sku);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
            ),
        ]);

        $response = curl_exec($curl);
        //$err = curl_error($curl);

        curl_close($curl);
    }
}
