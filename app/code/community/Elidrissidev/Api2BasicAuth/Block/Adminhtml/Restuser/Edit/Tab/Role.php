<?php

/**
 * REST User Edit Role Tab
 *
 * @package Elidrissidev_Api2BasicAuth
 * @author  Mohamed ELIDRISSI <mohamed@elidrissi.dev>
 * @license https://opensource.org/licenses/MIT  MIT License
 */
class Elidrissidev_Api2BasicAuth_Block_Adminhtml_Restuser_Edit_Tab_Role extends Mage_Adminhtml_Block_Widget_Grid
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Selected API2 role for grid
     *
     * @var array
     */
    protected $_selectedRole;

    public function __construct()
    {
        parent::__construct();
        $this->setId('restuser_section_role');
        $this->setUseAjax(true);
    }

    /**
     * @inheritdoc
     */
    protected function _prepareCollection()
    {
        /** @var Mage_Api2_Model_Resource_Acl_Global_Role_Collection $collection */
        $collection = Mage::getResourceModel('api2/acl_global_role_collection');
        $collection->addFieldToFilter('entity_id', ['nin' => Mage_Api2_Model_Acl_Global_Role::getSystemRoles()]);

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @inheritDoc
     */
    protected function _prepareColumns()
    {
        $this->addColumn('assigned_user_role', [
            'header_css_class' => 'a-center',
            'header'    => Mage::helper('api2')->__('Assigned'),
            'type'      => 'radio',
            'html_name' => 'role_id',
            'values'    => [$this->_getSelectedRole()],
            'align'     => 'center',
            'index'     => 'entity_id'
        ]);

        $this->addColumn('role_name', [
            'header' => Mage::helper('api2')->__('Role Name'),
            'index'  => 'role_name'
        ]);

        return parent::_prepareColumns();
    }

    /**
     * @inheritdoc
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'assigned_user_role') {
            $roleId = $this->_getSelectedRole();

            /** @var Mage_Api2_Model_Resource_Acl_Global_Role_Collection $collection */
            $collection = $this->getCollection();

            if ($column->getFilter()->getValue()) {
                $collection->addFieldToFilter('entity_id', $roleId);
            } elseif ($roleId) {
                $collection->addFieldToFilter('entity_id', ['neq' => $roleId]);
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }

        return $this;
    }

    /**
     * Get selected API2 roles for grid
     *
     * @return int
     */
    protected function _getSelectedRole()
    {
        if ($this->_selectedRole === null) {
            $restuser = $this->_getRestuser();

            if ($restuser->getId()) {
                $this->_selectedRole = $restuser->getRole()->getId();
            } elseif ($restuser->hasRoleId()) {
                $this->_selectedRole = $restuser->getRoleId();
            }
        }
        return $this->_selectedRole;
    }

    /**
     * Get REST User from registry
     *
     * @return Elidrissidev_Api2BasicAuth_Model_Restuser
     */
    protected function _getRestuser()
    {
        return Mage::registry('current_restuser');
    }

    /**
     * @inheritdoc
     */
    public function getTabLabel()
    {
        return Mage::helper('elidrissidev_api2basicauth')->__('REST Role');
    }

    /**
     * @inheritdoc
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * @inheritdoc
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/rolesGrid', ['_current' => true]);
    }
}
