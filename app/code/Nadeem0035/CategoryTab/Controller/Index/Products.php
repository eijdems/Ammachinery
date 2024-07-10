<?php

namespace Nadeem0035\CategoryTab\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;

class Products extends \Magento\Framework\App\Action\Action
{

    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var JsonFactory
     */
    protected $_resultJsonFactory;


    public function __construct(Context $context, PageFactory $resultPageFactory, JsonFactory $resultJsonFactory)
    {

        $this->_resultPageFactory = $resultPageFactory;
        $this->_resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }


    public function execute()
    {
        $result = $this->_resultJsonFactory->create();
        $resultPage = $this->_resultPageFactory->create();

        $data = [];

        $cat_id = $this->getRequest()->getParam('cat_id');

        $data = array('cat_id' => $cat_id);

        $block = $resultPage->getLayout()
            ->createBlock('Nadeem0035\CategoryTab\Block\Block')
            ->setTemplate('Nadeem0035_CategoryTab::category_product.phtml')
            ->setData($data)
            ->toHtml();

        $result->setData(['output' => $block]);
        return $result;
    }
}