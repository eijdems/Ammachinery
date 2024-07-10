<?php

use Magento\Framework\App\Bootstrap;

require __DIR__ . '/app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();
$state = $objectManager->get('Magento\Framework\App\State');
//$state->setAreaCode(Area::AREA_ADMINHTML);
$state->setAreaCode('adminhtml'); // or 'adminhtml' depending on your context

$productRepository = $objectManager->get(\Magento\Catalog\Api\ProductRepositoryInterface::class);
$galleryProcessor = $objectManager->get(\Magento\Catalog\Model\Product\Gallery\Processor::class);

$productCollection = $objectManager->create(\Magento\Catalog\Model\ResourceModel\Product\Collection::class);
$products = $productCollection->addAttributeToSelect('sku')->getItems();

foreach ($products as $productData) {
    $sku = $productData->getSku();
    //$sku = "00 0126 111 0-AM";
    //$sku = "00 0126 114 0-AM";
    $imageDirectoryPath = BP . '/pub/media/import/' . $sku . "/";
    $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/imageimport.log');
    $logger = new \Zend_Log();
    $logger->addWriter($writer);
    $logger->info('image importing'); // Print string type data
    // Print array type data
    if (is_dir($imageDirectoryPath)) {
        try {
            $product = $productRepository->get($sku);
            $existingMediaGalleryEntries = $product->getMediaGalleryEntries();

            foreach ($existingMediaGalleryEntries as $key => $entry) {
                if (!empty($entry)) {
                    unset($existingMediaGalleryEntries[$key]);
                } else {
                    echo "already deleted";
                }
            }

            $product->setMediaGalleryEntries($existingMediaGalleryEntries);
            $productRepository->save($product);

            echo "Images deleted successfully for product with SKU '{$sku}'." . "\n";

            // Get all files in the directory
            $files = scandir($imageDirectoryPath);
            $files = array_diff($files, ['.', '..']);
            sort($files);

            foreach ($files as $key => $imageName) {
                $imagePath = $imageDirectoryPath . $imageName;

                if (!file_exists($imagePath)) {
                    echo "Image '{$imageName}' not found in directory.";
                    continue;
                }

                try {
                    // Enable interlace handling for PNG images
                    $baseImageName = pathinfo($imageName, PATHINFO_FILENAME);
                    $options = [];
                    if ($key === 0) { // For the first image, set as base, thumbnail, and small image
                        $options = ['image', 'small_image', 'thumbnail'];
                    }
                    if (strtolower(pathinfo($imagePath, PATHINFO_EXTENSION)) === 'png') {
                        $options[] = 'interlace';
                    }
                    
                    $product->addImageToMediaGallery($imagePath, $options, false, false,$baseImageName);
                    $logger->info('saved successfully images'.$imageName.' SKU : '.$sku );
                    echo "Image '{$imageName}' added to product '{$sku}'." . "\n";
                } catch (\Exception $e) {
                    echo "Error adding image '{$imageName}' to product '{$sku}': " . $e->getMessage() . "\n";
                }
            }

            try {
                $productRepository->save($product);
                echo "Product '{$sku}' saved successfully with images." . "\n";
            } catch (\Exception $e) {
                echo "Error saving product '{$sku}': " . $e->getMessage() . "\n";
            }
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            echo "Product with SKU '{$sku}' not found." . "\n";
        } catch (\Exception $e) {
            echo "Error deleting images for product with SKU '{$sku}': " . $e->getMessage() . "\n";
        }
    } else {
        echo $sku . ' Directory does not exist' . "\n";
    }
}
