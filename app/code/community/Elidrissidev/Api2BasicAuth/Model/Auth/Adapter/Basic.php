<?php

/**
 * Basic Auth Scheme Adapter
 *
 * @package Elidrissidev_Api2BasicAuth
 * @author  Mohamed ELIDRISSI <mohamed@elidrissi.dev>
 * @license https://opensource.org/licenses/MIT  MIT License
 */
class Elidrissidev_Api2BasicAuth_Model_Auth_Adapter_Basic extends Mage_Api2_Model_Auth_Adapter_Abstract
{
    /**
     * @inheritdoc
     */
    public function getUserParams(Mage_Api2_Model_Request $request)
    {
        $userParams = new stdClass;
        $userParams->id = null;
        $userParams->type = Elidrissidev_Api2BasicAuth_Model_Auth_User_Restuser::USER_TYPE;

        try {
            $authHeaderValue = $request->getHeader('Authorization');
            $authHeaderValue = substr($authHeaderValue, 6); // ignore 'Basic ' at the beginning
            $decodedValue = base64_decode($authHeaderValue);

            if ($decodedValue === false || count($credentials = explode(':', $decodedValue, 2)) < 2) {
                throw new Exception('Malformed credentials');
            }

            list($username, $password) = $credentials;

            /** @var Elidrissidev_Api2BasicAuth_Model_Restuser $restuser */
            $restuser = Mage::getModel('elidrissidev_api2basicauth/restuser')->loadByUsername($username);

            if (
                !$restuser->getId()
                || !Mage::helper('core')->validateHash($password, $restuser->getApiKey())
                || !$restuser->getIsActive()
            ) {
                throw new Exception('Invalid credentials or user not active');
            }

            $userParams->id = $restuser->getId();
        } catch (Exception $e) {
            Mage::logException($e);
            throw new Mage_Api2_Exception('Access denied', Mage_Api2_Model_Server::HTTP_UNAUTHORIZED);
        }
        return $userParams;
    }

    /**
     * @inheritdoc
     */
    public function isApplicableToRequest(Mage_Api2_Model_Request $request)
    {
        $authHeaderValue = $request->getHeader('Authorization');

        return $authHeaderValue && 'basic' === strtolower(substr($authHeaderValue, 0, 5));
    }
}
