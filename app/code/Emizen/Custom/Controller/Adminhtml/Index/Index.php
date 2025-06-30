<?php
namespace Emizen\Custom\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Filesystem\DirectoryList;

class Index extends Action
{
    protected $resultPageFactory;
    protected $productCollectionFactory;
    protected $fileFactory;
    protected $directoryList;

    public function __construct(
        Context $context,
        ProductCollectionFactory $productCollectionFactory,
        FileFactory $fileFactory,
        DirectoryList $directoryList,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->fileFactory = $fileFactory;
        $this->directoryList = $directoryList;
    }

    public function execute()
    {
        $rootDir = $this->directoryList->getRoot();
        // Load product collection with limit of 10 and specific attributes
        $collection = $this->productCollectionFactory->create();
        $collection->setStoreId(0);
        //$collection->addStoreFilter(0);  
        $collection->addAttributeToSelect([
            'sku',
            'status',
            'sync_product_on_hexon',
            'code_hexon_hoofdgroep',
            'code_hexon_subgroep',
            'advertentietekst_hexon',
            'counter1',
            'engine_power_hp',
            'power_kw',
            'maximum_speed',
            'front_tyres_brand_t',
            'front_tyres_size',
            'back_tyres_size',
            'front_tires_profile',
            'rear_tires_profile',
            'amount_of_rows_hcorn',
            'working_width_hpu',
            'amount_of_knives_installed_t',
            'option_grass_pickup',
            'option_mais_header',
            'attr_2_or_4_wheel_drive_t',
            'airconditioning_cold_t',
            'emission_level_t',
            'gps_t',
            'auto_lubrication_t',
            'rear_weights_t',
            'kernel_processor_rolls_t',
            'Xenon_lights_t',
            'moisture_mapping_t',
            'dumpkit_t',
            'rear_hydraulics_t',
            'amount_of_rows_header',
            'cutting_knives_hcorn',
            'autosteer_sensor_t',
            'advertisement_platform',
            'bodystyle',
            'year_of_manufacture_t'
        ]);

        // Prepare CSV data
        $csvData = [];
        $header = [
             'sku','status','sync_product_on_hexon', 'code_hexon_hoofdgroep', 'code_hexon_subgroep', 'advertentietekst_hexon',
            'counter1', 'engine_power_hp', 'power_kw', 'maximum_speed', 'front_tyres_brand_t',
            'front_tyres_size', 'back_tyres_size', 'front_tires_profile', 'rear_tires_profile',
            'amount_of_rows_hcorn', 'working_width_hpu', 'amount_of_knives_installed_t', 'option_grass_pickup',
            'option_mais_header', 'attr_2_or_4_wheel_drive_t', 'airconditioning_cold_t', 'emission_level_t',
            'gps_t', 'auto_lubrication_t', 'rear_weights_t', 'kernel_processor_rolls_t', 'Xenon_lights_t',
            'moisture_mapping_t', 'dumpkit_t', 'rear_hydraulics_t', 'amount_of_rows_header',
            'cutting_knives_hcorn', 'autosteer_sensor_t', 'advertisement_platform', 'bodystyle','year_of_manufacture_t'
        ];
        $csvData[] = $header;

        foreach ($collection as $product) {
            $codeHexonHoofdgroep = '';
            $syncProductOnHexon = '';
            $codeHexonSubgroep = '';
            $counter1 = '';
            $maximumSpeed = '';
            $frontTyresSize = '';
            $backTyresSize = '';
            $frontTiresProfile = '';
            $rearTiresProfile = '';
            $amountOfRowsHcorn = '';
            $advertisementPlatform = '';
            $enginePowerHp = '';
            $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();        
            if ($product->getData('sync_product_on_hexon')) {
                 $syncProductOnHexon = $product->getResource()->getAttribute('sync_product_on_hexon')->getSource()->getOptionText($product->getData('sync_product_on_hexon'));
            }
           
            if ($product->getData('code_hexon_hoofdgroep')) {
                 $codeHexonHoofdgroep = $product->getResource()->getAttribute('code_hexon_hoofdgroep')->getSource()->getOptionText($product->getData('code_hexon_hoofdgroep'));
            }
            if ($product->getData('code_hexon_subgroep')) {
                 $codeHexonSubgroep = $product->getResource()->getAttribute('code_hexon_subgroep')->getSource()->getOptionText($product->getData('code_hexon_subgroep'));
            }
            if ($product->getData('counter1')) {
                 $counter1 = $product->getResource()->getAttribute('counter1')->getSource()->getOptionText($product->getData('counter1'));
            }
            if ($product->getData('engine_power_hp')) {
                 $enginePowerHp = $product->getResource()->getAttribute('engine_power_hp')->getSource()->getOptionText($product->getData('engine_power_hp'));
            }
            if ($product->getData('maximum_speed')) {
                 $maximumSpeed = $product->getResource()->getAttribute('maximum_speed')->getSource()->getOptionText($product->getData('maximum_speed'));
            }
            if ($product->getData('front_tyres_size')) {
                 $frontTyresSize = $product->getResource()->getAttribute('front_tyres_size')->getSource()->getOptionText($product->getData('front_tyres_size'));
            }
            if ($product->getData('back_tyres_size')) {
                 $backTyresSize = $product->getResource()->getAttribute('back_tyres_size')->getSource()->getOptionText($product->getData('back_tyres_size'));
            }
            if ($product->getData('front_tires_profile')) {
                 $frontTiresProfile = $product->getResource()->getAttribute('front_tires_profile')->getSource()->getOptionText($product->getData('front_tires_profile'));
            }
            if ($product->getData('rear_tires_profile')) {
                 $rearTiresProfile = $product->getResource()->getAttribute('rear_tires_profile')->getSource()->getOptionText($product->getData('rear_tires_profile'));
            }
            if ($product->getData('amount_of_rows_hcorn')) {
                 $amountOfRowsHcorn = $product->getResource()->getAttribute('amount_of_rows_hcorn')->getSource()->getOptionText($product->getData('amount_of_rows_hcorn'));
            }

            if ($product->getData('advertisement_platform')) {
                
                // Split the attribute value if it's a comma-separated string
                $optionIds = explode(',', $product->getData('advertisement_platform'));

                // Initialize an array to hold the option texts
                $optionTexts = [];

                // Loop through each option ID to get the corresponding label
                foreach ($optionIds as $optionId) {
                    $optionText = $product->getResource()->getAttribute('advertisement_platform')
                                              ->getSource()
                                              ->getOptionText(trim($optionId)); // Trim to remove whitespace
                    if ($optionText) {
                        $optionTexts[] = $optionText; // Store the text if it's found
                    }
                }

                    // Output the results
                    $advertisementPlatform = implode(', ', $optionTexts);
            }
            
            //$advertisement_platform = $product->getResource()->getAttribute('advertisement_platform')->getSource()->getOptionText($product->getData('advertisement_platform'));
            $csvData[] = [
                $product->getData('sku'),
                $product->getData('status'),
                $syncProductOnHexon,
                $codeHexonHoofdgroep,
                $codeHexonSubgroep,
                $product->getData('advertentietekst_hexon'),
                $counter1,
                $enginePowerHp,
                $product->getData('power_kw'),
                $maximumSpeed,
                $product->getData('front_tyres_brand_t'),
                $frontTyresSize,
                $backTyresSize,
                $frontTiresProfile,
                $rearTiresProfile,
                $amountOfRowsHcorn,
                $product->getData('working_width_hpu'),
                $product->getData('amount_of_knives_installed_t'),
                $product->getData('option_grass_pickup'),
                $product->getData('option_mais_header'),
                $product->getData('attr_2_or_4_wheel_drive_t'),
                $product->getData('airconditioning_cold_t'),
                $product->getData('emission_level_t'),
                $product->getData('gps_t'),
                $product->getData('auto_lubrication_t'),
                $product->getData('rear_weights_t'),
                $product->getData('kernel_processor_rolls_t'),
                $product->getData('Xenon_lights_t'),
                $product->getData('moisture_mapping_t'),
                $product->getData('dumpkit_t'),
                $product->getData('rear_hydraulics_t'),
                $product->getData('amount_of_rows_header'),
                $product->getData('cutting_knives_hcorn'),
                $product->getData('autosteer_sensor_t'),
                $advertisementPlatform,
                $product->getData('bodystyle'),
                $product->getData('year_of_manufacture_t')
                
            ];
        }
        //var_dump($csvData);die;
        // Create CSV file
        $fileName = 'products.csv';
        $filePath = $rootDir.'/var/exportscsv/' . $fileName;
        $this->createCsvFile($filePath, $csvData);

        // Return CSV file for download
        return $this->fileFactory->create(
            $fileName,
            [
                'type' => 'filename',
                'value' => $filePath,
                'rm' => true  // Remove file after download
            ],
            \Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR,
            'text/csv'
        );
    }

    protected function createCsvFile($filePath, $csvData)
    {
        $fileHandle = fopen($filePath, 'w');
        foreach ($csvData as $data) {
            fputcsv($fileHandle, $data);
        }
        fclose($fileHandle);
    }
    
}
