<?php

namespace Aktiv\Satisfiedcustomer\Controller\Adminhtml\Contact;

class MassDelete extends \Magento\Backend\App\Action
{
    protected $contactFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Aktiv\Satisfiedcustomer\Model\ContactFactory $contactFactory
    )
    {
        $this->contactFactory = $contactFactory;
        parent::__construct($context);
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $ids = $this->getRequest()->getPostValue('selected');
        try {
            $count = 0;
            foreach ($ids as $selectedId) {
                $deleteData = $this->contactFactory->create()->load($selectedId);
                $deleteData->delete();
                $count++;
            }
            $this->messageManager->addSuccess(__('A total of %1 element(s) have been deleted.',$count));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('aktivsatisfiedcustomer/contact/index');
    }
}