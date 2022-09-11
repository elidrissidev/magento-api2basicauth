<?php

/**
 * REST User Edit Form
 *
 * @package Elidrissidev_Api2BasicAuth
 * @author  Mohamed ELIDRISSI <mohamed@elidrissi.dev>
 * @license https://opensource.org/licenses/MIT  MIT License
 */
class Elidrissidev_Api2BasicAuth_Block_Adminhtml_Restuser_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * @inheritdoc
     */
    protected function _prepareForm()
    {
        /** @var Elidrissidev_Api2BasicAuth_Model_Restuser $restuser */
        $restuser = Mage::registry('current_restuser');

        $params = $restuser->getId() ? ['id' => $restuser->getId()] : [];

        $form = new Varien_Data_Form([
            'id'     => 'edit_form',
            'action' => $this->getUrl('*/*/save', $params),
            'method' => 'post'
        ]);
        $form->setUseContainer(true);

        $this->setForm($form);

        return parent::_prepareForm();
    }
}
