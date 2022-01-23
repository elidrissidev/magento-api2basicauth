<?php

/**
 * REST User Controller
 *
 * @package Elidrissidev_Api2BasicAuth
 * @author  Mohamed ELIDRISSI <mohamed@elidrissi.dev>
 * @license https://opensource.org/licenses/MIT  MIT License
 */
class Elidrissidev_Api2BasicAuth_Adminhtml_Api2basicauth_RestuserController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init active menu and page title
     *
     * @return $this
     */
    protected function _initAction()
    {
        $this->_setActiveMenu('system/api/rest_users')
            ->_title(Mage::helper('adminhtml')->__('System'))
            ->_title(Mage::helper('adminhtml')->__('Web Services'))
            ->_title($this->__('REST Users'));

        return $this;
    }

    /**
     * Display users grid
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_initAction()->renderLayout();
    }

    /**
     * Display new user form
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * Display edit form
     */
    public function editAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        $restuser = Mage::getModel('elidrissidev_api2basicauth/restuser');

        if ($id) {
            $restuser->load($id);

            if (!$restuser->getId()) {
                $this->_getSession()->unsRestuserData();
                $this->_getSession()->addError($this->__('This user no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        } else {
            $data = $this->_getSession()->getRestuserData();
            if (!empty($data)) {
                $restuser->setData($data);
                $this->_getSession()->unsRestuserData();
            }
        }

        Mage::register('current_restuser', $restuser);

        $this->loadLayout();
        $this->_initAction()
            ->_title($restuser->getId() ? $this->__('Edit User') : $this->__('New User'))
            ->renderLayout();
    }

    /**
     * Save user
     */
    public function saveAction()
    {
        $id       = (int) $this->getRequest()->getParam('id');
        $back     = $this->getRequest()->getParam('back', false);
        $postData = $this->getRequest()->getPost();

        if (!$postData) {
            $this->_redirect('*/*/');
            return;
        }

        $currentPassword = $this->getRequest()->getPost('current_password');
        $this->getRequest()->setParam('current_password', null);
        unset($postData['current_password']);

        if (isset($postData['api_key']) && $postData['api_key'] === '') {
            unset($postData['api_key']);
        }
        if (isset($postData['new_api_key']) && $postData['new_api_key'] === '') {
            unset($postData['new_api_key']);
        }
        if (isset($postData['api_key_confirmation']) && $postData['api_key_confirmation'] === '') {
            unset($postData['api_key_confirmation']);
        }

        /** @var Elidrissidev_Api2BasicAuth_Model_Restuser $restuser */
        $restuser = Mage::getModel('elidrissidev_api2basicauth/restuser');

        if ($id) {
            $restuser->load($id);
        }

        $restuser->setData($postData);

        $validationResult = $this->_validateCurrentPassword($currentPassword);

        if (!is_array($validationResult)) {
            $validationResult = $restuser->validate();
        }

        if (is_array($validationResult)) {
            $this->_getSession()->setRestuserData($postData);

            foreach ($validationResult as $error) {
                $this->_getSession()->addError($error);
            }

            if ($id) {
                $this->_redirect('*/*/edit', array('id' => $id));
            } else {
                $this->_redirect('*/*/new');
            }
            return;
        }

        try {
            $restuser->save();

            $this->_getSession()->unsRestuserData();
            $this->_getSession()->addSuccess($this->__('The user has been saved.'));

            if ($back) {
                $this->_redirect('*/*/edit', array('id' => $id));
            } else {
                $this->_redirect('*/*/');
            }
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->setRestuserData($postData);
            $this->_getSession()->addError($e->getMessage());
            $this->_redirect('*/*/edit', array('id' => $id));
            return;
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->setRestuserData($postData);
            $this->_getSession()->addError($this->__('An error occurred while saving user.'));
            $this->_redirect('*/*/edit', array('id' => $id));
            return;
        }
    }

    /**
     * Render users grid
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Delete user
     */
    public function deleteAction()
    {
        $id = (int) $this->getRequest()->getParam('id');

        if (!$id) {
            $this->_redirect('*/*/');
            return;
        }

        $restuser = Mage::getModel('elidrissidev_api2basicauth/restuser')->load($id);

        if (!$restuser->getId()) {
            $this->_getSession()->addError($this->__('This user no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }

        try {
            $restuser->delete();

            $this->_getSession()->addSuccess($this->__('The user has been deleted.'));
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
            $this->_redirect('*/*/edit', array('id' => $id));
            return;
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($this->__('An error occurred while saving user.'));
            $this->_redirect('*/*/edit', array('id' => $id));
            return;
        }

        $this->_redirect('*/*/');
    }

    public function rolesGridAction()
    {
        $id = $this->getRequest()->getParam('id');
        $restuser = Mage::getModel('elidrissidev_api2basicauth/restuser')->load($id);

        Mage::register('current_restuser', $restuser);

        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * @inheritdoc
     */
    protected function _isAllowed()
    {
        $action = strtolower($this->getRequest()->getActionName());

        switch ($action) {
            case 'new':
                $aclResource = 'system/api/rest_users/create';
                break;
            case 'edit':
                $aclResource = 'system/api/rest_users/edit';
                break;
            default:
                $aclResource = 'system/api/rest_users';
        }

        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }
}
