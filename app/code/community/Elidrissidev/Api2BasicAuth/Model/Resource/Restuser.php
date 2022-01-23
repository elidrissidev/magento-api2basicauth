<?php

/**
 * REST User Resource Model
 *
 * @package Elidrissidev_Api2BasicAuth
 * @author  Mohamed ELIDRISSI <mohamed@elidrissi.dev>
 * @license https://opensource.org/licenses/MIT  MIT License
 */
class Elidrissidev_Api2BasicAuth_Model_Resource_Restuser extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('elidrissidev_api2basicauth/restuser', 'entity_id');
    }

    /**
     * Save REST User relation to Api2 Role
     *
     * @param int $restuserId
     * @param int $roleId
     * @return $this
     */
    public function saveRoleRelation($restuserId, $roleId)
    {
        if (
            Mage_Api2_Model_Acl_Global_Role::ROLE_GUEST_ID == $roleId
            || Mage_Api2_Model_Acl_Global_Role::ROLE_CUSTOMER_ID == $roleId
        ) {
            Mage::throwException(
                Mage::helper('elidrissidev_api2basicauth')->__('Cannot assign system roles to REST Users.')
            );
        }

        $read = $this->_getReadAdapter();
        $table = $this->getTable('elidrissidev_api2basicauth/acl_restuser');

        $select = $read->select()
            ->from($table, 'restuser_id')
            ->where('restuser_id = ?', $restuserId, Zend_Db::INT_TYPE);

        $write = $this->_getWriteAdapter();

        if ($read->fetchOne($select) === false) {
            $write->insert($table, array('restuser_id' => $restuserId, 'role_id' => $roleId));
        } else {
            $write->update($table, array('role_id' => $roleId), array('restuser_id = ?' => $restuserId));
        }

        return $this;
    }

    /**
     * Check if user already exists
     *
     * @param Elidrissidev_Api2BasicAuth_Model_Restuser $restuser
     * @return bool
     */
    public function userExists($restuser)
    {
        $adapter = $this->_getReadAdapter();

        $select = $adapter->select()
            ->from($this->getMainTable(), 'username')
            ->where('username = ?', $restuser->getUsername());

        if ($restuser->getId()) {
            $select->where('entity_id != ?', $restuser->getId());
        }

        return (bool) $adapter->fetchOne($select);
    }

    /**
     * Get REST User Role
     *
     * @param Elidrissidev_Api2BasicAuth_Model_Restuser|int $restuserId
     * @return Mage_Api2_Model_Acl_Global_Role
     */
    public function getRole($restuserId)
    {
        if ($restuserId instanceof Elidrissidev_Api2BasicAuth_Model_Restuser) {
            $restuserId = $restuserId->getId();
        }

        /** @var Mage_Api2_Model_Resource_Acl_Global_Role_Collection $collection */
        $collection = Mage::getResourceModel('api2/acl_global_role_collection');
        $collection->getSelect()
            ->joinInner(
                array('acl_restuser' => $this->getTable('elidrissidev_api2basicauth/acl_restuser')),
                'main_table.entity_id = acl_restuser.role_id',
            )
            ->where('acl_restuser.restuser_id = ?', $restuserId, Zend_Db::INT_TYPE);

        return $collection->getFirstItem();
    }
}
