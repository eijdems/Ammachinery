<?php

namespace Nadeem0035\ImportData\Console\Command\Product;

use Magento\Catalog\Api\ProductAttributeOptionManagementInterface;
use Magento\ImportExport\Model\Import;
use Nadeem0035\ImportData\Console\Command\AbstractImportCommandAmSpareParts;

class ImportProductAmSpareParts extends AbstractImportCommandAmSpareParts
{
    /**
     * @var ProductAttributeOptionManagementInterface
     */
    private $attributeOptionManagementInterface;
    public function importSimpleProduct()
    {
        $data = [];
        for ($i = 1; $i <= 2; $i++) {
            $data[] = [
                'sku' => 'FIREGENTO-' . $i,
                'attribute_set_code' => 'Default',
                'product_type' => 'simple',
                'product_websites' => 'base',
                'name' => 'FireGento Test Product ' . $i,
                'price' => '14.0000',
                'qty' => 25,
                'is_in_stock' => 1,
                'manufacturer' => "John Deere",
                'build_year' => "2015",
                'maximum_lifting_height' => "25",
                'visibility' => 'Catalog, Search',
                'tax_class_name' => 'Taxable Goods',
                'product_online' => '1',
                'weight' => '1.0000',
                'short_description' => 'Testing',
                'description' => 'Testing Testing Testing',
            ];
        }
        return $data;
    }

    public function getApiDataLimit()
    {
        $username = $this->getImportUserName();
        $password = $this->getImportPassword();

        $ch = curl_init();
        $params = ['limit' => 1];
        $url = $this->getImportUrl() . '?' . http_build_query($params);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = [];
        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Basic ' . base64_encode("$username:$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);

        // Check for errors and such.
        $err = curl_error($ch);
        $info = curl_getinfo($ch);
        $errno = curl_errno($ch);
        curl_close($ch);

        if ($result === false || $errno != 0) {
            $this->writeLog('Curl Error 1:' . $err);
        } elseif ($info['http_code'] != 200) {
            $this->writeLog('Curl Error 2:' . $err);
        } else {
            $productsData = json_decode($result);
            return (int)$productsData->TotalItems;
        }
    }

    protected function configure()
    {
        $this->setName('importdata:products:importproductamspare')
            ->setDescription('Import Products Spare Parts');

        $this->setBehavior(Import::BEHAVIOR_ADD_UPDATE);
        $this->setEntityCode('catalog_product');

        parent::configure();
    }

    /**
     * @return array
     */
    protected function getEntities()
    {
        return $this->readData();
    }

    public function getCorrectCategory($catName)
    {
        $catName = strtolower($catName);
        if (!empty($catName)) {
            if ($catName == 'harvesters') {
                // $name = 'Self Propelled Forage Harvesters';
                $name = 'Forage Harvesters';
            } elseif ($catName == 'headers') {
                $name = 'Harvester attachments';
            } elseif ($catName == 'loaders') {
                $name = 'Wheeled Loaders';
            } elseif ($catName == 'tractors') {
                $name = 'Tractors';
            } elseif ($catName == 'telehandlers') {
                $name = 'Telehandlers';
            } elseif ($catName == 'other machinery (misc.)') {
                $name = 'Miscellaneous';
            } elseif ($catName == 'rotary corn header') {
                $name = 'Rotary Corn Headers';
            } elseif ($catName == "grass pick-up") {
                $name = 'Grass Pick-ups';
            } elseif ($catName == 'chain corn headers' ) {
                $name = 'Chain Corn Headers';
            } elseif ($catName == "kuilmachines") {
                $name = 'Silage Equipment';
            }else {
                $name = 'Miscellaneous';
            }

            return $name;
        }
    }

    public function readData($page = 1, $offset = 0)
    {
        $limit = 10000;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $username = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue("ImportData/spareparts/import_username_spare");
        $password = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue("ImportData/spareparts/import_password_spare");
        $urlImport = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue("ImportData/spareparts/import_url_spare");
        
        
        //$urlImport = "https://webshop.powerall.io/api/v1/products/all";
        //$username = "am-machinery";
        //$password = "462c0f38-c0fb-4ec5-b18f-9badc2d00359";

        $ch = curl_init();
        $params = ['Offset' => $offset, 'limit' => $limit];
        /*$url = $this->getImportUrl() . '?' . http_build_query($params);*/
        $url = $urlImport . '?' . http_build_query($params);
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = [];
        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Basic ' . base64_encode("$username:$password");

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);


        // Check for errors and such.

        $err = curl_error($ch);
        $info = curl_getinfo($ch);
        $errno = curl_errno($ch);
        curl_close($ch);

