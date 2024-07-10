<?php

namespace Aktiv\Satisfiedcustomer\Controller\Adminhtml\Contact;

use Aktiv\Satisfiedcustomer\Model\Contact as contact;

class Save extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;

    protected $contactFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Aktiv\Satisfiedcustomer\Model\ContactFactory $contactFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->contactFactory = $contactFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue('contact');
        if ($data) {
            try {
                if (array_key_exists('id', $data)) {
                    $id = $data['id'];
                    if ($data['main_field'] == 0) {
                        $data['image'] = null;
                        $data['text'] = null;
                    } elseif ($data['main_field'] == 1) {
                        $data['sourceimage'] = null;
                        $data['video'] = null;
                        $data['text'] = null;
                    } elseif ($data['main_field'] == 2) {
                        $data['sourceimage'] = null;
                        $data['video'] = null;
                        $data['image'] = null;
                    }
                    $contact = $this->contactFactory->create()->load($id);
                    if (isset($data['image']) && isset($data['image'][0]) && isset($data['image'][0]['name'])) {
                        $imagename=$data['image'][0]['name'];
                        $data['image']= $imagename;
                    }
                    if (isset($data['sourceimage']) && isset($data['sourceimage'][0])
                         && isset($data['sourceimage'][0]['name'])) {
                        $simagename=$data['sourceimage'][0]['name'];
                        $data['sourceimage']= $simagename;
                    }
                    $data = array_filter($data, function ($value) {return $value !== ''; });
                    $contact->setData($data);
                    $contact->save();
                    $this->messageManager->addSuccess(__('Successfully saved.'));
                    return $resultRedirect->setPath('*/*/');
                } else {
                    $contact = $this->contactFactory->create();
                    if (isset($data['image']) && isset($data['image'][0]) && isset($data['image'][0]['name'])) {
                        $imagename=$data['image'][0]['name'];
                        $data['image']= $imagename;
                    }
                    if (isset($data['sourceimage']) && isset($data['sourceimage'][0])
                         && isset($data['sourceimage'][0]['name'])) {
                        $simagename=$data['sourceimage'][0]['name'];
                        $data['sourceimage']= $simagename;
                    }
                    $contact->setData($data);
                    $contact->save();
                    $this->messageManager->addSuccess(__('Successfully saved.'));
                    return $resultRedirect->setPath('*/*/');
                }
            } catch (\Exception $d) {
                $this->messageManager->addError($d->getMessage());
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
}
