<?php
/**
 * @package Elidrissidev_Api2BasicAuth
 * @author  Mohamed ELIDRISSI <mohamed@elidrissi.dev>
 * @license https://opensource.org/licenses/MIT  MIT License
 */

/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;

$adapter = $installer->getConnection();

$installer->startSetup();

/**
 * Create table 'elidrissidev_api2basicauth/restuser'
 */
$table = $adapter->newTable($installer->getTable('elidrissidev_api2basicauth/restuser'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary'  => true
        ),
        'REST User ID'
    )
    ->addColumn(
        'username',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        40,
        array('nullable' => false),
        'User Name'
    )
    ->addColumn(
        'api_key',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        255,
        array('nullable' => false),
        'Api Key'
    )
    ->addColumn(
        'is_active',
        Varien_Db_Ddl_Table::TYPE_SMALLINT,
        null,
        array(
            'unsigned' => true,
            'nullable' => false,
            'default'  => '1'
        ),
        'Is Active'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(
            'nullable' => false,
            'default'  => Varien_Db_Ddl_Table::TIMESTAMP_INIT
        ),
        'Created At'
    )
    ->addColumn(
        'updated_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(
            'nullable' => true,
            'default'  => Varien_Db_Ddl_Table::TIMESTAMP_UPDATE
        ),
        'Updated At'
    )
    ->addIndex(
        $installer->getIdxName(
            $installer->getTable('elidrissidev_api2basicauth/restuser'),
            'username',
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        'username',
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    )
    ->setComment('REST Users');

$adapter->createTable($table);

/**
 * Create table 'elidrissidev_api2basicauth/acl_restuser'
 */
$table = $adapter->newTable($installer->getTable('elidrissidev_api2basicauth/acl_restuser'))
    ->addColumn(
        'restuser_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'unsigned' => true,
            'nullable' => false,
            'primary'  => true
        ),
        'REST User ID'
    )
    ->addColumn(
        'role_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'unsigned' => true,
            'nullable' => false
        ),
        'Role ID'
    )
    ->addIndex(
        $installer->getIdxName(
            $installer->getTable('elidrissidev_api2basicauth/acl_restuser'),
            'restuser_id',
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        'restuser_id',
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    )
    ->addForeignKey(
        $installer->getFkName(
            'elidrissidev_api2basicauth/acl_restuser',
            'restuser_id',
            'elidrissidev_api2basicauth/restuser',
            'entity_id'
        ),
        'restuser_id',
        $installer->getTable('elidrissidev_api2basicauth/restuser'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->addForeignKey(
        $installer->getFkName(
            'elidrissidev_api2basicauth/acl_restuser',
            'role_id',
            'api2/acl_role',
            'entity_id'
        ),
        'role_id',
        $installer->getTable('api2/acl_role'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('REST Users ACL Role');

$adapter->createTable($table);

$installer->endSetup();
