<?php
/**
 * Culture class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 30/03/2010
 * Last revision : 30/03/2010
 */
class CulturePeer {

    private $isolang;

    private $default;
    
    const TABLE = 'culture';
    const ISOLANG = 'isolang';
    const DEFAULT_CULTURE = '"default"';

    //Methods Set
    

    /**
     * 
     * @param String $id
     */
    public function setIsoLang($isolang) {
        $this->isolang = $isolang;
    }

    /**
     * 
     * @param Boollean $default
     */
    public function setDefault($default) {
        $this->default = $default;
    }

    //Methods get
    

    /**
     * Retrieves the ISO-CULTURE
     */
    public function getIsoLang() {
        return $this->isolang;
    }

    /**
     * checks if it is set a default value
     */
    public function hasDefault() {
        if (empty($this->default)) {
            return false;
        }
        return true;
    }

    /**
     * Gets the default value
     */
    public function getDefault() {
        return (int)$this->default;
    }

    /**
     * Returns information from the database
     * @param Criteria $criteria
     * @return Array
     */
    public function doSelect(Criteria $criteria) {
        $sql = new Sql();
        $stdClass = $sql->select($criteria, self::TABLE);
        return !$stdClass ? false : self::ConvertingArrayObject($stdClass);
    }

    /**
     * Returns only one information database
     * @param Criteria $criteria
     * @return ArrayObject
     */
    public function doSelectOne(Criteria $criteria) {
        $sql = new Sql();
        $stdClass = $sql->select($criteria, self::TABLE, true);
        return !$stdClass ? false : self::ConvertingObject($stdClass);
    }

    /**
     * Save 
     * @return bollean
     */
    public function save() {
        $data = array(self::ISOLANG => $this->getIsoLang(), self::DEFAULT_CULTURE => $this->getDefault());
        $sql = new Sql();
        
        if (!self::hasCulture($this->getIsoLang())) {
            $sql->insert($data, self::TABLE);
            $this->isolang = $sql->lastRow(self::TABLE)->isolang;
            return true;
        } else {
            $pk = array(self::ISOLANG => $this->getIsoLang());
            
            return $sql->update($data, self::TABLE, $pk);
        }
    
    }

    /**
     * Delete 
     * @return bollean
     */
    public function delete() {
        $pk = array(self::ISOLANG => $this->getIsoLang());
        $sql = new Sql();
        return $sql->delete(self::TABLE, $pk);
    }

    /**
     * Converts the object to the object class
     * @param stdClass $stdClass
     * @return object
     */
    private function ConvertingObject(stdClass $stdClass) {
        $ObjPeer = new Culture();
        $ObjPeer->setIsoLang($stdClass->isolang);
        $ObjPeer->setDefault((boolean)$stdClass->default);
        return $ObjPeer;
    }

    /**
     * Converts the object to the object class 
     * @param $arrayStdClass
     * @return ArrayObject
     */
    private function ConvertingArrayObject(ArrayObject $arrayStdClass) {
        $peer = new ArrayObject();
        foreach ($arrayStdClass as $key => $objStdClass) {
            $obj = self::ConvertingObject($objStdClass);
            $peer[] = $obj;
        }
        return $peer;
    }

    /**
     * IsoLang Default System
     * @return String
     */
    public static function retriveDefaultCulture() {
        $criteria = new Criteria();
        $criteria->add(self::DEFAULT_CULTURE, true);
        $criteria->setLimit(1);
        $obj = self::doSelectOne($criteria);
        
        if (!$obj instanceof Culture) {
            return 'pt_BR';
        }
        
        return $obj->getIsoLang();
    }

    /**
     * 
     * @param $isoLang
     */
    public static function retriveByPk($isoLang = 'pt_BR') {
        $criteria = new Criteria();
        $criteria->add(self::ISOLANG, $isoLang);
        $criteria->setLimit(1);
        $obj = self::doSelectOne($criteria);
        
        return $obj;
    }
    
    /**
     * 
     * @param $isoLang
     * @return boollean
     */
    public function hasCulture($isoLang) {
        if (empty($isoLang)) {
            return false;
        }
        
        $obj = self::retriveByPk($isoLang);
        if (!$obj instanceof Culture) {
            return false;
        }
        return true;
    }

}
