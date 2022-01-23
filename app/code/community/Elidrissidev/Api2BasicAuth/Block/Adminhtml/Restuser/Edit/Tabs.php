<?php

/**
 * REST User Edit Tabs
 *
 * @package Elidrissidev_Api2BasicAuth
 * @author  Mohamed ELIDRISSI <mohamed@elidrissi.dev>
 * @license https://opensource.org/licenses/MIT  MIT License
 */
class Elidrissidev_Api2BasicAuth_Block_Adminhtml_Restuser_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('api2basicauth_restuser_tabs');
        $this->setDestElementId('edit_form');
    }
}
