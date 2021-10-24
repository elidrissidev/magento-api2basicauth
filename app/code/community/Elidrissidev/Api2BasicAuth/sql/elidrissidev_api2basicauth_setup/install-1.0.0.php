<?php

/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;

$adapter = $installer->getConnection();

$installer->startSetup();

/**
 * Create table 'elidrissidev_api2basicauth/user'
 */
$table = $adapter->newTable($installer->getTable('elidrissidev_api2basicauth/user'))
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
        'User ID'
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
            'default'  => 'CURRENT_TIMESTAMP'
        ),
        'Created At'
    )
    ->addColumn(
        'updated_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array('nullable' => true),
        'Updated At'
    )
    ->setComment('Api2 Users');

$adapter->createTable($table);

/**
 * Create table 'elidrissidev_api2basicauth/acl_attributes'
 */
$table = $adapter->newTable($installer->getTable('elidrissidev_api2basicauth/acl_attribute'))
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
        'Entity ID'
    )
    ->addColumn(
        'user_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'unsigned' => true,
            'nullable' => false
        ),
        'User ID'
    )
    ->addColumn(
        'resource_id',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        255,
        array('nullable' => false),
        'Resource ID'
    )
    ->addColumn(
        'operation',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        20,
        array('nullable' => false),
        'Operation'
    )
    ->addColumn(
        'allowed_attributes',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        null,
        array(
            'nullable' => true,
            'default'  => null
        ),
        'Allowed Attributes'
    )
    ->addForeignKey(
        $installer->getFkName(
            'elidrissidev_api2basicauth/acl_attribute',
            'user_id',
            'elidrissidev_api2basicauth/user',
            'entity_id'
        ),
        'user_id',
        $installer->getTable('elidrissidev_api2basicauth/user'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->addIndex(
        $installer->getIdxName(
            $installer->getTable('elidrissidev_api2basicauth/acl_attribute'),
            array('user_id', 'resource_id', 'operation'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('user_id', 'resource_id', 'operation'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    )
    ->setComment('Api2 User Acl Attributes');

$adapter->createTable($table);

$installer->endSetup();
