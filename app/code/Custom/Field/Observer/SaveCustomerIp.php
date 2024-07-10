<?php

namespace Custom\Field\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;

Class SaveCustomerIp implements ObserverInterface {
	
    public $_customerRepositoryInterface;
    public $_messageManager;
	private $remoteAddress;
	
    public function __construct(
            CustomerRepositoryInterface $customerRepositoryInterface,
            ManagerInterface $messageManager,
			RemoteAddress $remoteAddress
    ) {
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->_messageManager = $messageManager;
		 $this->remoteAddress = $remoteAddress;
    }
    
    public function execute(\Magento\Framework\Event\Observer $observer) {
       $accountController = $observer->getAccountController();
       $request = $accountController->getRequest();
	   $remoteIp = $this->remoteAddress->getRemoteAddress();
       
       try {
           $customerId = $observer->getCustomer()->getId();
           $customer = $this->_customerRepositoryInterface->getById($customerId);
		   $customer->setCustomAttribute('ip_address', $remoteIp);
           $this->_customerRepositoryInterface->save($customer);
           
       } catch (Exception $e){
           $this->_messageManager->addErrorMessage(__('Something went wrong! Please try again.'));
       }
    }
}