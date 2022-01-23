<?php

/**
 * REST User Edit Form Container
 *
 * @package Elidrissidev_Api2BasicAuth
 * @author  Mohamed ELIDRISSI <mohamed@elidrissi.dev>
 * @license https://opensource.org/licenses/MIT  MIT License
 */
class Elidrissidev_Api2BasicAuth_Block_Adminhtml_Restuser_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected $_objectId = 'id';
    protected $_blockGroup = 'elidrissidev_api2basicauth';
    protected $_controller = 'adminhtml_restuser';
    protected $_mode = 'edit';

    /**
     * @inheritdoc
     */
    protected function _prepareLayout()
    {
        $this->_addButton('save_and_continue', array(
            'label'     => $this->__('Save and Continue Edit'),
            'onclick'   => 'editForm.submit(\''.$this->_getSaveAndContinueUrl().'\');',
            'class'     => 'save'
        ), 10);

        if (!Mage::getSingleton('admin/session')->isAllowed('system/api/rest_users/delete')) {
            $this->_removeButton('delete');
        }
        return parent::_prepareLayout();
    }

    /**
     * Get URL for "Save and Continue Edit" button
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', array(
            '_current' => true,
            'back'     => 'edit'
        ));
    }

    /**
     * @inheritdoc
     */
    public function getHeaderText()
    {
        /** @var Elidrissidev_Api2BasicAuth_Model_Restuser $restuser */
        $restuser = Mage::registry('current_restuser');

        if ($restuser->getId()) {
            return $this->__("Edit User '%s'", $restuser->getUsername());
        }

        return $this->__('New User');
    }
}
