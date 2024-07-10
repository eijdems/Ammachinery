<?php 
namespace Emizen\Customemail\Controller\Index; 
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Framework\App\Action\Action
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
        $this->_resultPageFactory = $resultPageFactory;
        $this->_pageFactory = $pageFactory;
        $this->_transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->_escaper = $escaper;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_filesystem = $fileSystem;
        parent::__construct($context);
    }
 
    public function execute()
    {   
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $post = $this->getRequest()->getPostValue();
        $this->inlineTranslation->suspend();
        if ($post) { 
            try{
                $postObject         = new \Magento\Framework\DataObject();
                $postObject->setData($post);
                $dekra_sku          = '#'.$postObject['dekra_sku'];
                $d_email            = $postObject['d_email'];
                
                $error              = false;
                
                $fromEmail          = $this->scopeConfig->getValue('trans_email/ident_custom1/email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
                
                $toEmail            = 'sales@ammachinery.nl';
                
                $sender = [ 'name'  => 'Ammachinery',
                    'email'         => $fromEmail
                ];
                
                $storeScope         = \Magento\Store\Model\ScopeInterface::SCOPE_STORE; 
                $transport          = $this->_transportBuilder->setTemplateIdentifier(7)->setTemplateOptions(
                        [
                            'area'  => \Magento\Framework\App\Area::AREA_FRONTEND, // this is using frontend area to get the template file
                            'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                        ]
                    )
                    ->setTemplateVars( [
                        'dekra_sku'             => $dekra_sku,
                        'd_email'               => $d_email
                    ])
                    ->setFrom($sender)->addTo($toEmail);

                    $transport->getTransport()->sendMessage();
                    $this->inlineTranslation->resume();
                    $this->messageManager->addSuccess(
                    __('Thanks for contacting us with your comments and questions. We\'ll respond to you very soon.')
                );
                $this->_redirect($post['p_url']);
                return;
            } catch (\Exception $e) {
                $this->inlineTranslation->resume();
                $this->messageManager->addError(__('We can\'t process your request right now. Sorry, that\'s all we know.'.$e->getMessage())
                );
                $this->_redirect($post['p_url']);
                return;
            }
        } else {
            $resultPage = $this->_resultPageFactory->create();
            return $resultPage;
        }
    }
}
