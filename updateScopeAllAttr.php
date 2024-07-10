<?php
use Magento\Framework\App\Bootstrap;
use Magento\Catalog\Api\ProductAttributeRepositoryInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\App\State;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\ObjectManagerInterface;

require __DIR__ . '/app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);

$objectManager = $bootstrap->getObjectManager();
$state = $objectManager->get(State::class);
$state->setAreaCode('adminhtml');

$attributeRepository = $objectManager->get(ProductAttributeRepositoryInterface::class);

$csvFile = 'updateScope.csv'; // Path to your CSV file

if (!file_exists($csvFile) || !is_readable($csvFile)) {
    throw new \Exception('CSV file does not exist or is not readable.');
}

$csvData = array_map('str_getcsv', file($csvFile)); // Read and parse CSV file

foreach ($csvData as $line) {
    $attributeCode = trim($line[0]); // Assuming the attribute code is in the first column

    try {
        // Load attribute by code
        $attribute = $attributeRepository->get($attributeCode);
        $currentScope = $attribute->getIsGlobal();

        // Print current scope
        switch ($currentScope) {
            case ScopedAttributeInterface::SCOPE_STORE:
                $currentScopeLabel = 'Store';
                break;
            case ScopedAttributeInterface::SCOPE_WEBSITE:
                $currentScopeLabel = 'Website';
                break;
            case ScopedAttributeInterface::SCOPE_GLOBAL:
                $currentScopeLabel = 'Global';
                break;
            default:
                $currentScopeLabel = 'Unknown';
                break;
        }
        echo "Attribute '$attributeCode' current scope: $currentScopeLabel = ";

        if ($currentScope != ScopedAttributeInterface::SCOPE_GLOBAL) {
            // Update attribute scope to global
            $attribute->setIsGlobal(ScopedAttributeInterface::SCOPE_GLOBAL);

            // Save attribute
            $attributeRepository->save($attribute);

            echo "Attribute '$attributeCode' scope updated to global.\n";
        } else {
            echo "Attribute '$attributeCode' is already global.\n";
        }
    } catch (NoSuchEntityException $e) {
        echo "Attribute '$attributeCode' not found.\n";
    } catch (\Exception $e) {
        echo "Error updating attribute '$attributeCode': " . $e->getMessage() . "\n";
    }
}
