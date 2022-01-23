<?php

/**
 * REST User Model
 *
 * @method string getUsername
 * @method $this setUsername(string $username)
 * @method string getApiKey
 * @method $this setApiKey(string $apiKey)
 * @method string getNewApiKey
 * @method $this setNewApiKey(string $apiKey)
 * @method bool getIsActive
 * @method $this setIsActive(bool $isActive)
 * @method string getCreatedAt
 * @method string getUpdatedAt
 * @method $this setUpdatedAt(string $updatedAt)
 * @method $this setRoleId(int $roleId)
 * @method int getRoleId
 * @method Elidrissidev_Api2BasicAuth_Model_Resource_Restuser getResource
 * @method Elidrissidev_Api2BasicAuth_Model_Resource_Restuser _getResource
 *
 * @package Elidrissidev_Api2BasicAuth
 * @author  Mohamed ELIDRISSI <mohamed@elidrissi.dev>
 * @license https://opensource.org/licenses/MIT  MIT License
 */
class Elidrissidev_Api2BasicAuth_Model_Restuser extends Mage_Core_Model_Abstract
{
    /**
     * @var int
     */
    const MIN_API_KEY_LENGTH = 8;

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('elidrissidev_api2basicauth/restuser');
    }

    /**
     * Load a user by username
     *
     * @param string $username
     */
    public function loadByUsername($username)
    {
        return $this->load($username, 'username');
    }

    /**
     * Check if a user already exists
     *
     * @return bool
     */
    public function userExists()
    {
        return $this->_getResource()->userExists($this);
    }

    /**
     * Get REST User Role
     *
     * @return Mage_Api2_Model_Acl_Global_Role
     */
    public function getRole()
    {
        return $this->_getResource()->getRole($this);
    }

    /**
     * @inheritdoc
     */
    protected function _beforeSave()
    {
        if ($this->hasNewApiKey()) {
            $apiKey = $this->getNewApiKey();
        } elseif ($this->hasApiKey()) {
            $apiKey = $this->getApiKey();
        }

        // Hash the Api Key before saving it
        if (isset($apiKey)) {
            $this->setApiKey(
                Mage::helper('core')->getHash($apiKey, Mage_Admin_Model_User::HASH_SALT_LENGTH)
            );
        }

        if (!$this->isObjectNew()) {
            $this->setUpdatedAt(Varien_Date::now());
        }

        return parent::_beforeSave();
    }

    /**
     * @inheritdoc
     */
    protected function _afterSave()
    {
        $this->saveRoleRelation();

        return parent::_afterSave();
    }

    /**
     * Save REST User relation to Api2 Role
     *
     * @return $this
     */
    public function saveRoleRelation()
    {
        if ($this->hasRoleId()) {
            $this->_getResource()->saveRoleRelation($this->getId(), $this->getRoleId());
        }
        return $this;
    }

    /**
     * Validate user data
     *
     * @return array|true
     */
    public function validate()
    {
        $errors = array();

        if (!Zend_Validate::is($this->getUsername(), 'NotEmpty')) {
            $errors[] = $this->_getHelper()->__('Username is required.');
        }
        if ($this->userExists()) {
            $errors[] = $this->_getHelper()->__('This username is already used.');
        }

        if ($this->hasApiKey()) {
            $apiKey = $this->getApiKey();
        } elseif ($this->hasNewApiKey()) {
            $apiKey = $this->getNewApikey();
        }

        if (isset($apiKey)) {
            if (strlen($apiKey) < self::MIN_API_KEY_LENGTH) {
                $errors[] = $this->_getHelper()->__('Api Key must be at least %d characters long.', self::MIN_API_KEY_LENGTH);
            }
            if (!preg_match('/[a-z]/i', $apiKey) || !preg_match('/[0-9]+/', $apiKey)) {
                $errors[] = $this->_getHelper()->__('Api Key must contain both numeric and alphabetic characters.');
            }
            if ($apiKey !== $this->getApiKeyConfirmation()) {
                $errors[] = $this->_getHelper()->__('Api Key confirmation does not match.');
            }
        }
        if ($this->hasRoleId()) {
            $roles = $this->getRoleId();

            if (is_array($roles)) {
                $errors[] = $this->_getHelper()->__('Invalid role selected.');
            }
        }

        if (empty($errors)) {
            return true;
        }

        return $errors;
    }

    /**
     * Get module helper
     *
     * @return Elidrissidev_Api2BasicAuth_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('elidrissidev_api2basicauth');
    }
}
