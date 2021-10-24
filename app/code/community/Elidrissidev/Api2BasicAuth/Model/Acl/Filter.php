<?php

/**
 * Api2 User Acl Filter
 * 
 * @author  Mohamed ELIDRISSI
 * @package Elidrissidev_Api2BasicAuth
 */
class Elidrissidev_Api2BasicAuth_Model_Acl_Filter extends Mage_Api2_Model_Acl_Filter
{
    /**
     * @inheritdoc
     */
    public function getAllowedAttributes($operationType = null)
    {
        if (null === $this->_allowedAttributes) {
            /** @var Elidrissidev_Api2BasicAuth_Helper_Data $helper */
            $helper = Mage::helper('elidrissidev_api2basicauth');

            if (null === $operationType) {
                $operationType = Mage::helper('api2')->getTypeOfOperation($this->_resource->getOperation());
            }
            if ($helper->isAllAttributesAllowed($this->_resource->getApiUser()->getUserId())) {
                $this->_allowedAttributes = array_keys($this->_resource->getAvailableAttributes(
                    $this->_resource->getUserType(),
                    $operationType
                ));
            } else {
                $this->_allowedAttributes = Mage::helper('api2')->getAllowedAttributes(
                    $this->_resource->getUserType(),
                    $this->_resource->getResourceType(),
                    $operationType
                );
            }
            // force attributes to be no filtered
            foreach ($this->_resource->getForcedAttributes() as $forcedAttr) {
                if (!in_array($forcedAttr, $this->_allowedAttributes)) {
                    $this->_allowedAttributes[] = $forcedAttr;
                }
            }
        }
        return $this->_allowedAttributes;
    }
}
