<?php

namespace Aktiv\Satisfiedcustomer\Controller\Adminhtml\Contact;

class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Aktiv_Satisfiedcustomer::menu');
        $resultPage->getConfig()->getTitle()->prepend(__('Selected Customers'));
        return $resultPage;
    }
}
