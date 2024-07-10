<?php

namespace MageBeans\Stocklist\Helper;

use Magento\Backend\Model\Session;
use Magento\Catalog\Helper\Image;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as productCollectionFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Data\CollectionFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\TestFramework\Inspection\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Data extends AbstractHelper
{
    const XML_CONFIG_PATH_MODULE_ENABLE = 'stocklist_section/general/module_enable';
    const XML_CONFIG_PATH_SENDER_NAME = 'stocklist_section/general/sender_information/sender_name';
    const XML_CONFIG_PATH_SENDER_EMAIL = 'stocklist_section/general/sender_information/sender_email';
    const XML_CONFIG_PATH_RECIPIENT_NAME = 'stocklist_section/general/recipient_information/recipient_name';
    const XML_CONFIG_PATH_RECIPIENT_EMAIL = 'stocklist_section/general/recipient_information/recipient_email';

    /**
     * @var Session
     */
    protected $_adminSession;

    protected $resultPageFactory;
    protected $fileFactory;
    protected $_resultFactory;
    protected $_xlsx;
    protected $resultPage;
    /**
     * @var FileFactory
     */
    private $_fileFactory;
    /**
     * @var DirectoryList
     */
    private $_directoryList;
    /**
     * @var Filesystem
     */
    private $_filesystem;
    /**
     * @var CollectionFactory
     */
    private $_collectionFactory;
    /**
     * @var ProductRepository
     */
    private $_productRepository;
    /**
     * @var StoreManagerInterface
     */
    private $_storeManager;
    /**
     * @var Image
     */
    private $_productImageHelper;
    /**
     * @var productCollectionFactory
     */
    private $_productCollectionFactory;
    /**
     * @var CategoryFactory
     */
    private $categoryFactory;

    /** @var \Magento\Framework\App\State **/
    private $state;
    /**
     * @var TransportBuilder
     */
    private $transportBuilder;
    /**
     * @var StateInterface
     */
    private $inlineTranslation;

    /**
     *
     * @param Context $context
     * @param Session $adminSession
     * @param PageFactory $resultPageFactory
     * @param ResultFactory $resultFactory
     * @param FileFactory $fileFactory
     * @param DirectoryList $directoryList
     * @param Filesystem $filesystem
     * @param CollectionFactory $collectionFactory
     * @param Xlsx $xlsx
     * @param ProductRepository $productRepository
     * @param StoreManagerInterface $storeManager
     * @param Image $productImageHelper
     * @param productCollectionFactory $productCollectionFactory
     * @param CategoryFactory $categoryFactory
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     */
    public function __construct(
        Context $context,
        Session $adminSession,
        PageFactory $resultPageFactory,
        ResultFactory $resultFactory,
        FileFactory $fileFactory,
        DirectoryList $directoryList,
        Filesystem $filesystem,
        CollectionFactory $collectionFactory,
        Xlsx $xlsx,
        ProductRepository $productRepository,
        StoreManagerInterface $storeManager,
        Image $productImageHelper,
        productCollectionFactory $productCollectionFactory,
        CategoryFactory $categoryFactory,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation
    ) {
        parent::__construct($context);
        $this->_adminSession = $adminSession;
        $this->resultPageFactory = $resultPageFactory;
        $this->_fileFactory = $fileFactory;
        $this->_directoryList = $directoryList;
        $this->_filesystem = $filesystem;
        $this->_collectionFactory = $collectionFactory;
        $this->_xlsx = $xlsx;
        $this->_productRepository = $productRepository;
        $this->_storeManager = $storeManager;
        $this->_productImageHelper = $productImageHelper;
        $this->_resultFactory = $resultFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->categoryFactory = $categoryFactory;
        $this->transportBuilder =$transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
    }

    public function getCategoryName($categoryArray)
    {
        foreach ($categoryArray as $category) {
            $category = $this->categoryFactory->create()->load($category);
            return $category->getName();
        }
    }

    public function sendData($filename)
    {
        if ($this->isEnable()) {
            $senderName = $this->getConfig(self::XML_CONFIG_PATH_SENDER_NAME);
            $senderEmail = $this->getConfig(self::XML_CONFIG_PATH_SENDER_EMAIL);
            $recipientName = $this->getConfig(self::XML_CONFIG_PATH_RECIPIENT_NAME);
            $recipientEmail = $this->getConfig(self::XML_CONFIG_PATH_RECIPIENT_EMAIL);
            $this->sendEmail($filename, $senderName, $senderEmail, $recipientName, $recipientEmail);
        }
    }

    public function getData()
    {
        try {
            $categories = [91, 99, 95, 96, 98, 97, 102];
            $websiteId = 0;
            $productIds = [];
            $collection = $this->_productCollectionFactory->create();
            $collection->addAttributeToSelect('*');
            $collection->addUrlRewrite();
            $collection->addCategoriesFilter(['in' => $categories]);
            $dataArray = $collection;
            $totalData = [];
            $i = 0;
            foreach ($dataArray as $item) {
                $totalData[$i]['Product Image'] = '';
                $totalData[$i]['Category'] = $this->getCategoryName($item->getCategoryIds());
                $totalData[$i]['Stocknumber'] = $item->getSku();
                $totalData[$i]['Title'] = $item->getName();
                $totalData[$i]['Build Year'] = $item->getResource()->getAttribute('build_year')->getFrontend()->getValue($item);
                $url = $item->getUrlModel()->getUrl($item);
                $totalData[$i]['More Details'] = '=HYPERLINK("' . $url . '", "Click here for more details")';
                $productIds[] = $item->getId();
                $i++;
            }

            $headerColumns = ['0' => ['Product Image', 'Category', 'Stocknumber', 'Title', 'Build Year', 'More Details']];

            $excelData = array_merge($headerColumns, $totalData);
            $imageData = $this->processDataForXlsxImage($websiteId, $productIds);
            $xlsxFileName = 'file.xlsx';
            $xlsxFilePath = $this->getFilePath($xlsxFileName);
            $this->generateXlsx($excelData, $xlsxFilePath);
            $this->addImageToXlsx($imageData, $xlsxFilePath);
            $this->downloadXlsx($xlsxFilePath);
            return $xlsxFilePath;
        } catch (\Exception $ex) {
            //$this->messageManager->addErrorMessage($ex->getMessage());
        }
    }

    public function isEnable()
    {
        return $this->getConfig(self::XML_CONFIG_PATH_MODULE_ENABLE);
    }

    public function getFilePath($fileName)
    {
        return $this->_directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR) . "/stocklist/" . $fileName;
    }

    public function generateXlsx($excelData, $filePath)
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Excel File');
        $sheet->fromArray($excelData);
        $writer = $this->_xlsx->setSpreadsheet($spreadsheet);
        $writer->save($filePath);
    }

    public function downloadXlsx($xlsxFilePath)
    {
        if (file_exists($xlsxFilePath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename=' . basename($xlsxFilePath));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($xlsxFilePath));
            ob_clean();
            flush();
            readfile($xlsxFilePath);
        }
    }

    public function getProductIds()
    {
        $data = [];
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addUrlRewrite();
        $dataArray = $collection;
        $arrayExport = $dataArray;
        if (count($arrayExport) > 0) {
            foreach ($arrayExport as $value) {
                $data[] = $value['id'];
            }
            return $data;
        }
        return $data;
    }

    public function processDataForXlsxImage($store, $productIds)
    {
        $result = [];
        $mediaDirectory = $this->getMediaPath();
        foreach ($productIds as $productId) {
            $product = $this->_productRepository->getById($productId);
            $imageUrl = $this->_productImageHelper
                ->init($product, 'category_page_grid_thumbnail')
                ->setImageFile($product->getSmallImage())
                ->keepFrame(false)
                ->keepAspectRatio(false)
                ->resize(70, 70)
                ->getUrl();
            $result[] = $this->getImagePath($imageUrl, $mediaDirectory);
        }
        return $result;
    }

    public function addImageToXlsx($imageData, $xlsxFilePath)
    {
        try {
            if (count($imageData)) {
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($xlsxFilePath);
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($xlsxFilePath);
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($xlsxFilePath);
                $cellNo = 1;
                foreach ($imageData as $image) {
                    if ($cellNo >= 1 && $image != '') {
                        $extension = pathinfo($image, PATHINFO_EXTENSION);
                        if ($extension == 'png') {
                            if (is_file($image)) {
                                $gdImage = imagecreatefrompng($image);
                            }
                        }
                        if ($extension == 'jpg' || $extension == 'jpeg') {
                            $gdImage = imagecreatefromjpeg($image);
                        }
                        if ($extension == 'gif') {
                            $gdImage = imagecreatefromgif($image);
                        }
                        $this->drawImage($gdImage, $xlsxFilePath, $spreadsheet, $inputFileType, $cellNo);
                    }
                    $cellNo++;
                }
            }
        } catch (Exception $e) {
        }
    }

    public function sendEmail($filename, $senderName, $senderEmail, $recipientName, $recipientEmail)
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/stocklist-emails.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $file = file_get_contents($filename);
        $recipientEmail = explode(',', $recipientEmail);
        foreach ($recipientEmail as $recipient) {
            $recipient = trim($recipient);
            if (filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                $this->inlineTranslation->suspend();
                $transportBuilder = null;
                $transport = null;
                $transportBuilder = $this->transportBuilder;
                $transport = $transportBuilder
                    ->setTemplateIdentifier(6)
                    ->setTemplateOptions(['area' => 'frontend', 'store' => 2])
                    ->setTemplateVars([])
                    ->setFrom(['email'=>$senderEmail, 'name'=>$senderName])
                    ->addTo($recipient, $recipientName)
                    ->addAttachment($file, 'AM-Machinery-StockList-' . date("d-m-Y") . '.pdf', mime_content_type($filename))
                    ->getTransport();
                $transport->sendMessage();
                $this->inlineTranslation->resume();
                $logger->info($filename . ' sent to an Email : ' . $recipient);
            } else {
                $logger->info($recipient . ' is not a valid email address');
            }
        }
    }

    public function getImagePath($imageUrl, $mediaDirectory)
    {
        if ($imageUrl != '') {
            if ($this->fileExists($imageUrl)) {
                return $imageUrl;
            } else {
                return $mediaDirectory . 'catalog/product/placeholder/' . $this->getPlaceholderImage();
            }
        }
        return '';
    }

    public function getPlaceholderImage()
    {
        return $this->_storeManager->getStore()->getConfig('catalog/placeholder/image_placeholder');
    }

    public function fileExists($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code == 200) {
            $status = true;
        } else {
            $status = false;
        }
        curl_close($ch);
        return $status;
    }

    public function drawImage($gdImage, $filePath, $spreadsheet, $inputFileType, $cellNo)
    {
        $cellNo = $cellNo + 1;
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, $inputFileType);
        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();
        $objDrawing = new \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing();
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::RENDERING_PNG);
        $objDrawing->setMimeType(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setCoordinates('A' . $cellNo);
        $objDrawing->setOffsetX(0);
        $objDrawing->setOffsetY(0);
        $objDrawing->setHeight(96);
        $objDrawing->setWidth(96);
        if (empty((array) $objDrawing->getWorksheet())) {
            $objDrawing->setWorksheet($activeSheet);
        }
        $activeSheet->getRowDimension($cellNo)->setRowHeight(72);
        $activeSheet->getColumnDimension('A')->setWidth(13.18);
        $activeSheet->getStyle('B1:J' . $spreadsheet->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $activeSheet->getStyle('B1:J' . $spreadsheet->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $activeSheet->getColumnDimension('B')->setAutoSize(true);
        foreach (range('C', 'J') as $columnID) {
            $activeSheet->getColumnDimension($columnID)->setAutoSize(false);
            $activeSheet->getColumnDimension($columnID)->setWidth(15);
            $activeSheet->getStyle('B1:J' . $spreadsheet->setActiveSheetIndex(0)->getHighestRow())->getAlignment()->setWrapText(true);
        }

        $writer->save($filePath);
    }

    public function getMediaPath()
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }
    public function getConfig($path, $scope = ScopeInterface::SCOPE_STORE)
    {
        /**
         * For Website
         *
         * $configValue = $this->scopeConfig->getValue(self::XML_CONFIG_PATH,ScopeInterface::SCOPE_WEBSITE);
         */
        return $this->scopeConfig->getValue($path, $scope);
    }
}
