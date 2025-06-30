<?php

use Magento\Framework\App\Bootstrap;

require __DIR__ . '/../app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();
$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('adminhtml'); // or 'adminhtml' depending on your context

$productRepository = $objectManager->get(\Magento\Catalog\Api\ProductRepositoryInterface::class);
$galleryProcessor = $objectManager->get(\Magento\Catalog\Model\Product\Gallery\Processor::class);

$sku = "00 0984 493 1-AM"; // Set your desired SKU
$imageDirectoryPath = BP . '/pub/media/import/' . $sku . "/";

$writer = new \Zend_Log_Writer_Stream(BP . '/var/log/imageimport.log');
$logger = new \Zend_Log();
$logger->addWriter($writer);
$logger->info('Image importing for SKU: ' . $sku);

if (is_dir($imageDirectoryPath)) {
    try {
        $product = $productRepository->get($sku);
        $existingMediaGalleryEntries = $product->getMediaGalleryEntries();

        foreach ($existingMediaGalleryEntries as $key => $entry) {
            unset($existingMediaGalleryEntries[$key]);
        }

        $product->setMediaGalleryEntries($existingMediaGalleryEntries);
        $productRepository->save($product);

        echo "Images deleted successfully for product with SKU '{$sku}'." . "\n";

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
                $baseImageName = pathinfo($imageName, PATHINFO_FILENAME);
                $options = [];
                if ($key === 0) { // First image as base, thumbnail, and small image
                    $options = ['image', 'small_image', 'thumbnail'];
                }
                if (strtolower(pathinfo($imagePath, PATHINFO_EXTENSION)) === 'png') {
                    $options[] = 'interlace';
                }

                $product->addImageToMediaGallery($imagePath, $options, false, false, $baseImageName);
                $logger->info('Saved image ' . $imageName . ' for SKU: ' . $sku);
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
        echo "Error processing images for SKU '{$sku}': " . $e->getMessage() . "\n";
    }
} else {
    echo "Directory '{$imageDirectoryPath}' does not exist." . "\n";
}
