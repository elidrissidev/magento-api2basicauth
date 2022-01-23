<?php

/**
 * REST Users Grid
 *
 * @package Elidrissidev_Api2BasicAuth
 * @author  Mohamed ELIDRISSI <mohamed@elidrissi.dev>
 * @license https://opensource.org/licenses/MIT  MIT License
 */
class Elidrissidev_Api2BasicAuth_Block_Adminhtml_Restuser_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('restusersGrid');
        $this->setUseAjax(true);
    }

    /**
     * @inheritdoc
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('elidrissidev_api2basicauth/restuser_collection');
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
            'header'  => $this->__('Active'),
            'index'   => 'is_active',
            'type'    => 'options',
            'options' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray()
        ));

        return parent::_prepareColumns();
    }

    /**
     * @param Elidrissidev_Api2BasicAuth_Model_Restuser $item
     * @inheritdoc
     */
    public function getRowUrl($item)
    {
        if (!Mage::getSingleton('admin/session')->isAllowed('system/api/rest_users/edit')) {
            return '';
        }
        return $this->getUrl('*/*/edit', array('id' => $item->getId()));
    }

    /**
     * @inheritdoc
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid');
    }
}
