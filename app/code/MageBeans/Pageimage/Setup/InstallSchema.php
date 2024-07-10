<?php 
namespace MageBeans\Pageimage\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $connection = $installer->getConnection();

        $connection->addColumn('cms_page','extra_image',
        	['type' =>\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
        	'comment' => 'cms page extra image']
        );
        $connection->addColumn('cms_page','page_headng',
            ['type' =>\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            'comment' => 'cms page extra image']
        );
        $connection->addColumn('cms_page','page_subheading',
            ['type' =>\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            'comment' => 'cms page extra image']
        );
        $installer->endSetup();
    }
}