        if ($result === false || $errno != 0) {
            $this->writeLog('Curl Error 3:' . $err);
        } elseif ($info['http_code'] != 200) {
            $this->writeLog('Curl Error 4:' . $err);
        } 
        else 
        {   

            $products = json_decode($result);
            if (!empty($products)) 
            {   
                foreach ($products as $product) 
                {
                    $sku                    =$product->ProductCode;
                    $mainCategory           =$product->MainGroup;
                    $subcategory            =$product->SubGroup;
                    $eanCode                =$product->EanCode;
                    $productTitle           =$product->Description;
                    $productDescription     =$product->WebshopText;
                    $categoryStructure      =$product->WebshopSearchText;
                    $brand                  =$product->MakeDescription;
                    $hideOnWebshop          =$product->HideOnWebshop;
                    $length                 =$product->SelectionCode1;
                    $width                  =$product->SelectionCode2;
                    $height                 =$product->SelectionCode3;
                    $weight                 =$product->Weight;
                    $salesPrice             =$product->SalesPrice;
                    $replacedProductCodes   =$product->ReplacedProductCodes;
                    //$imageUrls              =$product->ImageUrls;
                    $catStructure = [];
                    if (!empty($mainCategory) && !empty($subcategory) && !empty($categoryStructure) && !empty($brand) ){
                        $catStructure = explode(";",$categoryStructure);
                    }
                    $categoryName = '';

                    if ($product->ProductCode) 
                    {
                        if ($mainCategory == "001") {
                            $categoryName = "Forage Harvesters";
                        }
                        if($mainCategory == "002"){
                            $categoryName = "Headers";
                        }
                        if($mainCategory == "003"){
                            $categoryName = "Pickups";
                        } 
                        if ( !empty($categoryName) && !empty($brand) ) 
                        {
                            $categoryNameBrand = $categoryName."/".$brand;
                            $cat="";
                            foreach ($catStructure as $catStructure1 ) {
                                $thirdLevelcat = str_replace('"','', $catStructure1);
                                if (!empty($thirdLevelcat) ) {
                                    if($subcategory == "001" && $categoryName == "Forage Harvesters"){
                                        $cat = $categoryNameBrand."/".$thirdLevelcat."/Feed rolls";
                                    }elseif($subcategory == "001" && $categoryName == "Headers"){
                                        $cat = $categoryNameBrand."/".$thirdLevelcat."/Feeding";
                                    }elseif ($subcategory == "002") {
                                        $cat = $categoryNameBrand."/".$thirdLevelcat."/Cutterhead";
                                    }elseif ($subcategory == "003") {
                                        $cat = $categoryNameBrand."/".$thirdLevelcat."/Grass chute";
                                    }elseif ($subcategory == "004") {
                                        $cat = $categoryNameBrand."/".$thirdLevelcat."/Kernel Processor";
                                    }elseif ($subcategory == "005") {
                                        $cat = $categoryNameBrand."/".$thirdLevelcat."/Blower";
                                    }elseif ($subcategory == "006") {
                                        $cat = $categoryNameBrand."/".$thirdLevelcat."/Transition";
                                    }elseif ($subcategory == "007") {
                                        $cat = $categoryNameBrand."/".$thirdLevelcat."/Spout";
                                    }elseif ($subcategory == "008") {
                                        $cat = $categoryNameBrand."/".$thirdLevelcat."/Drive belt's";
                                    }else{
                                        $cat = $categoryNameBrand."/".$thirdLevelcat;
                                    } 
                                }
                                $default_data = [
                                    'sku'                   => strval($product->ProductCode),
                                    'product_type'          => 'simple',
                                    'product_websites'      => 'base',
                                    'qty'                   => 25,
                                    'visibility'            => 'Catalog, Search',
                                    'tax_class_name'        => 'Taxable Goods',
                                    'product_online'        => '1',
                                    'weight'                => $product->Weight,
                                    'name'                  => $productTitle,
                                    'description'           => $productDescription,
                                    'height'                => $height,
                                    'image'                 => @$product->ImageUrls[0],
                                    'width'                 => $width,
                                    'length'                => $length,
                                    'hideOnWebshop'         => $hideOnWebshop,
                                    'action'                => '',
                                    'brand'                 => $brand,
                                    'eanCode'               => $eanCode,
                                    'replacedProductCodes'  => $replacedProductCodes,
                                    'salesPrice'            => $salesPrice
                                ];
                                if($product->ImageUrls){
                                    $default_data['additional_images'] = implode(",", $product->ImageUrls);
                                }
                                $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/customAmSpareParts.log');
                                $logger = new \Zend_Log();
                                $logger->addWriter($writer);
                                $logger->info('======================Spare Parts Data ==============');
                                $logger->info(print_r($default_data, true));
                                if (!empty($cat)) {
                                    $default_data['categories'] = "AM Category/Spare parts/".$cat;
                                }
                                $data[] = $default_data;
                            }
                        } 
                        else 
                        {
                            $default_data = [
                                'sku'                   => strval($product->ProductCode),
                                'product_type'          => 'simple',
                                'product_websites'      => 'base',
                                'qty'                   => 25,
                                'visibility'            => 'Catalog, Search',
                                'tax_class_name'        => 'Taxable Goods',
                                'product_online'        => '1',
                                'weight'                => $product->Weight,
                                'name'                  => $productTitle,
                                'description'           => $productDescription,
                                'height'                => $height,
                                'image'                 => @$product->ImageUrls[0],
                                'width'                 => $width,
                                'length'                => $length,
                                'hideOnWebshop'         => $hideOnWebshop,
                                'action'                => '',
                                'brand'                 => $brand,
                                'eanCode'               => $eanCode,
                                'replacedProductCodes'  => $replacedProductCodes,
                                'salesPrice'            => $salesPrice
                                
                            ];

                            if($product->ImageUrls){
                                $default_data['additional_images'] = implode(",", $product->ImageUrls);
                            }
                            if($categoryName){
                                $default_data['categories'] = "AM Category/Spare parts/".$categoryName;
                            }

                            $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/customAmSpareParts.log');
                            $logger = new \Zend_Log();
                            $logger->addWriter($writer);
                            $logger->info('======================Spare Parts Data ==============');
                            $logger->info(print_r($default_data, true));
                            $data[] = $default_data;
                        } 
                    }
                }
                if (count($products) >= $limit) {
                    $data = array_merge($data, $this->readData($page + 1, $page * $limit));
                }
            }
            return $data;
        }
    }

    private function getAdditionalAttributes($attributes)
    {
        $attributesData = $extraMissing = [];
        $attributeArray = [
            'H200' => 'is_in_stock',
            'H203' => 'general_condition',
            'H214' => 'video',
            'H160' => 'power_hp',
            'H161' => 'power_kw',
            'H433' => 'axis_configuration',
            'H219' => 'brand_tyres',
            'H220' => 'front_tyres_size',
            'H221' => 'back_tyres_size',
            'H222' => 'profile_front_tyres',
            'H223' => 'profile_rear_tyres',
            'H226' => 'maximum_speed',
            'H390' => 'power_additional_hydraulics',
            'H392' => 'mast_type',
            'H380' => 'maximum_lifting_height',
            'H227' => 'option_adblue',
            'H228' => 'option_4wd',
            'H231' => 'option_air_conditioning',
            'H383' => 'option_manure_bin',
            'H384' => 'option_soin_container',
            'H385' => 'option_pallet_forks',
            'H395' => 'option_quick_change_block',
            'H399' => 'option_quick_fasteners',
            'H401' => 'option_forks',
            'H402' => 'option_digger_bucket',
            'H404' => 'optie_safe_load_indicator',
            'H410' => 'option_comfort_drive_control',

            'H239' => 'gearbox_tractor',
            'H240' => 'pto_shaft_speed',
            'H241' => 'point_hitch',
            'H235' => 'double_acting_control_valves',
            'H516' => 'type_brakes',
            'H225' => 'option_caterpillars',
            'H229' => 'option_board_computer',
            'H244' => 'option_pneumatic_system',
            'H246' => 'option_front_weights',
            'H247' => 'option_front_linkage',
            'H248' => 'option_frontloader',
            'H249' => 'option_frontloader_attachments',
            'H250' => 'option_front_pto',
            'H251' => 'option_frared_front_axle',
            'H254' => 'option_cabin_suspension',
            'H255' => 'option_creep_speed',
            'H266' => 'option_gps',
            'H269' => 'option_left_hand_reverse',
            'H202' => 'ce_marked',
            'H314' => 'loading_capacity_m3',
            'H352' => 'transport_weight',
            'H368' => 'lifting_capacity',
            'H377' => 'counter_weight',
            'H407' => 'bucket_m3',
            'H408' => 'steering_loader',
            'H409' => 'chassis',
            'H391' => 'tiltable_quick_release',
            'H394' => 'hydraulic_attachm',
            'H397' => 'extra_hydraulic_system',
            'H413' => 'control_stick',
            'H296' => 'number_rows',
            'H297' => 'pickup_working_width',
            'H303' => 'grass_pickup',
            'H305' => 'mais_header',
            'H298' => 'automatic_headstock',
            'H299' => 'option_steering',
            'H300' => 'elektronic_adj',
            'H301' => 'automatic_grinding_device',
            'H335' => 'gps_cutting_unit',
            'H307' => 'central_lubrication',
            'H308' => 'extra_weights',
            'H334' => 'combine_head',
            'H336' => 'corn_picker',
            'H338' => 'automatic_steering',
            'H344' => 'chain_header',
            'H345' => 'independent_corn_header',
            'H347' => 'hydraulic_fold_up',
            'H348' => 'mechanic_fold_up',
            'O018' => 'sales_label_usa',
            'H205' => 'new'

        ];

        foreach ($attributes as $attribute) {
            if (isset($attributeArray[$attribute->Code]) && $attribute->Value != 'Not Applicable' && trim($attribute->Value) !== '0' && $attribute->Value != 'NA') {
                if ($attribute->Code == 'H200' && $attribute->Value == 'Stock') { //  Stock Status
                    $attributesData['is_in_stock'] = 1;
                } elseif ($attribute->Code == 'H205') { //  Stock Status
                    if ($attribute->Value == 'New') {
                        $attributesData['new'] = 'Yes';
                    } else {
                        $attributesData['new'] = 'No';
                    }
                } else {
                    $attributesData[$attributeArray[$attribute->Code]] = $attribute->Value;
                }
            } elseif (!array_key_exists($attribute->Code, $attributeArray)) {
                $extraMissing[$attribute->Code] = $attribute->Description; // For
            }
        }
        $attributesData['extra'] = $extraMissing;

        return $attributesData;
    }

    protected function importConfigurableProduct()
    {
        $products = [];
        $products [] = [
            'sku' => "SIMPLE-BLUE-SMALL",
            'attribute_set_code' => 'Default',
            'product_type' => 'simple',
            'product_websites' => 'base',
            'name' => 'FireGento Simple Product Blue,Size Small',
            'price' => '1.0000',
            'color' => 'blue',
            'size' => 'S'
        ];
        $products [] = [
            'sku' => "SIMPLE-RED-MIDDLE",
            'attribute_set_code' => 'Default',
            'product_type' => 'simple',
            'product_websites' => 'base',
            'name' => 'FireGento Simple Product Red,Size Middle',
            'price' => '1.0000',
            'color' => 'red',
            'size' => 'M'
        ];

        $products [] = [
            'sku' => 'CONFIG-Product',
            'attribute_set_code' => 'Default',
            'product_type' => 'configurable',
            'product_websites' => 'base',
            'name' => 'FireGento Test Product Configurable',
            'price' => '10.000',
            'configurable_variation_labels' => 'Color',
            'configurable_variations' => [
                [
                    'sku' => 'SIMPLE-BLUE-SMALL',
                    'color' => 'blue',
                    'size' => 'S'],
                [
                    'sku' => 'SIMPLE-RED-MIDDLE',
                    'color' => 'red',
                    'size' => 'M'],
            ]

        ];

        return $products;
    }

    protected function importBundleProduct()
    {
        $simpleProducts = [];
        $bundleProduct = [
            'sku' => 'Bundle-Product',
            'attribute_set_code' => 'Default',
            'product_type' => 'bundle',
            'product_websites' => 'base',
            'name' => 'FireGento Test Product Bundle',
            'price' => '10.000',

            'bundle_price_type' => 'dynamic',
            'bundle_sku_type' => 'dynamic',
            'bundle_price_view' => 'Price range',
            'bundle_weight_type' => 'dynamic',

        ];

        $colors = ["blue", "black"];
        $bundleValues = '';
        for ($i = 0; $i < 2; $i++) {
            $color = $colors[$i];
            $sku = 'SIMPLE-' . $color;
            $simpleProducts[] = [
                'sku' => $sku,
                'attribute_set_code' => 'Default',
                'product_type' => 'simple',
                'product_websites' => 'base',
                'name' => 'FireGento Test Product Simple - ' . $color,
                'price' => '14.0000',
                'additional_attributes' => "color=" . $color

            ];
            $bundleAttributes = [
                "name" => "Color",
                "type" => 'radio',
                'required' => '1',
                'sku' => $sku,
                'price' => '14.0000',
                'default' => $i,
                'default_qty' => '1.0000',
                'price_type' => 'fixed'
            ];

            $bundleValues .= $this->arrayToAttributeString($bundleAttributes) . "|";
        }
        $bundleProduct["bundle_values"] = $bundleValues;
        $data = array_merge($simpleProducts, [$bundleProduct]);
        return $data;
    }

    private function globalWebsiteCheck($data)
    {
        foreach ($data as $ds) {
            foreach ($ds as $key => $d) {
                if ($key == 'Code' && $d == 'AGM') { // AGM | BOO
                    return true;
                }
            }
        }
        return false;
    }

    private function productPremiumCheck($data)
    {
        foreach ($data as $ds) {
            foreach ($ds as $key => $d) {
                if ($key == 'ValueCode' && $d == 'PREMI') {
                    return 'Yes';
                }
            }
        }
        return 'No';
    }

    private function productSalesLabel($data)
    {
        foreach ($data as $ds) {
            foreach ($ds as $key => $d) {
                if ($key == 'Value' && !empty($d)) {
                    return $d;
                }
            }
        }
        return '';
    }
}
