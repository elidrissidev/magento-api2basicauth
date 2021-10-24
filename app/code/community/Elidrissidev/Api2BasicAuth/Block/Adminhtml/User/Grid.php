<?php

/**
 * Api2 User Grid
 * 
 * @author  Mohamed ELIDRISSI
 * @package Elidrissidev_Api2BasicAuth
 */
class Elidrissidev_Api2BasicAuth_Block_Adminhtml_User_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('api2UsersGrid');
    }

    /**
     * @inheritdoc
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('elidrissidev_api2basicauth/user_collection');
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @inheritdoc
     */
    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header' => $this->__('ID'),
            'index'  => 'entity_id',
            'type'   => 'number',
            'width'  => '50px'
        ));
        $this->addColumn('username', array(
            'header' => $this->__('Username'),
            'index'  => 'username'
        ));
        $this->addColumn('is_active', array(
            'header' => $this->__('Active'),
            'index'  => 'is_active',
            'type'   => 'options',
            'options' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray()
        ));

        return parent::_prepareColumns();
    }

    /**
     * @param Elidrissidev_Api2BasicAuth_Model_User $item
     * @inheritdoc
     */
    public function getRowUrl($item)
    {
        return $this->getUrl('*/*/edit', array('id' => $item->getId()));
    }
}
