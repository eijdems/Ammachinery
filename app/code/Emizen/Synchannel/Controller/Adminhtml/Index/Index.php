<?php
namespace Emizen\Synchannel\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{   
    protected $resultFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\ResultFactory $resultFactory
    ) {
        $this->resultFactory = $resultFactory;
        parent::__construct($context);
    }

    public function execute()
    {       
        $objectManager             	= $this->_objectManager;
        $productId                 	= $this->getRequest()->getParam('id');
        $product                   	= $objectManager->create('Magento\Catalog\Model\Product')->load($productId);
        $syncProduct 				= $product["sync_product_on_hexon"];
        $sku                       	= $product->getSku();
        //var_dump($sku);
        $categoryCode               = $product['code_hexon_subgroep'];
        $baseUrl 					= "https://www.ammachinery.nl/";
        $generalCategory = "";
        if ($categoryCode == "7397") {
        	$generalCategory = "attachment";
        }
        if ($categoryCode == "7398") {
        	$generalCategory = "machine";
        }


        $front_tyres_size			=$product["front_tyres_size"];
        $back_tyres_size			=$product["back_tyres_size"];
		$front_tires_profile		=$product["front_tires_profile"];
		$rear_tires_profile			=$product["rear_tires_profile"];
		$attr_2_or_4_wheel_drive_t	=$product["attr_2_or_4_wheel_drive_t"];
		$amount_knives_installed	=$product["amount_knives_installed"];
		$counter2					=$product["counter2"];
		$airconditioning_cold_t		=$product["airconditioning_cold_t"];
		$emission_level_t			=$product["emission_level_t"];
		$gps_t						=$product["gps_t"];
		$auto_lubrication_t			=$product["auto_lubrication_t"];
		$kernel_processor_rolls_t	=$product["kernel_processor_rolls_t"];
		$Xenon_lights_t				=$product["Xenon_lights_t"];
		$moisture_mapping_t			=$product["moisture_mapping_t"];
		$dumpkit_t					=$product["dumpkit_t"];
		$rear_hydraulics_t			=$product["rear_hydraulics_t"];
		$autosteer_sensor_t			=$product["autosteer_sensor_t"];
		$innoculant_system_t		=$product["innoculant_system_t"];
		$autocontour_t				=$product["autocontour_t"];
		$speedstar_t				=$product["speedstar_t"];
		$tire_pressure_system_t		=$product["tire_pressure_system_t"];
		$rockstopper_t				=$product["rockstopper_t"];
		$amount_of_rows_hcorn		=$product["amount_of_rows_hcorn"];
		$cutting_knives_hcorn		=$product["cutting_knives_hcorn"];
		if ($front_tyres_size) {
			$labelAttr = $product->getResource()->getAttribute('front_tyres_size')->getFrontendLabel();
			$this->updateCustomAttribute1($front_tyres_size, $sku, $labelAttr);
		}
		if ($back_tyres_size) {
			$labelAttr = $product->getResource()->getAttribute('back_tyres_size')->getFrontendLabel();
			$this->updateCustomAttribute2($back_tyres_size, $sku, $labelAttr);
		}
		if ($front_tires_profile) {
			$labelAttr = $product->getResource()->getAttribute('front_tires_profile')->getFrontendLabel();
			$this->updateCustomAttribute3($front_tires_profile, $sku, $labelAttr);
		}
		if ($rear_tires_profile) {
			$labelAttr = $product->getResource()->getAttribute('rear_tires_profile')->getFrontendLabel();
			$this->updateCustomAttribute4($rear_tires_profile, $sku, $labelAttr);
		}
		if ($attr_2_or_4_wheel_drive_t) {
			$labelAttr = $product->getResource()->getAttribute('attr_2_or_4_wheel_drive_t')->getFrontendLabel();
			$this->updateCustomAttribute5($attr_2_or_4_wheel_drive_t, $sku, $labelAttr);
		}
		if ($amount_knives_installed) {
			$labelAttr = $product->getResource()->getAttribute('amount_knives_installed')->getFrontendLabel();
			$this->updateCustomAttribute6($amount_knives_installed, $sku, $labelAttr);
		}
		if ($counter2) {
			$labelAttr = $product->getResource()->getAttribute('counter2')->getFrontendLabel();
			$this->updateCustomAttribute7($counter2, $sku, $labelAttr);
		}
		if ($airconditioning_cold_t) {
			$labelAttr = $product->getResource()->getAttribute('airconditioning_cold_t')->getFrontendLabel();
			$this->updateCustomAttribute8($airconditioning_cold_t, $sku, $labelAttr);
		}
		if ($emission_level_t) {
			$labelAttr = $product->getResource()->getAttribute('emission_level_t')->getFrontendLabel();
			$this->updateCustomAttribute9($emission_level_t, $sku, $labelAttr);
		}
		if ($gps_t) {
			$labelAttr = $product->getResource()->getAttribute('gps_t')->getFrontendLabel();
			$this->updateCustomAttribute10($gps_t, $sku, $labelAttr);
		}
		if ($auto_lubrication_t) {
			$labelAttr = $product->getResource()->getAttribute('auto_lubrication_t')->getFrontendLabel();
			$this->updateCustomAttribute11($auto_lubrication_t, $sku, $labelAttr);
		}
		if ($kernel_processor_rolls_t) {
			$labelAttr = $product->getResource()->getAttribute('kernel_processor_rolls_t')->getFrontendLabel();
			$this->updateCustomAttribute12($kernel_processor_rolls_t, $sku, $labelAttr);
		}
		if ($Xenon_lights_t) {
			$labelAttr = $product->getResource()->getAttribute('Xenon_lights_t')->getFrontendLabel();
			$this->updateCustomAttribute13($Xenon_lights_t, $sku, $labelAttr);
		}
		if ($moisture_mapping_t) {
			$labelAttr = $product->getResource()->getAttribute('moisture_mapping_t')->getFrontendLabel();
			$this->updateCustomAttribute14($moisture_mapping_t, $sku, $labelAttr);
		}
		if ($dumpkit_t) {
			$labelAttr = $product->getResource()->getAttribute('dumpkit_t')->getFrontendLabel();
			$this->updateCustomAttribute15($dumpkit_t, $sku, $labelAttr);
		}
		if ($rear_hydraulics_t) {
			$labelAttr = $product->getResource()->getAttribute('rear_hydraulics_t')->getFrontendLabel();
			$this->updateCustomAttribute16($rear_hydraulics_t, $sku, $labelAttr);
		}
		if ($autosteer_sensor_t) {
			$labelAttr = $product->getResource()->getAttribute('autosteer_sensor_t')->getFrontendLabel();
			$this->updateCustomAttribute17($autosteer_sensor_t, $sku, $labelAttr);
		}
		if ($innoculant_system_t) {
			$labelAttr = $product->getResource()->getAttribute('innoculant_system_t')->getFrontendLabel();
			$this->updateCustomAttribute18($innoculant_system_t, $sku, $labelAttr);
		}
		if ($autocontour_t) {
			$labelAttr = $product->getResource()->getAttribute('autocontour_t')->getFrontendLabel();
			$this->updateCustomAttribute19($autocontour_t, $sku, $labelAttr);
		}
		if ($speedstar_t) {
			$labelAttr = $product->getResource()->getAttribute('speedstar_t')->getFrontendLabel();
			$this->updateCustomAttribute20($speedstar_t, $sku, $labelAttr);
		}
		
		if ($autosteer_sensor_t) {
			$labelAttr = $product->getResource()->getAttribute('autosteer_sensor_t')->getFrontendLabel();
			$this->updateCustomAttribute21($tire_pressure_system_t, $sku, $labelAttr);
		}
		if ($rockstopper_t) {
			$labelAttr = $product->getResource()->getAttribute('rockstopper_t')->getFrontendLabel();
			$this->updateCustomAttribute22($rockstopper_t, $sku, $labelAttr);
		}
		if ($amount_of_rows_hcorn) {
			$labelAttr = $product->getResource()->getAttribute('amount_of_rows_hcorn')->getFrontendLabel();
			$this->updateCustomAttribute23($amount_of_rows_hcorn, $sku, $labelAttr);
		}
		if ($cutting_knives_hcorn) {
			$labelAttr = $product->getResource()->getAttribute('cutting_knives_hcorn')->getFrontendLabel();
			$this->updateCustomAttribute24($cutting_knives_hcorn, $sku, $labelAttr);
		}	
        	//var_dump($syncProduct);die;
        if ($syncProduct) {
        	
        	$this->getHexonProduct($product , $generalCategory);
	        $advertisement_platform    	= $product['advertisement_platform'];
	        $advert_array              	= explode(",", $advertisement_platform);
	        $platformFound             	= false;
	        $platformMapping           	= [
	            "7435"                  => "agritrader",
	            "7436"                  => "autoline",
	            "7437"                  => "europemachinery",
	            "7438"                  => "mascus",
	            "7439"                  => "machinetrack",
	            "7440"                  => "traktorpoolnl",
	            "7441"                  => "truck1st",
	            "7442"                  => "trekkerweb"
	        ];

	        foreach ($platformMapping as $code => $platform) {
	            $this->getPlateform($platform, $product, $sku);
	        }

	        foreach ($platformMapping as $code => $platform) {
	            if (in_array($code, $advert_array)) {
	                $this->hexonUpdatePlateform($platform, $product, $sku);
	                $platformFound = true;
	            }
	        }
	        $this->messageManager->addSuccessMessage(__('Product Synced successfully.'));
	        if ($platformFound) {
	            $this->messageManager->addSuccessMessage(__('Platforms updated successfully.'));
	        } else {
	            $this->messageManager->addNoticeMessage(__('No platforms found for update.'));
	        }

	        /** @var Redirect $resultRedirect */
	        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
	        $resultRedirect->setUrl($this->_redirect->getRefererUrl()); // Redirect to the previous page
	        return $resultRedirect;
        } else{
        	$this->messageManager->addNoticeMessage(__('Sync product on Hexon  is not active for this product !'));
        	$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
	        $resultRedirect->setUrl($this->_redirect->getRefererUrl()); // Redirect to the previous page
	        return $resultRedirect;
        }       
    }
	public function updateCustomAttribute1($front_tyres_size, $sku, $labelAttr)
	{	
		/*$labelAttr = $productData->getResource()->getAttribute('front_tyres_size')->getFrontendLabel();
		$sku 						=$productData->getSku();*/
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 1,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $front_tyres_size
		        )
		    ),
		    "code"=>$front_tyres_size
		);
		
		//print_r(json_encode($postData));die;
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':1',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;die;
	}

	public function updateCustomAttribute2($back_tyres_size, $sku, $labelAttr)
	{   
		//$labelAttr = $productData->getResource()->getAttribute('back_tyres_size')->getFrontendLabel();
	    //$sku                        =$productData->getSku();
	    $curl = curl_init();
	    $postData = array(
	        "stocknumber" => $sku,
	        "nr" => 2,
	        "name" => array(
	            array(
	                "language" => "en_GB",
	                "translation" => $labelAttr
	            )
	        ),
	        "description" => array(
	            array(
	                "language" => "en_GB",
	                "translation" => $back_tyres_size
	            )
	        ),
		    "code"=>$back_tyres_size
	    );

	    curl_setopt_array($curl, array(
	      CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':1',
	      CURLOPT_RETURNTRANSFER => true,
	      CURLOPT_ENCODING => '',
	      CURLOPT_MAXREDIRS => 10,
	      CURLOPT_TIMEOUT => 0,
	      CURLOPT_FOLLOWLOCATION => true,
	      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	      CURLOPT_CUSTOMREQUEST => 'PUT',
	      CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
	      CURLOPT_HTTPHEADER => array(
	        'Content-Type: application/json',
	        'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
	      ),
	    ));

	    $response = curl_exec($curl);

	    curl_close($curl);
	}
	public function updateCustomAttribute3($front_tires_profile, $sku, $labelAttr)
	{   
		//$labelAttr = $productData->getResource()->getAttribute('front_tires_profile')->getFrontendLabel();
	    //$sku                        =$productData->getSku();
	    $curl = curl_init();
	    $postData = array(
	        "stocknumber" => $sku,
	        "nr" => 3,
	        "name" => array(
	            array(
	                "language" => "en_GB",
	                "translation" => $labelAttr
	            )
	        ),
	        "description" => array(
	            array(
	                "language" => "en_GB",
	                "translation" => $front_tires_profile
	            )
	        ),
		    "code"=>$front_tires_profile
	    );

	    curl_setopt_array($curl, array(
	      CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':3',
	      CURLOPT_RETURNTRANSFER => true,
	      CURLOPT_ENCODING => '',
	      CURLOPT_MAXREDIRS => 10,
	      CURLOPT_TIMEOUT => 0,
	      CURLOPT_FOLLOWLOCATION => true,
	      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	      CURLOPT_CUSTOMREQUEST => 'PUT',
	      CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
	      CURLOPT_HTTPHEADER => array(
	        'Content-Type: application/json',
	        'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
	      ),
	    ));

	    $response = curl_exec($curl);

	    curl_close($curl);
	}
	public function updateCustomAttribute4($rear_tires_profile, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('rear_tires_profile')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 4,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $rear_tires_profile
		        )
		    ),
		    "code"=>$rear_tires_profile
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':4',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

	}
	public function updateCustomAttribute5($attr_2_or_4_wheel_drive_t, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('attr_2_or_4_wheel_drive_t')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 5,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $attr_2_or_4_wheel_drive_t
		        )
		    ),
		    "code"=>$attr_2_or_4_wheel_drive_t
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':5',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

	}
	public function updateCustomAttribute6($amount_knives_installed, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('amount_knives_installed')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 6,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $amount_knives_installed
		        )
		    ),
		    "code"=>$amount_knives_installed
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':6',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
	}
	public function updateCustomAttribute7($counter2, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('counter2')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 7,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $counter2
		        )
		    ),
		    "code"=>$counter2
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':7',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
	}
	public function updateCustomAttribute8($airconditioning_cold_t, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('airconditioning_cold_t')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 8,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $airconditioning_cold_t
		        )
		    ),
		    "code"=>$airconditioning_cold_t
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':8',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
	}
	public function updateCustomAttribute9($emission_level_t, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('emission_level_t')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 9,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $emission_level_t
		        )
		    ),
		    "code"=>$emission_level_t
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':9',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
	}
	public function updateCustomAttribute10($gps_t, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('gps_t')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 10,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $gps_t
		        )
		    ),
		    "code"=>$gps_t
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':10',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
	}
	public function updateCustomAttribute11($auto_lubrication_t, $sku, $labelAttr)
	{	//var_dump($auto_lubrication_t);die;
		//$labelAttr = $productData->getResource()->getAttribute('auto_lubrication_t')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 11,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $auto_lubrication_t
		        )
		    ),
		    "code"=>$auto_lubrication_t
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':11',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
	}
	public function updateCustomAttribute12($kernel_processor_rolls_t, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('kernel_processor_rolls_t')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 12,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $kernel_processor_rolls_t
		        )
		    ),
		    "code"=>$kernel_processor_rolls_t
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':12',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
	}
	public function updateCustomAttribute13($Xenon_lights_t, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('Xenon_lights_t')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 13,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $Xenon_lights_t
		        )
		    ),
		    "code"=>$Xenon_lights_t
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':13',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		///echo $response;
	}
	public function updateCustomAttribute14($moisture_mapping_t, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('moisture_mapping_t')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 14,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $moisture_mapping_t
		        )
		    ),
		    "code"=>$moisture_mapping_t
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':14',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
	}
	public function updateCustomAttribute15($dumpkit_t, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('dumpkit_t')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 15,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $dumpkit_t
		        )
		    ),
		    "code"=>$dumpkit_t
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':15',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
	}
	public function updateCustomAttribute16($rear_hydraulics_t, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('rear_hydraulics_t')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 16,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $rear_hydraulics_t
		        )
		    ),
		    "code"=>$rear_hydraulics_t
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':16',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
	}
	public function updateCustomAttribute17($autosteer_sensor_t, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('autosteer_sensor_t')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 17,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $autosteer_sensor_t
		        )
		    ),
		    "code"=>$autosteer_sensor_t
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':17',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
	}
	public function updateCustomAttribute18($innoculant_system_t, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('innoculant_system_t')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 18,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $innoculant_system_t
		        )
		    ),
		    "code"=>$innoculant_system_t
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':18',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
	}
	public function updateCustomAttribute19($autocontour_t, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('autocontour_t')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 19,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $autocontour_t
		        )
		    ),
		    "code"=>$autocontour_t
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':19',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
	}
	public function updateCustomAttribute20($speedstar_t, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('speedstar_t')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 20,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $speedstar_t
		        )
		    ),
		    "code"=>$speedstar_t
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':20',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
	}
	public function updateCustomAttribute21($tire_pressure_system_t, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('tire_pressure_system_t')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 21,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $tire_pressure_system_t
		        )
		    ),
		    "code"=>$tire_pressure_system_t
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':21',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
	}
	public function updateCustomAttribute22($rockstopper_t, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('rockstopper_t')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 22,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $rockstopper_t
		        )
		    ),
		    "code"=>$rockstopper_t
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':22',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
	}
	public function updateCustomAttribute23($amount_of_rows_hcorn, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('amount_of_rows_hcorn')->getFrontendLabel();

		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 23,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $amount_of_rows_hcorn
		        )
		    ),
		    "code"=>$amount_of_rows_hcorn
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':23',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
	}
	public function updateCustomAttribute24($cutting_knives_hcorn, $sku, $labelAttr)
	{	
		//$labelAttr = $productData->getResource()->getAttribute('cutting_knives_hcorn')->getFrontendLabel();
		//$sku 						=$productData->getSku();
		$curl = curl_init();
		$postData = array(
		    "stocknumber" => $sku,
		    "nr" => 24,
		    "name" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $labelAttr
		        )
		    ),
		    "description" => array(
		        array(
		            "language" => "en_GB",
		            "translation" => $cutting_knives_hcorn
		        )
		    ),
		    "code"=>$cutting_knives_hcorn
		);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleaccessory/'.urlencode($sku).':24',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		//echo $response;
	}
	    public function getHexonProduct($product , $generalCategory) {
			//echo count($product);die;
			$sku 	= $product->getSku();
			//var_dump($sku);die;
			$curl 	= curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicle/?stocknumber='.urlencode($sku),
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
			
			$responseArray = json_decode($response, true);
			//var_dump($responseArray);die;
			if ($responseArray !== null) {
			    // Check if "stocknumber" exists in the result
			    if (isset($responseArray['result']['stocknumber'])) {

			        $stocknumber = $responseArray['result']['stocknumber'];
			        //echo $stocknumber;die;
			        $this->hexonProductUpdate($product,$generalCategory);
			    } else {

			    	$this->hexonSyncProduct($product,$generalCategory);
			    }
			}else{
				$this->hexonSyncProduct($product,$generalCategory);
			} 
			curl_close($curl);
		}
		public function imageUploadSync($product) {
		 	global $baseUrl;
		    $objectManager 	= \Magento\Framework\App\ObjectManager::getInstance();
		    $sku 			= $product->getSku();
		    $prod_id 		= $product->getEntityId();
		    $productUrl 	= $product->getProductUrl();
		    $description 	= $product->getShortDescription();
		    $productData 	= $objectManager->create('Magento\Catalog\Model\Product')->load($prod_id);        
		    $images 		= $productData->getMediaGalleryImages();
		    
		    if (!empty($images)) {
		        $index = 0;
		        foreach ($images as $child) {
		        	$index++;
		            $imageUrl =  $child->getUrl();
		    		$fileName =  $child['file']; 
		            $url = 'https://api.hexon.nl/spi/api/v4/rest/vehicleimages/';
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
		                CURLOPT_POSTFIELDS => json_encode(array(
		                    "stocknumber" =>$sku,
		                    "nr" => $index, // Assuming image number starts from 1
		                    "image_url" => $imageUrl,
		                    "filename" => $fileName,
		                    "category" => "exterior",
		                    "description" => $description // Assuming same description for all images
		                )),
		                CURLOPT_HTTPHEADER => array(
		                    'Content-Type: application/json',
		                    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		                ),
		            ));
		            $response = curl_exec($curl);
		            
		            $responseArray = json_decode($response, true);
					if ($responseArray !== null) {
						if (isset($responseArray['result']['stocknumber'])) {
					        $stocknumber = $responseArray['result']['stocknumber'];
					        //hexonProductUpdate($product,$generalCategory);
					    } else {
					    	 $this->imageUpdateHexon($product,$index,$imageUrl,$fileName);
					    }
					} 

		            //echo $response;
		            //echo  $imageUrl."\n";
		            //echo  ($index + 1)."\n";
		            
		            curl_close($curl);
		        }
		    } else {
		        echo " imageUpdateHexon No gallery images found for product with SKU: $sku\n";
		    }
		}
		public function imageUpdateHexon($product, $index, $imageUrl, $fileName) {
		    global $baseUrl;
		    $sku = $product->getSku();
		    $productUrl = $product->getProductUrl();
		    $description = $product->getShortDescription();
		    $url = 'https://api.hexon.nl/spi/api/v4/rest/vehicleimage/' . $sku . ':' . $index;

		    // Define payload data as an associative array
		    $payloadData = array(
		        "nr" => $index,
		        "stocknumber" => $sku,
		        "image_url" => $imageUrl,
		        "filename" => $fileName,
		        "category" => "exterior",
		        "description" => $description
		    );

		    // Encode payload data to JSON
		    $payload = json_encode($payloadData);

		    // Initialize cURL session
		    $curl = curl_init();

		    // Set cURL options
		    curl_setopt_array($curl, array(
		        CURLOPT_URL => $url,
		        CURLOPT_RETURNTRANSFER => true,
		        CURLOPT_ENCODING => '',
		        CURLOPT_MAXREDIRS => 10,
		        CURLOPT_TIMEOUT => 0,
		        CURLOPT_FOLLOWLOCATION => true,
		        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		        CURLOPT_CUSTOMREQUEST => 'PUT',
		        CURLOPT_POSTFIELDS => $payload, // Set the JSON payload
		        CURLOPT_HTTPHEADER => array(
		            'Content-Type: application/json',
		            'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		        ),
		    ));

		    // Execute cURL request and capture response
		    $response = curl_exec($curl);

		    //echo $response;
		    curl_close($curl);
		}
		public function hexonProductUpdate($product,$generalCategory) {
			$sku 				= $product->getSku();
		    $productUrl 		= $product->getProductUrl();
		    $fileName 			= $product->getImage();
		    $description 		= $product->getShortDescription();
		    $brand 				= $product['brand'];
		    $year_of_manufacture_t = $product['year_of_manufacture_t'];
		    $title 				= $product['name'];
		    $engineHours 		= $product['counter1'];
		    $price 				= $product['price'];
		    $engine_brand_t 	= $product['engine_brand_t'];
		    $engine_power_hp 	= $product['engine_power_hp'];
		    $maximum_speed 		= $product['maximum_speed'];
		    $warranty_package 	= $product['warranty_package'];
		    $bodystyle 			= $product->getResource()->getAttribute("bodystyle")->getFrontend()->getValue($product);
		    
		    if ($warranty_package == 7391) {
		    	$warranty_package = "AM Premium Warranty package";
		    }elseif ($warranty_package == 7392) {
		    	$warranty_package = "AM Exclusive Warranty package";
		    }else{
		    	$warranty_package = "No Warranty";
		    }
		    //imageUpdateHexon($product);
		    $this->getImageSynced($sku);
		    $this->imageUploadSync($product);
			$data 			= array(
		        "stocknumber" => $sku,
		        "identification" => array(
		            "direct_link" => $productUrl
		        ),
		        "general" => array(
		            "category" => $generalCategory,
		            "bodystyle" => $bodystyle,
		            "make"=> array(
				      "name"=> $title
				    )
		        ),
		        "history"=> array(
				   	"construction_date"=> $year_of_manufacture_t
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

//print_r(json_encode($data));die;
		    $url = 'https://api.hexon.nl/spi/api/v4/rest/vehicle/'.urlencode($sku);
		    $curl = curl_init();
		    curl_setopt_array($curl, array(
		        CURLOPT_URL => $url,
		        CURLOPT_RETURNTRANSFER => true,
		        CURLOPT_ENCODING => '',
		        CURLOPT_MAXREDIRS => 10,
		        CURLOPT_TIMEOUT => 0,
		        CURLOPT_FOLLOWLOCATION => true,
		        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		        CURLOPT_CUSTOMREQUEST => 'PUT',
		        CURLOPT_POSTFIELDS => json_encode($data),
		        CURLOPT_HTTPHEADER => $headers,
		    ));
		    /*$response = curl_exec($curl);
		    curl_close($curl);

		    echo $response;*/
		    try {
		        $response = curl_exec($curl);
		        //print_r($response);die;
		        if ($response === false) {
		            throw new Exception(curl_error($curl), curl_errno($curl));
		        }
		    	echo "Synced Product Updated in Hexon with SKU = ".$sku."\n";
		    } catch (Exception $e) {
		        echo 'Caught exception: ' . $e->getMessage();
		    }
		}
		// SYNC Product in Hexon

		public function hexonSyncProduct($product,$generalCategory) {
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
		    $bodystyle 						= $product->getResource()->getAttribute("bodystyle")->getFrontend()->getValue($product);
		    if ($warranty_package == 7391) {
		    	$warranty_package = "AM Premium Warranty package";
		    }elseif ($warranty_package == 7392) {
		    	$warranty_package = "AM Exclusive Warranty package";
		    }else{
		    	$warranty_package = "No Warranty";
		    }
		    $this->imageUploadSync($product);
			$data 			= array(
		        "stocknumber" => $sku,
		        "identification" => array(
		            "direct_link" => $productUrl
		        ),
		        "general" => array(
		            "category" => $generalCategory,
		            "bodystyle" => $bodystyle
		        ),
		        "history"=> array(
				   	"construction_date"=> $year_of_manufacture_t
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

		    /*$response = curl_exec($curl);
		    curl_close($curl);
		    echo $response;*/

		    try {
		        $response = curl_exec($curl);
		        //echo $response;die;
		        $responseArray = json_decode($response, true);
				
				if ($responseArray !== null) {
					if (isset($responseArray['result']['stocknumber'])) {
				        $stocknumber = $responseArray['result']['stocknumber'];
				        $this->hexonProductUpdate($product,$generalCategory);
				    }
				} 

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
	    public function hexonUpdatePlateform($plateform, $productData, $sku)
		{	
			echo $plateform. " Hexon update plateform running........... \n";
			$sku 						=$productData->getSku();
			$curl = curl_init();
			$postData = array(
			    "stocknumber" => $sku,
			    "site_code" => $plateform
			);

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehiclesiteselections/',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
			  CURLOPT_HTTPHEADER => array(
			    'Content-Type: application/json',
			    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
			  ),
			));
			$response = curl_exec($curl);
			curl_close($curl);
			//echo $response;
		}
		public function deletePlateform($siteCode, $productData, $sku){
			//die("Zdfd");
			echo $siteCode."  Hexon delete plateform running........... \n";
			$curl = curl_init();
			$postData = array(
			    "stocknumber" => $sku,
			    "site_code" => $siteCode
			);
			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehiclesiteselection/'.urlencode($sku).":".$siteCode,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'DELETE',
			  CURLOPT_POSTFIELDS => json_encode($postData), // Convert array to JSON string
			  CURLOPT_HTTPHEADER => array(
			    'Content-Type: application/json',
			    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
			  ),
			));
			$response = curl_exec($curl);
			curl_close($curl);
		}

		public function getPlateform($plateform, $productData, $sku){
			echo "Hexon get plateform running........... \n";
			$curl = curl_init();
			$postData = array(
			    "stocknumber" => $sku
			);
			//echo $sku;die;
			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehiclesiteselections/?stocknumber='.urlencode($sku),
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'GET',
			  CURLOPT_HTTPHEADER => array(
			    'Content-Type: application/json',
			    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
			  ),
			));
			//echo $curl; die;
			$response = curl_exec($curl);
			$responseArray = json_decode($response, true);
			if ($responseArray !== null) {
				if ($responseArray['results']) {
					foreach ($responseArray['results'] as $responseResults) {
						$siteCode = $responseResults['site_code'];
						if ($siteCode) {
							echo "Hexon get plateform running in loop when condition matched........... \n";
							$this->deletePlateform($siteCode, $productData, $sku);
						}
					}
				}
			} 
			curl_close($curl);
		}
	public function getImageSynced($sku){
		
    	$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicle/'.urlencode($sku).'/vehicleimages/',
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
		$responseArray = json_decode($response, true);
		 

		// Check if the results key exists and is an array
		if (isset($responseArray['results']) && is_array($responseArray['results'])) {
		    // Loop through each result and get the 'nr' value
		    foreach ($responseArray['results'] as $result) {
		        if (isset($result['nr'])) {
		        	$nr = $result['nr'];
		            $this->deleteImages($sku,$nr);
		        }
		    }
		} 
	}
	public function deleteImages($sku,$nr){
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.hexon.nl/spi/api/v4/rest/vehicleimage/'.$sku.':'.$nr,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'DELETE',
		  CURLOPT_HTTPHEADER => array(
		    'Authorization: Basic YW1tYWNoaW5lcnk6bT5OSChuRGNHKGNeLU1PeUArZGhKYWZG'
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
	}
}
