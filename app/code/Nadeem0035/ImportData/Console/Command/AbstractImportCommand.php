<?php

namespace Nadeem0035\ImportData\Console\Command;

use Exception;
use Magento\Backend\App\Area\FrontNameResolver;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\Product\Gallery\Processor;
use Magento\Catalog\Model\Product\Gallery\ReadHandler;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Model\ResourceModel\Product\Gallery;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ObjectManagerFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\State;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\ObjectManager\ConfigLoaderInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Registry;
use Magento\ImportExport\Model\Import;
use Magento\Indexer\Model\Indexer\CollectionFactory;
use Magento\Indexer\Model\IndexerFactory;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManager;
use Magento\Store\Model\StoreManagerInterface;
use Nadeem0035\ImportData\Helper\Config;
use Nadeem0035\ImportData\Model\Adapters\NestedArrayAdapterFactory;
use Nadeem0035\ImportData\Model\Importer;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractImportCommand extends Command
{
    public $username;
    public $password;
    public $URL;
    /**
     * @var string
     */
    protected $behavior;
    /**
     * @var string
     */
    protected $entityCode;
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;
    protected $_objectManager;
    protected $__objectManager;
    protected $configHelper;
    protected $_storeManager;
    /**
     * @var \Magento\Indexer\Model\IndexerFactory
     */
    protected $_indexerFactory;
    /**
     * @var \Magento\Indexer\Model\Indexer\CollectionFactory
     */
    protected $_indexerCollectionFactory;
    /**
     * Directory List
     *
     * @var DirectoryList
     */
    protected $directoryList;
    /**
     * Constructor
     *
     * @param ObjectManagerFactory $objectManagerFactory
     */
    /**
     * File interface
     *
     * @var File
     */
    protected $file;
    protected $_productRepository;
    protected $_store;
    /**
     * Object manager factory
     *
     * @var ObjectManagerFactory
     */
    private $objectManagerFactory;
    private $configLoaderInterface;
    private $importer;
    private $nestedArrayAdapterFactory;
    private $categoryFactory;
    private $productFactory;
    private $state;
    private $_resource;
    private $_logger;
    private $_registry;
    private $_readHandler;
    private $_processor;
    private $_gallery;
    private $_productRepositoryInterface;

    public function __construct(
        ObjectManagerFactory $objectManagerFactory,
        ConfigLoaderInterface $configLoaderInterface,
        Importer $importer,
        Config $configHelper,
        NestedArrayAdapterFactory $NestedArrayAdapterFactory,
        IndexerFactory $indexerFactory,
        CollectionFactory $indexerCollectionFactory,
        CategoryFactory $categoryFactory,
        ProductFactory $productFactory,
        DirectoryList $directoryList,
        File $file,
        ProductRepository $productRepository,
        ObjectManagerInterface $_objectManager,
        StoreManagerInterface $storeManager,
        Store $store,
        State $state,
        ResourceConnection $resource,
        LoggerInterface $logger,
        Registry $registry,
        ReadHandler $readHandler,
        Processor $processor,
        Gallery $gallery,
        ProductRepositoryInterface $productRepositoryInterface
    ) {
        $this->__objectManager = $_objectManager;
        $this->_storeManager = $storeManager;
        $this->_storeManager->setCurrentStore(1);
        $this->objectManagerFactory = $objectManagerFactory;
        $this->configLoaderInterface = $configLoaderInterface;
        $this->importer = $importer;
        $this->importercat = $importer;
        $this->configHelper = $configHelper;
        $this->nestedArrayAdapterFactory = $NestedArrayAdapterFactory;
        $this->configHelper = $configHelper;
        $this->URL = $this->configHelper->getImportUrl();
        $this->username = $this->configHelper->getImportUserName();
        $this->password = $this->configHelper->getImportPassword();
        $this->_indexerFactory = $indexerFactory;
        $this->_indexerCollectionFactory = $indexerCollectionFactory;
        $this->categoryFactory = $categoryFactory;
        $this->productFactory = $productFactory;
        $this->directoryList = $directoryList;
        $this->file = $file;
        $this->_store = $store;
        $this->state = $state;
        $this->_productRepository = $productRepository;
        $this->_resource = $resource;
        $this->_logger = $logger;
        $this->_registry = $registry;
        $this->_readHandler = $readHandler;
        $this->_processor = $processor;
        $this->_gallery = $gallery;
        $this->_productRepositoryInterface = $productRepositoryInterface;
        parent::__construct();
    }

    public function getImportUrl()
    {
        return $this->URL;
    }

    public function getImportUserName()
    {
        return $this->username;
    }

    public function getImportPassword()
    {
        return $this->password;
    }

    public function writeLog($message)
    {
        if (is_array($message)) {
            $this->_logger->notice(print_r($message, true));
        } else {
            $this->_logger->notice($message);
        }
    }

    public function arrayToAttributeString($array)
    {
        $attributes_str = null;
        foreach ($array as $attribute => $value) {
            $attributes_str .= "$attribute=$value,";
        }

        return $attributes_str;
    }

    public function importCategory($separator, $cat_1, $cat_2 = '', $cat_3 = '', $cat_4 = '', $cat_5 = '', $cat_6 = '')
    {
        $importerModelCat = $this->importercat;
        $importerModel = $this->importer;

        $categoryArray = [];

        if (!empty($cat_1)) {
            if (!$this->checkCategory($cat_1, 2)) {
                $categoryArray[] = [
                    '_root' => 'Default Category',
                    '_category' => $cat_1,
                    'is_active' => '1',
                    'include_in_menu' => '1',
                    'available_sort_by' => 'position',
                    'default_sort_by' => 'position',
                ];
            }
        }

        if (!empty($cat_1) && !empty($cat_2)) {
            if (!$this->checkCategory($cat_2, 3)) {
                $categoryArray[] = [
                    '_root' => 'Default Category',
                    '_category' => $cat_1 . $separator . $cat_2,
                    'is_active' => '1',
                    'include_in_menu' => '1',
                    'available_sort_by' => 'position',
                    'default_sort_by' => 'position',
                ];
            }
        }

        if (!empty($cat_1) && !empty($cat_2) && !empty($cat_3)) {
            if (!$this->checkCategory($cat_3, 4)) {
                $categoryArray[] = [
                    '_root' => 'Default Category',
                    '_category' => $cat_1 . $separator . $cat_2 . $separator . $cat_3,
                    'is_active' => '1',
                    'include_in_menu' => '1',
                    'available_sort_by' => 'position',
                    'default_sort_by' => 'position',
                ];
            }
        }

        if (!empty($cat_1) && !empty($cat_2) && !empty($cat_3) && !empty($cat_4)) {
            if (!$this->checkCategory($cat_4, 5)) {
                $categoryArray[] = [
                    '_root' => 'Default Category',
                    '_category' => $cat_1 . $separator . $cat_2 . $separator . $cat_3 . $separator . $cat_4,
                    'is_active' => '1',
                    'include_in_menu' => '1',
                    'available_sort_by' => 'position',
                    'default_sort_by' => 'position',
                ];
            }
        }

        if (!empty($cat_1) && !empty($cat_2) && !empty($cat_3) && !empty($cat_4) && !empty($cat_5)) {
            if (!$this->checkCategory($cat_5, 6)) {
                $categoryArray[] = [
                    '_root' => 'Default Category',
                    '_category' => $cat_1 . $separator . $cat_2 . $separator . $cat_3 . $separator . $cat_4 . $separator . $cat_5,
                    'is_active' => '1',
                    'include_in_menu' => '1',
                    'available_sort_by' => 'position',
                    'default_sort_by' => 'position',
                ];
            }
        }

        if (!empty($cat_1) && !empty($cat_2) && !empty($cat_3) && !empty($cat_4) && !empty($cat_5) && !empty($cat_6)) {
            if (!$this->checkCategory($cat_6, 7)) {
                $categoryArray[] = [
                    '_root' => 'Default Category',
                    '_category' => $cat_1 . $separator . $cat_2 . $separator . $cat_3 . $separator . $cat_4 . $separator . $cat_5 . $separator . $cat_6,
                    'is_active' => '1',
                    'include_in_menu' => '1',
                    'available_sort_by' => 'position',
                    'default_sort_by' => 'position',
                ];
            }
        }

        if (!empty($categoryArray)) {
            $this->setBehavior(Import::BEHAVIOR_ADD_UPDATE);
            $importerModelCat->setEntityCode('catalog_category');

            try {
                $importerModelCat->processImport($categoryArray);
            } catch (\Exception $e) {
                print_r($e->getMessage());
            }
            $this->setBehavior(Import::BEHAVIOR_ADD_UPDATE);
            $importerModel->setEntityCode('catalog_product');
        }
    }

    public function checkCategory($categoryTitle, $level)
    {
        $categories = $this->categoryFactory->create()->getCollection()->addAttributeToFilter('parent_id', ['eq'=>2])->addFieldToFilter('name', ['in' => $categoryTitle]);

        if ($categories->getSize()) {
            foreach ($categories as $category) {
                if ($category->getLevel() == $level) {
                    return true;
                }
            }
        }

        return false;
    }

    public function createCategories($cat_1, $cat_2 = '', $cat_3 = '', $cat_4 = '', $cat_5 = '', $cat_6 = '')
    {
        if (!empty($cat_1)) {
            if (!$this->checkCategory($cat_1, 2)) {
                $parentCatId = $this->getRootCatId();
                if (!empty($parentCatId)) {
                    $this->createCategory($cat_1, $parentCatId);
                }
            }
        }

        if (!empty($cat_1) && !empty($cat_2)) {
            if (!$this->checkCategory($cat_2, 3)) {
                $parentCatId = $this->getCategoryId($cat_1, 2);
                if (!empty($parentCatId)) {
                    $this->createCategory($cat_2, $parentCatId);
                }
            }
        }

        if (!empty($cat_1) && !empty($cat_2) && !empty($cat_3)) {
            if (!$this->checkCategory($cat_3, 4)) {
                $parentCatId = $this->getCategoryId($cat_2, 3);
                if (!empty($parentCatId)) {
                    $this->createCategory($cat_3, $parentCatId);
                }
            }
        }

        if (!empty($cat_1) && !empty($cat_2) && !empty($cat_3) && !empty($cat_4)) {
            if (!$this->checkCategory($cat_4, 5)) {
                $parentCatId = $this->getCategoryId($cat_3, 4);
                if (!empty($parentCatId)) {
                    $this->createCategory($cat_4, $parentCatId);
                }
            }
        }

        if (!empty($cat_1) && !empty($cat_2) && !empty($cat_3) && !empty($cat_4) && !empty($cat_5)) {
            if (!$this->checkCategory($cat_5, 6)) {
                $parentCatId = $this->getCategoryId($cat_4, 5);
                if (!empty($parentCatId)) {
                    $this->createCategory($cat_5, $parentCatId);
                }
            }
        }

        if (!empty($cat_1) && !empty($cat_2) && !empty($cat_3) && !empty($cat_4) && !empty($cat_5) && !empty($cat_6)) {
            if (!$this->checkCategory($cat_6, 7)) {
                $parentCatId = $this->getCategoryId($cat_5, 6);
                if (!empty($parentCatId)) {
                    $this->createCategory($cat_6, $parentCatId);
                }
            }
        }
    }

    public function getRootCatId()
    {
        return $this->getStore()->getRootCategoryId();
    }

    public function getStore()
    {
        return $this->_storeManager->getStore();
    }

    public function createCategory($catName, $parentCatId)
    {

        /// Get Root Category
        $parentCat = $this->getCategory($parentCatId);

        $storeId = $this->getStore()->getStoreId();

        $cleanUrl = trim(preg_replace('/ +/', '', preg_replace('/[^A-Za-z0-9 ]/', '', urldecode(html_entity_decode(strip_tags(strtolower($catName)))))));
        $categoryFactory = $this->__objectManager->get('\Magento\Catalog\Model\CategoryFactory');
        /// Add a new sub category under root category
        $category = $categoryFactory->create();
        $category->setName($catName);
        $category->setIsActive(true);
        $category->setUrlKey($cleanUrl);
        $category->setParentId($parentCat->getId());
        $category->setStoreId($storeId);
        $category->setPath($parentCat->getPath());
        $category->save();
    }

    public function getCategory($catId)
    {
        $rootCat = $this->__objectManager->get('Magento\Catalog\Model\Category');
        return $rootCat->load($catId);
    }

    public function getCategoryId($categoryTitle, $level)
    {
        $categories = $this->categoryFactory->create()->getCollection()->addAttributeToFilter('parent_id', ['eq'=>2])->addFieldToFilter('name', ['in' => $categoryTitle]);

        if ($categories->getSize()) {
            foreach ($categories as $category) {
                if ($category->getLevel() == $level) {
                    return $category->getId();
                }
            }
        }

        return false;
    }

    public function assignProductToCategory($productSku, $categoryIds = [])
    {
        $categoryLinkRepository = $this->__objectManager->get(\Magento\Catalog\Api\CategoryLinkManagementInterface::class);
        if (!empty($categoryIds)) {
            $categoryLinkRepository->assignProductToCategories(
                $productSku,
                $categoryIds
            );
        }
    }

    public function reIndexing()
    {
        $indexerIds = [
            'catalog_category_product',
            'catalog_product_category',
            'catalog_product_price',
            'catalog_product_attribute',
            'cataloginventory_stock',
            'catalogrule_product',
            'catalogsearch_fulltext',
        ];
        foreach ($indexerIds as $indexerId) {
            echo " create index: " . $indexerId . "\n";
            $indexer = $this->_indexerFactory->create();
            $indexer->load($indexerId);
            $indexer->reindexAll();
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_FRONTEND); // or \Magento\Framework\App\Area::AREA_ADMINHTML, depending on your needs
        $this->_registry->register('isSecureArea', true);

        $time = microtime(true);
        $output->writeln('Import started: ' . date("Y-m-d H:i:s"));
        $i = 0;
        $productsArray = $this->getEntities();
        if (!empty($productsArray)) {
            $productSku = [];
            foreach ($productsArray as $product) {
                $this->addUpdateDeleteProduct($product);
                $output->write('', true);
                $productSku[] = $product['sku'];
//                if ($i++ == 5)
//                    break;
            }
            $output->writeln('Deleting Products started: ' . date("Y-m-d H:i:s"));
            //Delete products which are not in feed
            $this->deleteProducts($productSku);
        }
        $output->writeln('Import finished. Elapsed time: ' . round(microtime(true) - $time, 2) . 's' . "\n");
    }

    /**
     * @return array
     */
    abstract protected function getEntities();

    public function getAllSku($productData)
    {
        return array_column($productData, 'sku');
    }

    public function deleteProducts($productSku)
    {
        $productCollection = $this->__objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $collections = $productCollection->create()->addStoreFilter(1)->addAttributeToSelect('id')->load();

        // $productSkuAM = ['28201','27099','27113','27134','27194'];
        //$productSku = array_merge($productSku, $productSkuAM);

        foreach ($collections as $product) {
            if (!in_array($product->getSku(), $productSku)) {
                try {
                    $product->delete();
                    echo 'Deleted :' . $product->getID() . PHP_EOL;
                } catch (Exception $e) {
                    echo 'Failed to remove product : ' . $product->getId() . " " . $e->getMessage() . " " . PHP_EOL;
                }
            }
        }
    }

    public function addUpdateDeleteProduct($productData)
    {
        $sku = $productData['sku'];
        $notAllowUpdate = ['919012'];

        if (!empty($sku) && !in_array($sku, $notAllowUpdate)) {
            $oldProduct = $this->getProductBySku($sku);

            if (!empty($oldProduct)) { // Update product

                $oldProductId = $oldProduct->getId();
                $oldProductSku = $oldProduct->getSku();

                $_product = $this->__objectManager->create('Magento\Catalog\Model\Product')->load($oldProductId);

                if (!empty($_product)) {
                    if (strtolower($productData['action']) == 'v') { // Delete product

                        try {
                            $_product->delete();
                            echo 'Deleted Product: ' . $sku;
                        } catch (Exception $e) {
                            echo 'Failed to remove product ' . $sku . ", Error: " . $e->getMessage();
                        }
                    } else { // Update products

                        try {
                            $_product->setWebsiteIds([1]);
                            $_product->setStoreId(0);

                            $_product->setName($productData['name']); // Name of Product
                            // $_product->setDescription($productData['description']);
                            $_product->setShortDescription($productData['short_description']);
                            $_product->setPrice($productData['price']); // price of product
//                            $_product->save();
//                            $_product->setStockData(
//                                array(
//                                    'is_in_stock' => 1,
//                                    'qty' => 30
//                                )
//                            );

                            $_product->save();

                            foreach ($productData['attributes'] as $key => $attribute) {
                                $attr = $_product->getResource()->getAttribute($key);
                                if (!empty($attr)) {
                                    $attributeOptionId = $attr->getSource()->getOptionId($attribute); //name in Default Store View
                                    if (!empty($attributeOptionId)) {
                                        $_product->setData($key, $attributeOptionId);
                                    } else {
                                        $_product->setData($key, $attribute);
                                    }
                                } else {
                                    $_product->setData($key, $attribute);
                                }
                            }
                            $_product->setData('mp_exclude_sitemap', 0);
                            $_product->save();

                            /**  Documents sections */
                            $documents = $this->copyDocuments($productData['documents']);
                            if (!empty($documents)) {
                                $_product->setData('download_link', implode(",", $documents));
                            } else {
                                $_product->setData('download_link', '');
                            }
                            $_product->save();
                            /**  Image section */

                            $existingMediaGalleryEntries = $_product->getMediaGalleryEntries();
                            foreach ($existingMediaGalleryEntries as $key => $entry) {
                                unset($existingMediaGalleryEntries[$key]);
                            }
                            $_product->setMediaGalleryEntries($existingMediaGalleryEntries);
                            $this->_productRepositoryInterface->save($_product);

                            $_product->save();

                            $tmpDir = $this->getMediaDirTmpDir();

                            $image = $productData['image'];
                            $baseImage = $this->clean(baseName($image));
                            $imagePath = $tmpDir . $baseImage;

                            if ($this->file->read($image, $imagePath)) {
                                $_product->addImageToMediaGallery($imagePath, ['image', 'small_image', 'thumbnail'], false, false);
                                $_product->save();
                                @unlink($imagePath);
                            }

                            $_product->save();

                            $galleryData = explode(",", $productData['additional_images']);
                            array_shift($galleryData);

                            if (!empty($galleryData)) {
                                $imagesRemoved = [];

                                foreach ($galleryData as $image) {
                                    $baseImage = $this->clean(baseName($image));
                                    $newFileName = $tmpDir . $baseImage;

                                    if ($this->file->read($image, $newFileName)) {
                                        try {
                                            $_product->addImageToMediaGallery($newFileName, [], false, false);
                                            // $_product->save();
                                            $imagesRemoved[] = $newFileName;
                                        } catch (Exception $e) {
                                            echo $e->getMessage();
                                        }
                                    }
                                }

                                $_product->save();

                                $title = $_product->getName();
                                $existingMediaGalleryEntries = $_product->getMediaGalleryEntries();
                                if (count($existingMediaGalleryEntries) > 0) {
                                    foreach ($existingMediaGalleryEntries as $key => $entry) {
                                        $entry->setLabel($title);
                                    }
                                    $_product->setMediaGalleryEntries($existingMediaGalleryEntries)->save();
                                }

                                foreach ($imagesRemoved as $image) {
                                    @unlink($image);
                                }
                            }

                            $_product->save();

                            /*
                           * Manage Product Categories at last step
                           * */

                            $category_ids = $this->getProductCatIds($productData['categories']);
                            if (!empty($category_ids)) {
                                $_product->setCategoryIds($category_ids);
                                $categoryLinkManagementInterface = $this->__objectManager->get('\Magento\Catalog\Api\CategoryLinkManagementInterface');
                                $categoryLinkManagementInterface->assignProductToCategories($oldProductSku, $category_ids);
                            }

                            echo "Updated Product:  " . $_product->getId();
                        } catch (Exception $e) {
                            echo 'Failed to Update product ' . $sku . ", Error: " . $e->getMessage();
                        }
                    }
                }
            } else { // Create Product

                if (strtolower($productData['action']) != 'v') { // Not Allow to add deleted product

                    try {
                        $newProduct = $this->__objectManager->create('\Magento\Catalog\Model\Product');
                        $newProduct->setSku($productData['sku']); // Set your sku here
                        $newProduct->setName($productData['name']); // Name of Product
                        $newProduct->setUrlKey($this->createUrlKey($productData['name'], $productData['sku']));
                        // $newProduct->setDescription($productData['description']);
                        $newProduct->setShortDescription($productData['short_description']);
                        $newProduct->setAttributeSetId(4); // Attribute set id // 4= Default
                        $newProduct->setStatus(1); // Status on product enabled/ disabled 1/0
                        $newProduct->setWeight(1); // weight of product
                        $newProduct->setWebsiteIds([1]);
                        $newProduct->setStoreId(0);
                        $newProduct->setVisibility(4); // visibilty of product (catalog / search / catalog, search / Not visible individually)
                        $newProduct->setTaxClassId(2); // Tax class id 2=Taxable Goods, 0=None
                        $newProduct->setTypeId('simple'); // type of product (simple/virtual/downloadable/configurable)
                        $newProduct->setPrice($productData['price']); // price of product
                        $newProduct->setStockData(
                            [
                                'is_in_stock' => 1,
                                'qty' => 30
                            ]
                        );

                        foreach ($productData['attributes'] as $key => $attribute) {
                            $attr = $newProduct->getResource()->getAttribute($key);
                            if (!empty($attr)) {
                                $attributeOptionId = $attr->getSource()->getOptionId($attribute); //name in Default Store View
                                if (!empty($attributeOptionId)) {
                                    $newProduct->setData($key, $attributeOptionId);
                                } else {
                                    $newProduct->setData($key, $attribute);
                                }
                            } else {
                                $newProduct->setData($key, $attribute);
                            }
                        }

                        $category_ids = $this->getProductCatIds($productData['categories']);
                        if (!empty($category_ids)) {
                            $newProduct->setCategoryIds($category_ids);
                        }

                        /**  Documents sections */
                        $documents = $this->copyDocuments($productData['documents']);
                        if (!empty($documents)) {
                            $newProduct->setData('download_link', implode(",", $documents));
                        } else {
                            $newProduct->setData('download_link', '');
                        }

                        $tmpDir = $this->getMediaDirTmpDir();

                        $image = $productData['image'];
                        $baseImage = $this->clean(baseName($image));
                        $imagePath = $tmpDir . $baseImage;

                        if ($this->file->read($image, $imagePath)) {
                            $newProduct->addImageToMediaGallery($imagePath, ['image', 'small_image', 'thumbnail'], false, false);
                            $newProduct->save();
                            @unlink($imagePath);
                        }

                        $newProduct->save();

                        $galleryData = explode(",", $productData['additional_images']);
                        array_shift($galleryData);

                        if (!empty($galleryData)) {
                            $imagesRemoved = [];

                            foreach ($galleryData as $image) {
                                $baseImage = $this->clean(baseName($image));
                                $newFileName = $tmpDir . $baseImage;

                                if ($this->file->read($image, $newFileName)) {
                                    try {
                                        $newProduct->addImageToMediaGallery($newFileName, [], false, false);
                                        $imagesRemoved[] = $newFileName;
                                    } catch (Exception $e) {
                                        echo $e->getMessage();
                                    }
                                }
                            }

                            $newProduct->save();

                            $title = $newProduct->getName();
                            $existingMediaGalleryEntries = $newProduct->getMediaGalleryEntries();
                            if (count($existingMediaGalleryEntries) > 0) {
                                foreach ($existingMediaGalleryEntries as $key => $entry) {
                                    $entry->setLabel($title);
                                }
                                $newProduct->setMediaGalleryEntries($existingMediaGalleryEntries)->save();
                            }

                            foreach ($imagesRemoved as $image) {
                                @unlink($image);
                            }
                        }

                        echo "Added Product:  " . $newProduct->getId();
                    } catch (Exception $e) {
                        echo 'Failed to Add product ' . $productData['sku'] . ", Error: " . $e->getMessage();
                    }
                }
            }
        }
    }

    public function getProductBySku($sku)
    {
        try {
            $product = $this->_productRepository->get($sku);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $product = false;
        }
        return $product;
    }

    public function copyDocuments($documents)
    {
        $data = [];
        if (!empty($documents)) {
            $tmpDir = $this->getDownloadDir();
            foreach ($documents as $document) {
                $name = str_replace("#", "", urldecode(baseName($document)));
                $newFileName = $tmpDir . $name;
                if ($this->file->read($document, $newFileName)) {
                    $data[] = $name;
                }
            }
        }
        return $data;
    }

    protected function getDownloadDir()
    {
        return $this->directoryList->getPath(DirectoryList::MEDIA) . DIRECTORY_SEPARATOR . 'wysiwyg' . DIRECTORY_SEPARATOR . 'download' . DIRECTORY_SEPARATOR;
    }

    protected function getMediaDirTmpDir()
    {
        return $this->directoryList->getPath(DirectoryList::MEDIA) . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR;
    }

    public function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return strtolower(preg_replace('/[^A-Za-z0-9\-.]/', '', $string)); // Removes special chars.
    }

    public function getProductCatIds($categories)
    {
        $catIds = [];
        $categories = explode("/", $categories);
        foreach ($categories as $key => $category) {
            $level = $key + 1;
            if ($level !== 1) {
                $catIds[] = $this->getCategoryId($category, $level);
            }
        }

        return $catIds;
    }

    public function createUrlKey($title, $sku)
    {
        $url = preg_replace('#[^0-9a-z]+#i', '-', $title);
        $lastCharTitle = substr($title, -1);
        $lastUrlChar = substr($url, -1);
        if ($lastUrlChar == "-" && $lastCharTitle != "-") {
            $url = substr($url, 0, strlen($url) - 1);
        }

        $urlKey = strtolower($url);
        $storeId = 1;//(int)$this->_storeManager->getStore()->getStoreId();

        $isUnique = $this->checkUrlKeyDuplicates($sku, $urlKey, $storeId);
        if ($isUnique) {
            return $urlKey;
        } else {
            return $urlKey . '-' . $sku;
        }
    }

    private function checkUrlKeyDuplicates($sku, $urlKey, $storeId)
    {
        $urlKey .= '.html';

        $connection = $this->_resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);

        $tablename = $connection->getTableName('url_rewrite');
        $sql = $connection->select()->from(
            ['url_rewrite' => $connection->getTableName('url_rewrite')],
            ['request_path', 'store_id']
        )->joinLeft(
            ['cpe' => $connection->getTableName('catalog_product_entity')],
            "cpe.entity_id = url_rewrite.entity_id"
        )->where('request_path IN (?)', $urlKey)
            ->where('store_id IN (?)', $storeId)
            ->where('cpe.sku not in (?)', $sku);

        $urlKeyDuplicates = $connection->fetchAssoc($sql);

        if (!empty($urlKeyDuplicates)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return null|int null or 0 if everything went fine, or an error code
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function old_execute(InputInterface $input, OutputInterface $output)
    {
        $omParams = $_SERVER;
        $omParams[StoreManager::PARAM_RUN_CODE] = 'admin';
        $omParams[Store::CUSTOM_ENTRY_POINT_PARAM] = true;
        $this->objectManager = $this->objectManagerFactory->create($omParams);

        $area = FrontNameResolver::AREA_CODE;

        /** @var \Magento\Framework\App\State $appState */
        $appState = $this->objectManager->get('Magento\Framework\App\State');
        $appState->setAreaCode($area);
        $configLoader = $this->configLoaderInterface;
        $this->objectManager->configure($configLoader->load($area));

        $productsArray = $this->getEntities();

        if (!empty($productsArray)) {
            $output->writeln('Import started');

            $time = microtime(true);

            $importerModel = $this->importer;

            $importerModel->setBehavior($this->getBehavior());
            $importerModel->setEntityCode($this->getEntityCode());
            $adapterFactory = $this->nestedArrayAdapterFactory;
            $importerModel->setImportAdapterFactory($adapterFactory);

            try {
                $importerModel->processImport($productsArray);

                /*
                 *  Upload images
                 * */

                $this->addProductImages($productsArray);
            } catch (\Exception $e) {
                $output->writeln($e->getMessage());
            }

            $output->write($importerModel->getLogTrace());
            $output->write($importerModel->getErrorMessages());

            $output->writeln('Import finished. Elapsed time: ' . round(microtime(true) - $time, 2) . 's' . "\n");
            $this->afterFinishImport();
        } else {
            $output->writeln('Nothing to Import');
        }
    }

    /**
     * @return string
     */
    public function getBehavior()
    {
        return $this->behavior;
    }

    /**
     * @param string $behavior
     */
    public function setBehavior($behavior)
    {
        $this->behavior = $behavior;
    }

    /**
     * @return string
     */
    public function getEntityCode()
    {
        return $this->entityCode;
    }

    /**
     * @param string $entityCode
     */
    public function setEntityCode($entityCode)
    {
        $this->entityCode = $entityCode;
    }

    public function addProductImages($productsData)
    {
        foreach ($productsData as $productData) {
            $sku = $productData['sku'];

            $product = $this->getProductBySku($sku);

            if (!empty($product)) {
                $_product = $this->objectManager->create('Magento\Catalog\Model\Product')->load($product->getId());

                $galleryData = explode(",", $productData['additional_images']);

                /** @var string $tmpDir */
                $tmpDir = $this->getMediaDirTmpDir();

                /** create folder if it is not exists */
                $this->file->checkAndCreateFolder($tmpDir);

                if (!empty($_product)) {
                    foreach ($galleryData as $image) {
                        $newFileName = $tmpDir . baseName($image);

                        /** read file from URL and copy it to the new destination */
                        $result = $this->file->read($image, $newFileName);
                        if ($result) {
                            try {
                                $_product->addImageToMediaGallery($newFileName, [], false, false);
                                $_product->save();

                                $title = $_product->getName();
                                $existingMediaGalleryEntries = $_product->getMediaGalleryEntries();
                                if (count($existingMediaGalleryEntries) > 0) {
                                    foreach ($existingMediaGalleryEntries as $key => $entry) {
                                        $entry->setLabel($title);
                                    }
                                    $_product->setMediaGalleryEntries($existingMediaGalleryEntries)->save();
                                }
                            } catch (Exception $e) {
                                echo $e->getMessage();
                            }
                        }
                    }
                }
            }
        }
    }

    /*
 * Function to check URL Key Duplicates in Database
 */

    public function afterFinishImport()
    {
    }
}
