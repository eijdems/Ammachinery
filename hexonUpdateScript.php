<?php

use Magento\Framework\App\Bootstrap;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\UrlInterface;

require __DIR__ . '/app/bootstrap.php';

$bootstrap                  = Bootstrap::create(BP, $_SERVER);
$objectManager              = $bootstrap->getObjectManager();
$sku            = "00 2657 475 1-OEM";
$productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
$product = $productRepository->get($sku);
$syncProduct 				= $product["sync_product_on_hexon"];
$categoryCode               = $product['code_hexon_subgroep'];
$baseUrl 					= "https://www.ammachinery.nl/";
$generalCategory = "";
if ($categoryCode == "7397") {
	$generalCategory = "machine";
}
if ($categoryCode == "7398") {
	$generalCategory = "attachment";
}
getHexonProduct($product,$generalCategory);    


function hexonSyncProduct($product,$generalCategory) {
			$sku 							= $product->getSku();
		    $productUrl 					= $product->getProductUrl();
		    $fileName 						= $product->getImage();
		    $description 					= $product->getShortDescription();
		    $year_of_manufacture_t 			= $product['year_of_manufacture_t'];
		    $title 							= $product['name'];
		    $engineHours 					= $product['counter1'];
		    $price 							= $product['price'];
		    $engine_brand_t 				= $product['engine_brand_t'];
		    $engine_power_hp 				= $product['engine_power_hp'];
		    $maximum_speed 					= $product['maximum_speed'];
		    $warranty_package 				= $product['warranty_package'];
		    if ($warranty_package == 7391) {
		    	$warranty_package = "AM Premium Warranty package";
		    }elseif ($warranty_package == 7392) {
		    	$warranty_package = "AM Exclusive Warranty package";
		    }else{
		    	$warranty_package = "No Warranty";
		    }
			$data 			= array(
		        "stocknumber" => $sku,
		        "identification" => array(
		            "direct_link" => $productUrl
		        ),
		        "general" => array(
		            "category" => $generalCategory,
		            "bodystyle" => "Agricultural machine"
		        ),
				"description"=> array(
				   	"remarks"=> [
				      array(
				        "language"=> "en_GB",
				        "translation"=> $description
				      )
				    ],
				    "title"=> [
				      array(
				        "language"=> "en_GB",
				        "translation"=> $title
				      )
				    ]
				),
			  	"condition"=> array(
			    	"operating_hours"=> $engineHours
			  	),
			  	"sales_conditions"=> array(
				    "pricing"=> array(
				      "advertising_preference"=> "regular_price_only",
				      "type"=> "asking_price",
				      "new"=> [
				        array(
				          "nr"=> 1,
				          "amount"=> $price,
				          "decimals"=> 0,
				          "currency"=> "EUR",
				          "incl_vat"=> true,
				          "vat_pct"=> 21,
				          "incl_dutch_bpm"=> true
				        )
				      ]
				    ),
				    "warranty"=>array(
				    	'dealer' => array(
				    		"label"=>$warranty_package
				    	)
				    )
			  	),
			  	"powertrain" =>array(
			  		"engine" => array(
			  			"make"=> $engine_brand_t,
		      			"model"=> $engine_power_hp
			  		),
			  		"topspeed" => $maximum_speed
			  	)
		    );
		    $headers = array(
		        'Content-Type: application/json',
		        'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		    );

		    $url = 'https://api.hexon.nl/spi/api/v4/rest/vehicles/';

		    $curl = curl_init();
		    curl_setopt_array($curl, array(
		        CURLOPT_URL => $url,
		        CURLOPT_RETURNTRANSFER => true,
		        CURLOPT_ENCODING => '',
		        CURLOPT_MAXREDIRS => 10,
		        CURLOPT_TIMEOUT => 0,
		        CURLOPT_FOLLOWLOCATION => true,
		        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		        CURLOPT_CUSTOMREQUEST => 'POST',
		        CURLOPT_POSTFIELDS => json_encode($data),
		        CURLOPT_HTTPHEADER => $headers,
		    ));

		    try {
		        $response = curl_exec($curl);
		        echo $response;
		        if ($response === false) {
		            throw new Exception(curl_error($curl), curl_errno($curl));
		        }
		        echo "Synced Product in Hexon SKU = ".$sku."\n";
		    } catch (Exception $e) {
		        echo 'Caught exception: ' . $e->getMessage();
		    } finally {
		        curl_close($curl);
		    }
}



function getHexonProduct($product , $generalCategory) {


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicles/?stocknumber=00%202657%20475%201-OEM',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
var_dump($response);


die();

die("ZSdfd");

			//echo count($product);die;
			$sku 	= $product->getSku();
			//var_dump($sku);die;
			
			$curl 	= curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicle/'.$sku,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'GET',
			  CURLOPT_HTTPHEADER => array(
			    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
			  ),
			));

			$response = curl_exec($curl);
			echo $response;die;
			$responseArray = json_decode($response, true);
			//var_dump($responseArray);die;
			if ($responseArray !== null) {
			    // Check if "stocknumber" exists in the result
			    if (isset($responseArray['result']['stocknumber'])) {
			        $stocknumber = $responseArray['result']['stocknumber'];
			        //$this->hexonProductUpdate($product,$generalCategory);
			    } else {
			    	$this->hexonSyncProduct($product,$generalCategory);
			    }
			} 
			curl_close($curl);
		}