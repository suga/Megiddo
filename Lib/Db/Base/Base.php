<?php
/**
 * Class responsible for the control of the bases
 * @author Marco Antonio Sugamele
 * @version 01 Ago 2010
 */
interface Base {
    
    /**
     * Returns information from the database
     * @param Criteria $criteria
     * @return Array
     */
    public function doSelect(Criteria $criteria);
    
    /**
     * Returns only one information database
     * @param Criteria $criteria
     * @return ArrayObject
     */
     public function doSelectOne(Criteria $criteria);
     
     /**
     * Save or edit the information in the Database
     * @return bollean
     */
    public function save();
    
    /**
     * Delete the information in the Database
     * @return bollean
     */
    public function delete();
    
    /**
     * Returns the for the primary key
     * @param interger $idPermissions
     * @return Object
     */
    public static function retriveByPk($idPermission);
    
    /**
     * Retrive total Records
     */
    public static function getTotalRecords(Criteria $criteria = null);
}