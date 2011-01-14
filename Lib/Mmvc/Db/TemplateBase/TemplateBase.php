<?php
/**
 * Base - [%doc%]
 * @author Mmvc - Base Criator
 * @version [%date%]
 */

class [%nameClass%] extends AbstractBase implements Base {

    /**
     * @var string
     */
    const TABLE = '[%table%]';    
    [%consts%]
    
    [%privates%]
    
    [%sets%]
    
    [%gets%]
    
    /**
     * Returns information from the database
     * @param Criteria $criteria
     * @return Array
     */
    public function doSelect(Criteria $criteria) {
        $sql = new Sql();
        $stdClass = $sql->select($criteria, self::TABLE, false);
        return !$stdClass ? false : $this->ConvertingArrayObject($stdClass);
    }

    /**
     * Returns only one information database
     * @param Criteria $criteria
     * @return ArrayObject
     */
    public function doSelectOne(Criteria $criteria) {
        $sql = new Sql();
        $stdClass = $sql->select($criteria, self::TABLE, true);
        return !$stdClass ? false : $this->ConvertingObject($stdClass);
    }
    
    [%save%]
    
    [%delete%]
    
    [%ConvertingObject%]
    
    /**
     * Converts the object to the object class 
     * @param $arrayStdClass
     * @return ArrayObject
     */
    private function ConvertingArrayObject(ArrayObject $arrayStdClass) {
        $peer = new ArrayObject();
        foreach ($arrayStdClass as $key => $objStdClass) {
            $obj = $this->ConvertingObject($objStdClass);
            $peer[] = $obj;
        }
        return $peer;
    }
    
    
    [%retrive%]
    
    /**
     * Retrive total Records
     */
    public static function getTotalRecords($criteria = null) {
        $sql = new Sql();
        $stdClass = $sql->count(self::TABLE, $criteria);
        return $stdClass->total_records;
    }
    
    [%validates%]
}    