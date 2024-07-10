<?php

namespace Nadeem0035\General\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;

class Booking extends \Magento\Framework\App\Action\Action
{


    /**
     * Recipient email config path
     */
    const EMAIL_RECIPIENT = 'contact/email/recipient_email';

    protected $_pageFactory;
    protected $scopeConfig;
    protected $_storeManager;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        ScopeConfigInterface $scopeConfig,
         StoreManagerInterface $storeManager,
        \Magento\Framework\View\Result\PageFactory $pageFactory)
    {
        $this->_pageFactory = $pageFactory;
        $this->scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    public function getStoreCode()
    {
        return $this->_storeManager->getStore()->getCode();
    }


    public function execute()
    {

        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

        $post = (array)$this->getRequest()->getPost();

        $email_recipient = $this->scopeConfig->getValue(self::EMAIL_RECIPIENT, $storeScope) ?: 'roel@eijdems-internet.nl';

        if (empty($post)) {
            $data = [
                'status' => "Fail",
                'message' => "Require field data missing"
            ];
        } else {
            // Retrieve your form data
            $firstname = @$post['first_name'];
            $lastname = @$post['last_name'];
            $phone = @$post['phone'];
            $userEmail = @$post['email'];
            $question = @$post['question'];
            $product_name = @$post['product_name'];
            $product_sku = @$post['product_sku'];
            $option = @$post['quote_option'];
            $nameFrom = $firstname . " " . $lastname;
            $options = '';

            if (!empty($option)) {

                $rawOptions = explode(",", $option);
                foreach ($rawOptions as $value) {
                    $option_value = explode("#", $value);
                    $options .= $option_value[0] . ": " . $option_value[1] . ", ";
                }
            }
            $storeCode = $this->getStoreCode();

            $body = "<p>Hello Admin,</p>";
            $body .= "<p>New Inquiry has been received with following details:</p>";
            $body .= "<p>Name:  $nameFrom</p>";
            $body .= "<p>Email:  $userEmail</p>";
            $body .= "<p>Phone:  $phone</p>";
            $body .= "<p>Customer Question:  $question</p>";
            $body .= "<p>Product Name:  $product_name</p>";
            $body .= "<p>Product SKU:  $product_sku</p>";

            if (!empty($options)) {
                $body .= "<p>Options:  $options</p>";
            }


            if($storeCode == 'am') {
                $body .= "<p>Website: https://www.ammachinery.nl/ </p>";
                $body .= "<p>Regards,</p>";
                $body .= "<p>A&M Machinery Team</p>";
                $email_recipient = array("sales@ammachinery.nl");
            } else {
                $body .= "<p>Website: https://www.global-equipment.com/ </p>";
                $body .= "<p>Regards,</p>";
                $body .= "<p>Global Equipment Team</p>";
                $email_recipient = array("helio@global-equipment.com","roza@global-equipment.com");
            }

            try {


                //$email_recipient = array('nadeem.inventivezone@gmail.com','nadeem@eijdems-internet.nl');
                $email = new \Zend_Mail();
                $email->setSubject("Please contact me about the " . $product_name ." ( " . $product_sku . " )" );
                $email->setBodyText($body);
                $email->setBodyHtml($body);
                if($storeCode == 'am') {
                    $email->setFrom('quote@ammachinery.nl', 'AM Machinery');
                    $email->setReplyTo($userEmail, 'AM Machinery');

                } else {
                    $email->setFrom('quote@global-equipment.com', 'Global Equipment');
                    $email->setReplyTo($userEmail, 'Global Equipment');

                }
                $email->addTo($email_recipient, 'Admin');
                $email->send();

                $data = [
                    'status' => "ok",
                    'message' => "Your inquiry has been submitted successfully. We will contact you back shortly."
                ];
            } catch (\Exception $e) {
                $data = [
                    'status' => "Fail",
                    'message' => "Fail sending email. Please try later"
                ];
            }
        }

        $response = $this->resultFactory
            ->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON)
            ->setData($data);

        return $response;

    }
}
