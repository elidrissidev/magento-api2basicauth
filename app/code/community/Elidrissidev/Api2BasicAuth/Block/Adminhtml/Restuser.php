<?php

/**
 * REST Users Grid Container
 *
 * @package Elidrissidev_Api2BasicAuth
 * @author  Mohamed ELIDRISSI <mohamed@elidrissi.dev>
 * @license https://opensource.org/licenses/MIT  MIT License
 */
class Elidrissidev_Api2BasicAuth_Block_Adminhtml_Restuser extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected $_blockGroup = 'elidrissidev_api2basicauth';
    protected $_controller = 'adminhtml_restuser';

    /**
     * @inheritdoc
     */
    protected function _prepareLayout()
    {
        if (!Mage::getSingleton('admin/session')->isAllowed('system/api/rest_users/create')) {
            $this->_removeButton('add');
        }
        return parent::_prepareLayout();
    }

    /**
     * @inheritdoc
     */
    public function getHeaderText()
    {
        return $this->__('REST Users');
    }
}
