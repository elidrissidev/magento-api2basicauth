<?php

/**
 * REST User Resource Collection
 *
 * @package Elidrissidev_Api2BasicAuth
 * @author  Mohamed ELIDRISSI <mohamed@elidrissi.dev>
 * @license https://opensource.org/licenses/MIT  MIT License
 */
class Elidrissidev_Api2BasicAuth_Model_Resource_Restuser_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('elidrissidev_api2basicauth/restuser');
    }
}
