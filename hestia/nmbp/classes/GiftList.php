<?php
/**
 * Created by PhpStorm.
 * User: joshuabryant
 * Date: 10/19/18
 * Time: 10:31 AM
 */

class GiftList
{
    private $iUserID;
    private $aFamilies = array();
    private $oWPDB;
    private $sFamiliesIN;
    private $aGifts = array();

    public function __construct()
    {
        global $wpdb;
        $this->iUserID = get_current_user_id();
        $this->oWPDB = $wpdb;
        $this->setFamilies();
        $this->setGifts();
    }

    /**
     * Build the gift array for the view.
     *
     * @param array $aGifts
     *    The SQL result.
     *
     * @return void Nothing is returned.
     */
    private function buildGiftConfig($aGifts)
    {
        $aGiftsBuilder = array();
        foreach ($aGifts as $oGift) {
            $aGiftsBuilder[$oGift->family_name][$oGift->display_name][$oGift->id] = $oGift;
        }
        $this->aGifts = $aGiftsBuilder;
    }

    /**
     * Get the array of gifts for the view.
     *
     * @return array
     */
    public function getGifts()
    {
        return $this->aGifts;
    }

    /**
     * Determines which families to display for the user.
     *
     * @return void Nothing is returned.
     */
    private function setFamilies()
    {
        $sSQL = "SELECT f.id, f.name 
        FROM wp_family_relationships r 
        LEFT JOIN wp_families f on f.id = r.family_id
        WHERE r.user_id = {$this->iUserID} AND r.active = 1 AND f.active = 1;";
        $this->aFamilies = $this->oWPDB->get_results($sSQL);
        $this->setFamiliesIN();
    }

    /**
     * Helper function to build the IN clause for the SQL query.
     *
     * @return void Nothing is returned.
     */
    private function setFamiliesIN()
    {
        $sIN = 'IN (';
        foreach ($this->aFamilies as $oFamily) {
            $sIN .= $oFamily->id . ',';
        }
        $sIN = rtrim($sIN, ',') . ')';
        $this->sFamiliesIN = $sIN;
    }

    /**
     * Runs the SQL and builds the array for gift display in the view.
     *
     * @return void Nothing is returned.
     */
    private function setGifts()
    {
        $sSQL = "SELECT g.*, u.display_name, f.name as 'family_name', f.id as 'family_id'
                FROM wp_gift g 
                LEFT JOIN wp_family_relationships r ON g.user_id = r.user_id
                LEFT JOIN wp_users u ON r.user_id = u.ID
                LEFT JOIN wp_families f on r.family_id = f.id
                WHERE r.family_id {$this->sFamiliesIN} AND r.active = 1 AND f.active = 1;";
        $aGiftResults = $this->oWPDB->get_results($sSQL);
        $this->buildGiftConfig($aGiftResults);
    }

    /**
     * Return the gifts for everyone to see!
     *
     * @return array
     */
    public function getFamilies()
    {
        return $this->aFamilies;
    }
}