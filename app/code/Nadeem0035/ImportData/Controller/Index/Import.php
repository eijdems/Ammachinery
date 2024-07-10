<?php

namespace Nadeem0035\ImportData\Controller\Index;


use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Action;
use Nadeem0035\ImportData\Console\Command\Product\ImportProduct;
use Nadeem0035\ImportData\Helper\Attributes;

class Import extends Action
{

    protected $_pageFactory;
    protected $scopeConfig;
    protected $importProduct;
    protected $attributes_helper;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        PageFactory $pageFactory,
        ImportProduct $importProduct,
        Attributes $attributes_helper
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->scopeConfig = $scopeConfig;
        $this->importProduct = $importProduct;
        $this->attributes_helper = $attributes_helper;
        parent::__construct($context);
    }


    public function execute()
    {

        $collections = array('Antonio Carraro',
            'Belarus',
            'Bergmeister'
        );

//        foreach ($collections as $data) {
//           // echo $data; break;
//            //echo $manufacturerId = $this->attributes_helper->createOrGetId('manufacturer', $data)."<br>";
//        }
      //  $this->importProduct->createCategories("Nadeem","Iqbal");

//        $data = $this->importProduct->readData();
//        echo "<pre>";
////        $res = $this->importProduct->copyDocuments($data['18']['documents']);
////        print_r($res);
//        print_r($data);

    }
}