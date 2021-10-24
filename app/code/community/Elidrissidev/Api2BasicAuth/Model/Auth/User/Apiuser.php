<?php

/**
 * Api Auth User
 * 
 * @author  Mohamed ELIDRISSI
 * @package Elidrissidev_Api2BasicAuth
 */
class Elidrissidev_Api2BasicAuth_Model_Auth_User_Apiuser extends Mage_Api2_Model_Auth_User_Abstract
{
    const USER_TYPE = 'apiuser';

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return Mage::helper('elidrissidev_api2basicauth')->__('Api User');        
    }

    /**
     * @inheritdoc
     */
    public function getRole()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return self::USER_TYPE;
    }
}
