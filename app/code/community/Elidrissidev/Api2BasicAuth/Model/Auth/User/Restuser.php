<?php

/**
 * Api2 REST User
 *
 * @package Elidrissidev_Api2BasicAuth
 * @author  Mohamed ELIDRISSI <mohamed@elidrissi.dev>
 * @license https://opensource.org/licenses/MIT  MIT License
 */
class Elidrissidev_Api2BasicAuth_Model_Auth_User_Restuser extends Mage_Api2_Model_Auth_User_Abstract
{
    const USER_TYPE = 'restuser';

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return Mage::helper('elidrissidev_api2basicauth')->__('REST User');
    }

    /**
     * @inheritdoc
     */
    public function getRole()
    {
        if (!$this->_role) {
            if (!$this->getUserId()) {
                throw new Exception('REST User identifier is not set');
            }

            /** @var Elidrissidev_Api2BasicAuth_Model_Resource_Restuser $restuser */
            $restuser = Mage::getResourceModel('elidrissidev_api2basicauth/restuser');

            /** @var Mage_Api2_Model_Acl_Global_Role $role */
            $role = $restuser->getRole($this->getUserId());
            if (!$role->getId()) {
                throw new Exception('REST User role not found');
            }

            $this->setRole($role->getId());
        }

        return $this->_role;
    }

    /**
     * Set user role
     *
     * @param int $role
     * @return $this
     * @throws Exception
     */
    public function setRole($role)
    {
        if ($this->_role) {
            throw new Exception('REST User role has already been set');
        }
        $this->_role = $role;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return self::USER_TYPE;
    }
}
