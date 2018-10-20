<?php

/**
 * Class AddUser
 */
class AddUser
{
    public $aPostData;
    public $iExistingUser;
    public $iAddFamilyRelationship;
    public $vAddFamilyUsername;
    public $vAddFamilyEmail;
    public $iAddFamilyRelationshipNew;
    public $bSuccessful = false;
    public $sResponseMessage = 'No response.';
    public $iLicenseID;

    public function __construct($aPostData)
    {
        $this->aPostData = $aPostData;
        $this->setVariables();
        $this->perform();
    }

    /**
     * Adds a family member relationship from wp_users to wp_families
     *
     * @param int $iUserID
     * @param int $iFamilyID
     *
     * @return void Nothing is returned.
     */
    private function addToFamily($iUserID, $iFamilyID)
    {
        // @Todo: Add a check to make sure the user does not already exist in the family.
        global $wpdb;
        $data = array(
            'user_id' => $iUserID,
            'family_id' => $iFamilyID,
            'active' => 1,
        );
        $wpdb->insert('wp_family_relationships', $data);
    }

    /**
     * Creates a WP user.
     *
     * @param string $sUsername
     *    The username to be added.
     * @param string $sEmail
     *    The email to be added.
     *
     * @return int|object Returns user_id on success, WP Error Object on failure.
     */
    private function createUser($sUsername, $sEmail)
    {
        return wp_create_user($sUsername, 'default', $sEmail);
    }

    /**
     * The main perform method.
     * 1. Checks to make sure the license is available
     * 2. Adds or creates a user.
     * 3. Removes the license
     *
     * @return void Nothing is returned.
     */
    private function perform()
    {
        // Stop execution if there are no more licenses available.
        if ($this->iLicenseID === 0) {
            $this->setResponse('You do not have any more licenses. Sorry!');
            return;
        }

        // Determine what we are trying to do.
        if ($this->iExistingUser != 0 && $this->iAddFamilyRelationship != 0) {
            $this->addToFamily($this->iExistingUser, $this->iAddFamilyRelationship);
            $this->setSuccess(true);
            $oUserData = get_userdata($this->iExistingUser);
            $this->setResponse('The user "' . $oUserData->display_name . '" has been added to your family.');
        } elseif ($this->vAddFamilyUsername !== 0 && $this->vAddFamilyEmail !== 0 && $this->iAddFamilyRelationshipNew !== 0) {
            $iUserID = $this->createUser($this->vAddFamilyUsername, $this->vAddFamilyEmail);
            if (is_wp_error($iUserID)) {
                $this->setResponse('There was an error. The username or email may already exist.');
            } else {
                $this->addToFamily($iUserID, $this->iAddFamilyRelationshipNew);
                $sMessage = 'The user has been added to your family. ';
                $sMessage .= 'Their temporary password will be "default". Please update this password upon first login.';
                $this->setSuccess(true);
                $this->setResponse($sMessage);
            }
        } else {
            $this->setResponse('Something went wrong. Go back and try that form again, partner.');
        }

        // Remove license.
        $this->removeLicense();
    }

    /**
     * @return string
     */
    public function getResponse()
    {
        return $this->sResponseMessage;
    }

    /**
     * @return int
     */
    public function getLicenseID()
    {
        return $this->iLicenseID;
    }

    /**
     * @return bool
     */
    public function getSuccess()
    {
        return $this->bSuccessful;
    }

    /**
     * Updates the wp_family_license table to remove a license.
     *
     * @return void Nothing is returned.
     */
    private function removeLicense()
    {
        if ($this->getSuccess() === true) {
            global $wpdb;
            $iLicenseID = $this->getLicenseID();
            $update = array('available' => 0);
            $where = array ('id' => $iLicenseID);
            $wpdb->update('wp_family_license', $update, $where);
        }
    }

    /**
     * Sets the license to use for this interaction. License is 0 if does not exist.
     *
     * @return void Nothing is returned.
     */
    private function setLicense()
    {
        global $wpdb;
        $sSQL = "SELECT l.id AS 'license_id' FROM wp_family_license l 
                LEFT JOIN wp_families f ON l.family_id = f.id
                WHERE f.active = 1 AND l.available = 1;";
        $aResults = $wpdb->get_results($sSQL);

        if (is_array($aResults) && isset($aResults[0]->license_id)) {
            $this->iLicenseID = $aResults[0]->license_id;
        } else {
            $this->iLicenseID = 0;
        }
    }

    /**
     * Set the response message.
     *
     * @param string $sMessage
     *
     * @return void Nothing is returned.
     */
    private function setResponse($sMessage)
    {
        $this->sResponseMessage = $sMessage;
    }

    /**
     * Set the success message.
     *
     * @param bool $bool
     *
     * @return void Nothing is returned.
     */
    private function setSuccess($bool)
    {
        $this->bSuccessful = $bool;
    }

    /**
     * Checks to see if array key exists and is not blank.
     * Returns the value if it does.
     * Returns 0 if it does not.
     *
     * This returns 0 as 0 is not a valid id for a db index.
     *
     * @param string $sKey
     *    The key to be checked.
     *
     * @return mixed
     */
    private function setValueFromArray($sKey)
    {
        if (isset($this->aPostData[$sKey]) && trim($this->aPostData[$sKey]) !== '') {
            return $this->aPostData[$sKey];
        }
        return 0;
    }

    /**
     * Sets the variables for us to play with.
     *
     * @return void Nothing is returned.
     */
    private function setVariables()
    {
        $this->iExistingUser = $this->setValueFromArray('existing_user');
        $this->iAddFamilyRelationship = $this->setValueFromArray('add_family_relationship');
        $this->vAddFamilyUsername = $this->setValueFromArray('add_family_username');
        $this->vAddFamilyEmail = $this->setValueFromArray('add_family_email');
        $this->iAddFamilyRelationshipNew = $this->setValueFromArray('add_family_relationship_new');
        $this->setLicense();
    }
}