<?php

/**
 * Api2 User Acl Filter Attribute Resource Model
 * 
 * @author  Mohamed ELIDRISSI
 * @package Elidrissidev_Api2BasicAuth
 */
class Elidrissidev_Api2BasicAuth_Model_Resource_Acl_Filter_Attribute extends Mage_Core_Model_Resource_Db_Abstract
{
    const FILTER_RESOURCE_ALL = 'all';

    protected function _construct()
    {
        $this->_init('elidrissidev_api2basicauth/acl_attribute', 'entity_id');
    }

    /**
     * Check if all attributes are allowed for a user
     *
     * @param int $userId
     * @return bool
     */
    public function isAllAttributesAllowed($userId)
    {
        $resourceId = self::FILTER_RESOURCE_ALL;

        $select = $this->_getReadAdapter()->select()
            ->from($this->getMainTable(), new Zend_Db_Expr('COUNT(*)'))
            ->where('user_id = ?', $userId)
            ->where('resource_id = ?', $resourceId);

        return ($this->_getReadAdapter()->fetchOne($select) == 1);
    }
}
