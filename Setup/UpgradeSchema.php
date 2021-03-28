<?php
namespace Avalex\PrivacyPolicy\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface {

    public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        $installer = $setup;
        $installer->startSetup();

        if (version_compare($context->getVersion(), "1.0.5", "<")) {
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
            else {
                $tableName = $setup->getTable('avalex_log');

                if ($setup->getConnection()->isTableExists($tableName) == true) {

                    $columns = [
                        'type' => [
                            'type' => Table::TYPE_TEXT,
                            'nullable' => false,
                            'comment' => 'Legal content type',
                            'size' => 255
                        ],
                    ];

                    $connection = $setup->getConnection();
                    foreach ($columns as $name => $definition) {
                        $connection->addColumn($tableName, $name, $definition);
                    }
                }
            }
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
