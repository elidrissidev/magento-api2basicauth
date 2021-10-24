<?php

/**
 * Data Helper
 * 
 * @author  Mohamed ELIDRISSI
 * @package Elidrissidev_Api2BasicAuth
 */
class Elidrissidev_Api2BasicAuth_Helper_Data extends Mage_Core_Helper_Data
{
    /**
     * Get is all attributes allowed for user
     *
     * @param int $userId
     * @return bool
     */
    public function isAllAttributesAllowed($userId)
    {
        /** @var Elidrissidev_Api2BasicAuth_Model_Resource_Acl_Filter_Attribute $attribute */
        $attribute = Mage::getResourceModel('elidrissidev_api2basicauth/acl_filter_attribute');

        return $attribute->isAllAttributesAllowed($userId);
    }
}
