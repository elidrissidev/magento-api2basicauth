<?php

/**
 * Api User Resource Model
 * 
 * @author  Mohamed ELIDRISSI
 * @package Elidrissidev_Api2BasicAuth
 */
class Elidrissidev_Api2BasicAuth_Model_Resource_User extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('elidrissidev_api2basicauth/user', 'entity_id');
    }
}
