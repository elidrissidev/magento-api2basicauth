<?php

/**
 * REST User Edit General Tab
 *
 * @package Elidrissidev_Api2BasicAuth
 * @author  Mohamed ELIDRISSI <mohamed@elidrissi.dev>
 * @license https://opensource.org/licenses/MIT  MIT License
 */
class Elidrissidev_Api2BasicAuth_Block_Adminhtml_Restuser_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('restuser_section_general');
    }

    /**
     * @inheritdoc
     */
    protected function _prepareForm()
    {
        /** @var Elidrissidev_Api2BasicAuth_Model_Restuser $restuser */
        $restuser = Mage::registry('current_restuser');

        $form = new Varien_Data_Form;

        $fieldset = $form->addFieldset('api2basicauth_restuser_general_form', [
            'legend' => $this->__('General')
        ]);

        if ($restuser->getId()) {
            $fieldset->addField('entity_id', 'hidden', [
                'name'  => 'entity_id',
                'value' => $restuser->getId()
            ]);
        }

        $fieldset->addField('username', 'text', [
            'label'    => $this->__('Username'),
            'class'    => 'required-entry validate-length maximum-length-40',
            'name'     => 'username',
            'required' => true,
            'value'    => $restuser->getUsername()
        ]);
        $fieldset->addField('current_password', 'password', [
            'label'    => Mage::helper('adminhtml')->__('Current Admin Password'),
            'class'    => 'required-entry',
            'name'     => 'current_password',
            'required' => true
        ]);

        if ($restuser->getId()) {
            $fieldset->addField('new_api_key', 'password', [
                'label'    => $this->__('New Api Key'),
                'class'    => 'validate-length minimum-length-8',
                'name'     => 'new_api_key',
                'note'     => $this->__('Api Key must be at least %d characters long.', Elidrissidev_Api2BasicAuth_Model_Restuser::MIN_API_KEY_LENGTH),
                'required' => false
            ]);
        } else {
            $fieldset->addField('api_key', 'password', [
                'label'    => $this->__('Api Key'),
                'class'    => 'validate-length minimum-length-8',
                'name'     => 'api_key',
                'note'     => $this->__('Api Key must be at least %d characters long.', Elidrissidev_Api2BasicAuth_Model_Restuser::MIN_API_KEY_LENGTH),
                'required' => true
            ]);
        }

        $fieldset->addField('api_key_confirmation', 'password', [
            'label'    => $this->__('Confirm Api Key'),
            'class'    => $restuser->getId() ? 'validate-cnew_api_key' : 'validate-capi_key',
            'name'     => 'api_key_confirmation',
            'required' => !$restuser->getId()
        ]);
        $fieldset->addField('is_active', 'select', [
            'label'   => $this->__('Active'),
            'name'    => 'is_active',
            'options' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
            'value'   => $restuser->getIsActive(),
            'style'   => 'width: 80px'
        ]);

        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @inheritdoc
     */
    public function getTabLabel()
    {
        return $this->__('General');
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
}
