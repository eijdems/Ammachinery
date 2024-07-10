<?php

namespace Nadeem0035\ImportData\Console\Command\Product;

use Nadeem0035\ImportData\Console\Command\AbstractImportCommand;
use Magento\Framework\App\ObjectManagerFactory;
use Magento\ImportExport\Model\Import;
use Magento\Catalog\Api\ProductAttributeOptionManagementInterface;
use Nadeem0035\ImportData\Helper\Config;

class ImportProduct extends AbstractImportCommand
{
    /**
     * @var ProductAttributeOptionManagementInterface
     */
    private $attributeOptionManagementInterface;

    public function importSimpleProduct()
    {
        $data = [];
        for ($i = 1; $i <= 2; $i++) {
            $data[] = array(
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
            );
        }
        return $data;
    }

    public function getApiDataLimit()
    {
        $username = $this->getImportUserName();
        $password = $this->getImportPassword();

        $ch = curl_init();
        $params = array('limit' => 1);
        $url = $this->getImportUrl() . '?' . http_build_query($params);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
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
        } else if ($info['http_code'] != 200) {
            $this->writeLog('Curl Error 2:' . $err);
        } else {
            $productsData = json_decode($result);
            return (int)$productsData->TotalItems;
        }
    }

    protected function configure()
    {
        $this->setName('importdata:products:importproduct')
            ->setDescription('Import Products ');

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

    public function getCorrectCategory($catName) {

        if(!empty($catName)) {

            if ($catName == 'Harvesters') {
                $name = 'Self Propelled Forage Harvesters';
            } elseif ($catName == 'Headers') {
                $name = 'Headers';
            } elseif ($catName == 'Loaders') {
                $name = 'Wheeled Loaders';
            } elseif ($catName == 'Tractors') {
                $name = 'Tractors';
            } elseif ($catName == 'Telehandlers') {
                $name = 'Telehandlers';
            } elseif ($catName == 'Other Machinery (Misc.)') {
                $name = 'Miscellaneous';
            } else {
                $name = 'Miscellaneous';
            }

            return $name;
        }
    }

    public function readData($page = 1, $offset = 0)
    {   
        
        $limit = 100;
        $username = $this->getImportUserName();
        $password = $this->getImportPassword();

        $ch = curl_init();
        $params = array('Offset' => $offset, 'limit' => $limit);
        $url = $this->getImportUrl() . '?' . http_build_query($params);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
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
        } else if ($info['http_code'] != 200) {
            $this->writeLog('Curl Error 4:' . $err);
        } else {


            $productsData = json_decode($result);
            $products = $productsData->Result;

            if (!empty($products)) {

                foreach ($products as $product) {

                    $defaultAttributes = $additionalAttributes = [];

                    if ($product->ServiceNumber > 0) {


                        /*
                         * Import category
                         * */
                          $categoryName = $this->getCorrectCategory(@$product->MainGroup);
                         //$this->createCategories($categoryName); Categories already created


                        $default_data = array(
                            'sku' => strval($product->ServiceNumber),
                            'action' => @$product->SalesStatusCode,
                            'attribute_set_code' => 'Default',
                            'product_type' => 'simple',
                            'product_websites' => 'base',
                            'qty' => 25,
                            'visibility' => 'Catalog, Search',
                            'tax_class_name' => 'Taxable Goods',
                            'product_online' => '1',
                            'weight' => '1.0000',
                            'name' => $product->MakeName . " " . $product->Type,
                            'short_description' => $product->WebsiteText,
                            'description' => '',
                            'price' => ($product->AdvicePrice ?: 0.00),
                            'additional_images' => implode(",", $product->Images),
                            'image' => @$product->Images[0],
                            'documents' => $product->Documents

                        );

                        if (!empty($categoryName)) {
                            $default_data['categories'] = "Default Category/" . $categoryName;
                        }


                        $defaultAttributes['type'] = $product->Type;
                        if ($product->Counter1 > 0) {
                            $defaultAttributes['counter1'] = $product->Counter1;
                        } else {
                            $defaultAttributes['counter1'] = '';
                        }

                        if ($product->Counter2 > 0) {
                            $defaultAttributes['counter2'] = $product->Counter2;
                        } else {
                            $defaultAttributes['counter2'] = '';
                        }

                        $defaultAttributes['build_year'] = $product->BuildYear;
                        $defaultAttributes['manufacturer'] = $product->MakeName;
                        $defaultAttributes['condition'] = ($product->Condition == "New" ? "Yes" : "No");


                        $additionalAttributes = $this->getAdditionalAttributes($product->Properties);

                        $attributes = array_merge($defaultAttributes, $additionalAttributes);

                        $default_data['attributes'] = $attributes;

                        $data[] = $default_data;
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
        $attributeArray = array(
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

        );

        foreach ($attributes as $attribute) {

            if (isset($attributeArray[$attribute->Code]) && $attribute->Value != 'Not Applicable' && trim($attribute->Value) !== '0' && $attribute->Value != 'NA') {

                if ($attribute->Code == 'H200' && $attribute->Value == 'Stock') { //  Stock Status
                    $attributesData['is_in_stock'] = 1;
                } elseif ($attribute->Code == 'H205') { //  Stock Status
                    if($attribute->Value == 'New') {
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
        $products [] = array(
            'sku' => "SIMPLE-BLUE-SMALL",
            'attribute_set_code' => 'Default',
            'product_type' => 'simple',
            'product_websites' => 'base',
            'name' => 'FireGento Simple Product Blue,Size Small',
            'price' => '1.0000',
            'color' => 'blue',
            'size' => 'S'
        );
        $products [] = array(
            'sku' => "SIMPLE-RED-MIDDLE",
            'attribute_set_code' => 'Default',
            'product_type' => 'simple',
            'product_websites' => 'base',
            'name' => 'FireGento Simple Product Red,Size Middle',
            'price' => '1.0000',
            'color' => 'red',
            'size' => 'M'
        );

        $products [] = array(
            'sku' => 'CONFIG-Product',
            'attribute_set_code' => 'Default',
            'product_type' => 'configurable',
            'product_websites' => 'base',
            'name' => 'FireGento Test Product Configurable',
            'price' => '10.000',
            'configurable_variation_labels' => 'Color',
            'configurable_variations' => array(
                array(
                    'sku' => 'SIMPLE-BLUE-SMALL',
                    'color' => 'blue',
                    'size' => 'S'),
                array(
                    'sku' => 'SIMPLE-RED-MIDDLE',
                    'color' => 'red',
                    'size' => 'M'),
            )

        );


        return $products;

    }

    protected function importBundleProduct()
    {
        $simpleProducts = [];
        $bundleProduct = array(
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


        );

        $colors = array("blue", "black");
        $bundleValues = '';
        for ($i = 0; $i < 2; $i++) {

            $color = $colors[$i];
            $sku = 'SIMPLE-' . $color;
            $simpleProducts[] = array(
                'sku' => $sku,
                'attribute_set_code' => 'Default',
                'product_type' => 'simple',
                'product_websites' => 'base',
                'name' => 'FireGento Test Product Simple - ' . $color,
                'price' => '14.0000',
                'additional_attributes' => "color=" . $color

            );
            $bundleAttributes = array(
                "name" => "Color",
                "type" => 'radio',
                'required' => '1',
                'sku' => $sku,
                'price' => '14.0000',
                'default' => $i,
                'default_qty' => '1.0000',
                'price_type' => 'fixed'
            );


            $bundleValues .= $this->arrayToAttributeString($bundleAttributes) . "|";

        }
        $bundleProduct["bundle_values"] = $bundleValues;
        $data = array_merge($simpleProducts, array($bundleProduct));
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