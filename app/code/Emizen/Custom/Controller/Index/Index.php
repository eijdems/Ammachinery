<?php 
namespace Emizen\Custom\Controller\Index; 
use Magento\Framework\App\Action\Context;
 
class Index extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;

    protected $_pageFactory;
    

    public function __construct(
        Context $context, 
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
        $this->_pageFactory = $pageFactory;
    }
 
    public function execute()
    { 
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;
    }
}