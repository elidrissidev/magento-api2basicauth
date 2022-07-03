<?php

class Mage_Customer_Model_Api2_Customer_Address_Rest_Restuser_V1 extends Mage_Customer_Model_Api2_Customer_Address_Rest_Admin_V1
{
    /**
     * @inheritdoc
     */
    protected function _getResourceAttributes()
    {
        return $this->getEavAttributes();
    }
}
