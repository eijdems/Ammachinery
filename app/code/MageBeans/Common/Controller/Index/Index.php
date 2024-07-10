<?php
namespace MageBeans\Common\Controller\Index;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Framework\App\Action\Action
{
   /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\UrlInterface 
     */

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context, 
        PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory
    ) {        
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->_resultLayoutFactory = $resultLayoutFactory;
        $this->_productFactory = $productFactory;
        parent::__construct($context);
    }


    public function execute()
    {
        $postData = $this->getRequest()->getParams();
        $pid = $postData['pid'];
        $_product = $this->_productFactory->create()->load($pid);
        $productImages = $_product->getMediaGalleryImages();
        $ct = 1;
        $otherImages = [];
        foreach ($productImages as $_image){
            // if($ct == 9){
            //     break;
            // }
            if($ct >= 7){
                // $otherImages[] = $_image->getUrl();
                $otherImages[] = "<li><a href=".$_image->getUrl(). " data-lightbox='image-1' data-title='These are pastel donuts'><img src=".$_image->getUrl()." class='img-custom-gallery'></a></li>";
            }
            $ct++;
        }
        // echo "<pre>";
        // print_r($otherImages); exit();
        return $this->getResponse()->setContent(json_encode($otherImages));
    }
}