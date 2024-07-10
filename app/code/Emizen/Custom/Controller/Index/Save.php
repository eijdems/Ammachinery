<?php 
namespace Emizen\Custom\Controller\Index; 
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultFactory;

class Save extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;

    protected $_pageFactory;

    protected $_transportBuilder;

    protected $inlineTranslation;

    protected $scopeConfig;

    protected $_escaper;

    protected $_fileUploaderFactory;

    protected $fileSystem;
    

    public function __construct(
        Context $context, 
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Escaper $escaper,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Magento\Framework\Filesystem $fileSystem
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
        $this->_pageFactory = $pageFactory;
        $this->_transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->_escaper = $escaper;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_filesystem = $fileSystem;
    }
 
    public function execute()
    {   

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $post = $this->getRequest()->getPostValue();
        $this->inlineTranslation->suspend();
        if ($post) 
        {   
            /*echo '<pre>';
            print_r($file);
            die('sssss');*/
            /*$uploader   = $this->_fileUploaderFactory->create(['fileId' => 'attach_file']);
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png', 'pdf']);
            $uploader->setAllowRenameFiles(false);
            $uploader->setFilesDispersion(false);
            $path       = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('images/');
            $file       = $uploader->save($path);   
    
            $filename   = $file['file'];
            $filepath   = $file['path'].$file['file'];*/  
            try{
                $postObject         = new \Magento\Framework\DataObject();
                $postObject->setData($post);
                $f_name             = $postObject['f_name'];
                $l_name             = $postObject['l_name'];
                $a_email            = $postObject['a_email'];
                $ph_number          = $postObject['ph_number'];
                $address_name       = $postObject['address_name'];
                $zipcode_name       = $postObject['zipcode_name'];
                $place_name         = $postObject['place_name'];              
                $country_name       = $postObject['country_name'];                
                $brand_name         = $postObject['brand_name'];              
                $type_name          = $postObject['type_name'];                
                $serialnumber_name  = $postObject['serialnumber_name'];
                $manufacturing_name = $postObject['manufacturing_name'];                
                $ehours_name        = $postObject['ehours_name'];              
                $dhours_name        = $postObject['dhours_name'];                
                $price_name         = $postObject['price_name'];
                $email_name         = $postObject['email_name'];
                $attachments_name   = $postObject['attachments_name'];
                $options_name       = $postObject['options_name'];
                $error              = false;
                
                $fromEmail          = $this->scopeConfig->getValue('trans_email/ident_custom1/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
                
                $toEmail            = $this->scopeConfig->getValue('trans_email/ident_custom2/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
                
                $sender = [
                    'name'          => $this->_escaper->escapeHtml($post['f_name']),
                    'l_name'        => $this->_escaper->escapeHtml($post['l_name']),
                    'email'         => $fromEmail
                ];
                
                $storeScope         = \Magento\Store\Model\ScopeInterface::SCOPE_STORE; 
                $transport          = $this->_transportBuilder->setTemplateIdentifier('Call_For_Price')->setTemplateOptions(
                        [
                            'area'  => \Magento\Framework\App\Area::AREA_FRONTEND, // this is using frontend area to get the template file
                            'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                        ]
                    )
                    ->setTemplateVars( [
                        'f_name'                => $f_name,
                        'l_name'                => $l_name,
                        'a_email'               => $a_email,
                        'ph_number'             => $ph_number,
                        'address_name'          =>$address_name,
                        'zipcode_name'          =>$zipcode_name,
                        'place_name'            =>$place_name,
                        'country_name'          =>$country_name,
                        'brand_name'            =>$brand_name,
                        'type_name'             =>$type_name,
                        'serialnumber_name'     =>$serialnumber_name,
                        'manufacturing_name'    =>$manufacturing_name,
                        'ehours_name'           =>$ehours_name,
                        'dhours_name'           =>$dhours_name,
                        'attachments_name'      =>$attachments_name,
                        'options_name'          =>$options_name,
                        'price_name'            =>$price_name
                    ])
                    ->setFrom($sender)->addTo($toEmail);

                    $files = $this->getRequest()->getFiles();
                    $images = $this->getRequest()->getFiles('attach_file');
                    
                      $i = 0;
                      foreach ($images as $filesa) {
                        if (isset($filesa['tmp_name']) && strlen($filesa['tmp_name']) > 0) {
                          try {
                            $uploader = $this->_fileUploaderFactory->create(['fileId' => $images[$i]]);
                            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                            $uploader->setAllowRenameFiles(true);
                            $path       = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('images/');
                            $data['images'] = $files['name'];
                            $file = $uploader->save($path);
                            $filename   = $file['file'];
                            $filepath   = $file['path'].$file['file'];
                            $transport->addAttachment(file_get_contents($filepath),$filename,mime_content_type($filepath));
                            // echo $result['file']; 
                          }catch (\Exception $e) {
                            $this->messageManager->addError(__($e->getMessage()));
                          }
                        }
                        $i++;
                      }

                   // print_r($transport->debug());die;

                    $transport->getTransport()->sendMessage();
                    $this->inlineTranslation->resume();
                    $this->messageManager->addSuccess(
                        __("Thanks for contacting us with your comments and questions." )
                    );
                    $resultRedirect->setPath('sell-your-self-propelled-forage-harvester');
                    return $resultRedirect;
                }
                catch (\Exception $e) {
                    $this->inlineTranslation->resume();
                    $this->messageManager->addError(__('We can\'t process your request right now. Sorry, that\'s all we know.'.$e->getMessage())
                    );
                    $resultRedirect->setPath('sell-your-self-propelled-forage-harvester');
                    return $resultRedirect;
                }
        } else {
            $resultPage = $this->_resultPageFactory->create();
            return $resultPage;
        }
    }
}