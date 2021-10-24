<?php

/**
 * Api User Model
 * 
 * @method string getUsername
 * @method $this setUsername(string $username)
 * @method string getApiKey
 * @method $this setApiKey(string $apiKey)
 * @method bool getIsActive
 * @method $this setIsActive(bool $isActive)
 * @method string getCreatedAt
 * @method string getUpdatedAt
 * @method $this setUpdatedAt(string $updatedAt)
 * 
 * @author  Mohamed ELIDRISSI
 * @package Elidrissidev_Api2BasicAuth
 */
class Elidrissidev_Api2BasicAuth_Model_User extends Mage_Core_Model_Abstract
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('elidrissidev_api2basicauth/user');
    }

    /**
     * Load a user by username
     * 
     * @param string $username
     */
    public function loadByUsername($username)
    {
        $this->load($username, 'username');

        return $this;
    }
}
