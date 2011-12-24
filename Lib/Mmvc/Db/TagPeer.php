<?php
/**
 * Tag class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 25/03/2010
 * Last revision : 25/03/2010
 */
class TagPeer {

    private $idTag;

    private $tag;
    
    const TABLE = 'tag';
    const ID_TAG = 'id_tag';
    const TAG = 'tag';

    //Methods Set
    

    /**
     * 
     * @param integer $id
     */
    public function setIdTag($id) {
        $this->idTag = $id;
    }

    /**
     * 
     * @param string $tag
     */
    public function setTagName($tag) {
        $this->tag = $tag;
    }

    //Methods get
    

    /**
     * Retrieves the ID
     */
    public function getIdTag() {
        return $this->idTag;
    }

    /**
     * Retrieves the Date
     */
    public function getTag() {
        return $this->tag;
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
     * Save Tag
     * @return bollean
     */
    public function save() {
        $data = array(self::ID_TAG => $this->getIdTag(), self::TAG => $this->getTag());
        $sql = new Sql();
        
        if (is_null($this->getIdTag())) {
            $sql->insert($data, self::TABLE);
            $this->idTag = $sql->lastRow(self::TABLE)->id_tag;
            return true;
        } else {
            $pk = array(self::ID_TAG => $this->getIdTag());
            
            return $sql->update($data, self::TABLE, $pk);
        }
    
    }

    /**
     * Delete Tag
     * @return bollean
     */
    public function delete() {
        $pk = array(self::ID_TAG => $this->getIdTag());
        $sql = new Sql();
        return $sql->delete(self::TABLE, $pk);
    }

    /**
     * Converts the object to the object class
     * @param stdClass $stdClass
     * @return object
     */
    private function ConvertingObject(stdClass $stdClass) {
        $ObjTagPeer = $this;
        $ObjTagPeer->setIdTag($stdClass->id_tag);
        $ObjTagPeer->setTagName($stdClass->tag);
        return $ObjTagPeer;
    }

    /**
     * Converts the object to the object class 
     * @param $arrayStdClass
     * @return ArrayObject
     */
    private function ConvertingArrayObject(ArrayObject $arrayStdClass) {
        $tagPeer = new ArrayObject();
        foreach ($arrayStdClass as $key => $objStdClass) {
            $obj = $this->ConvertingObject($objStdClass);
            $tagPeer[] = $obj;
        }
        return $tagPeer;
    }

}
