<?php

/**
 * Api2 User Grid Container
 * 
 * @author  Mohamed ELIDRISSI
 * @package Elidrissidev_Api2BasicAuth
 */
class Elidrissidev_Api2BasicAuth_Block_Adminhtml_User extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * @inheritdoc
     */
    public function __construct()
    {
        $this->_blockGroup = 'elidrissidev_api2basicauth';
        $this->_controller = 'adminhtml_user';
        $this->_headerText = $this->__('REST Users');
        parent::__construct();
    }
}
