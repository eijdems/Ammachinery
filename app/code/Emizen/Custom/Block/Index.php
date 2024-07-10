<?php
namespace Emizen\Custom\Block;
 
class Index extends \Magento\Framework\View\Element\Template
{	
	protected $_resultPageFactory;
	protected $_pageFactory;
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Framework\View\Result\PageFactory $pageFactory

	) {
		parent::__construct($context);
		$this->_resultPageFactory = $resultPageFactory;
        $this->_pageFactory = $pageFactory;
	}
    public function getFormAction()
    {	
        $resultPage = $this->_resultPageFactory->create();
        
       return $this->getUrl('sell-your-self-propelled-forage-harvester/index/save');
    }
}