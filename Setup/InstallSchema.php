<?php
namespace Avalex\PrivacyPolicy\Setup;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface {

    public function install( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        $installer = $setup;
        $installer->startSetup();

        // Create table 'avalex_log'
        if (!$installer->tableExists('avalex_log')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable( 'avalex_log' )
            )->addColumn(
                'version_id',
                Table::TYPE_INTEGER,
                null,
                [ 'identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true ],
                'dataset ID'
            )->addColumn(
                'type',
                Table::TYPE_TEXT,
                '255',
                [ ],
                'Legal content type'
            )->addColumn(
                'html',
                Table::TYPE_TEXT,
                '2M',
                [ ],
                'Privacy Policy HTML'
            )->addColumn(
                'store_code',
                Table::TYPE_TEXT,
                '255',
                [ ],
                'magento store code'
            )->addColumn(
                'changed',
                Table::TYPE_TIMESTAMP,
                null,
                [ 'nullable' => false, 'default' => Table::TIMESTAMP_INIT ],
                'Change timestamp'
            )->setComment(
                'Avalex Privacy Policy Table'
            );
            $installer->getConnection()->createTable( $table );
        }


        // Ensure that table 'variable_value' supports much content
        if ($installer->tableExists('variable_value')) {

            $installer->getConnection()->modifyColumn(
                    $installer->getTable('variable_value'),
                    'html_value',
                    [
                        'type' => Table::TYPE_TEXT,
                        'length' => '2M',
                        'comment' => 'Html Value'
                    ]
            );

        }

        $installer->endSetup();

    }
}
