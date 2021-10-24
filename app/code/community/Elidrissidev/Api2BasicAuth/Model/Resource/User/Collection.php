<?php

/**
 * Api2 User Grid
 * 
 * @author  Mohamed ELIDRISSI
 * @package Elidrissidev_Api2BasicAuth
 */
class Elidrissidev_Api2BasicAuth_Model_Resource_User_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('elidrissidev_api2basicauth/user');
    }
}
