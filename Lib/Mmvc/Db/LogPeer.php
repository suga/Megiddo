<?php
/**
 * Log class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 10/12/2009
 * Class responsible for bringing the log information database
 * Last revision : 13/02/2010
 */
class LogPeer {

    private $id;

    private $date;

    private $file;

    private $message;

    private $isError;
    
    const TABLE = 'log';
    const ID = 'id';
    const DATE = 'date';
    const FILE = 'file';
    const MESSAGE = 'message';
    const IS_ERROR = 'is_error';

    //Methods Set
    

    /**
     * 
     * @param integer $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @var $date = 0000/00/00 00:00:00
     * @param string $date
     */
    public function setDate($date) {
        $this->date = $date;
    }

    /**
     * 
     * @param string $file
     */
    public function setFile($file) {
        $this->file = $file;
    }

    /**
     * 
     * @param string $message
     */
    public function setMessage($message) {
        $this->message = $message;
    }

    /**
     * 
     * @param boolean $isError
     */
    public function setIsError($isError) {
        $this->isError = $isError;
    }

    //Methods get
    

    /**
     * Retrieves the ID
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Retrieves the Date
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Retrieves the File
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * Retrieves the Message
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * Retrieves has Error
     */
    public function getIsError() {
        return $this->isError;
    }

    /**
     * Returns information from the database
     * @param Criteria $criteria
     * @return Array
     */
    public function doSelect(Criteria $criteria) {
        $sql = new Sql();
        $stdClass = $sql->select($criteria, self::TABLE);
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

    /**
     * Save Log
     * @return bollean
     */
    public function save() {
        $data = array(self::ID => self::getId(), self::DATE => self::getDate(), self::FILE => self::getFile(), self::MESSAGE => self::getMessage(), self::IS_ERROR => self::getIsError());
        $sql = new Sql();
        
        if (is_null($this->getId())) {
            $sql->insert($data, self::TABLE);
            $this->id = $sql->lastRow(self::TABLE)->id;
            return true;
        } else {
            $pk = array(self::ID => self::getId());
            
            return $sql->update($data, self::TABLE, $pk);
        }
    
    }

    /**
     * Delete Log
     * @return bollean
     */
    public function delete() {
        $pk = array(self::ID => $this->getId());
        
        $sql = new Sql();
        return $sql->delete(self::TABLE, $pk);
    }

    /**
     * Converts the object to the object class
     * @param stdClass $stdClass
     * @return object
     */
    private function ConvertingObject(stdClass $stdClass) {
        $ObjLogPeer = new Log();
        $ObjLogPeer->setId($stdClass->id);
        $ObjLogPeer->setDate($stdClass->date);
        $ObjLogPeer->setFile($stdClass->file);
        $ObjLogPeer->setMessage($stdClass->message);
        $ObjLogPeer->setIsError($stdClass->is_error);
        return $ObjLogPeer;
    }

    /**
     * Converts the object to the object class 
     * @param $arrayStdClass
     * @return ArrayObject
     */
    private function ConvertingArrayObject(ArrayObject $arrayStdClass) {
        $logPeer = new ArrayObject();
        foreach ($arrayStdClass as $key => $objStdClass) {
            $obj = $this->ConvertingObject($objStdClass);
            $logPeer[] = $obj;
        }
        return $logPeer;
    }

}
