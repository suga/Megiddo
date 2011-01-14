<?php
/**
 * TagI18n class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 27/03/2010
 * Last revision : 27/03/2010
 */
class TagI18nPeer {

    private $idTagI18n;

    private $idTag;

    private $isoLang;

    private $translate;

    private $tag;
    
    const TABLE = 'tag_i18n';
    const ID_TAG_I18N = 'id_tag_i18n';
    const ID_TAG = 'id_tag';
    const ISOLANG = 'isolang';
    const TRANSLATE = 'text';

    //Methods Set
    

    /**
     * 
     * @param $tag
     */
    public function setTag($tag) {
        $this->tag = !empty($tag) ? $tag : null;
    }

    /**
     * 
     * @param integer $idTagI18n
     */
    public function setIdTagI18n($idTagI18n) {
        $this->idTagI18n = $idTagI18n;
    }

    /**
     * 
     * @param integer $id
     */
    public function setIdTag($id) {
        $this->idTag = $id;
    }

    /**
     * 
     * @param string $isoLang
     */
    public function setIsoLang($isoLang) {
        $this->isoLang = $isoLang;
    }

    /**
     * 
     * @param String $translate
     */
    public function setTranslate($translate) {
        $this->translate = $translate;
    }

    //Methods get
    

    public function getTag() {
        return $this->tag;
    }

    /**
     * Retrieves the ID
     */
    public function getIdTagI18n() {
        return $this->idTagI18n;
    }

    /**
     * Retrieves the ID
     */
    public function getIdTag() {
        return $this->idTag;
    }

    /**
     * Retrieves the isolang
     */
    public function getIsoLang() {
        return $this->isoLang;
    }

    /**
     * Retrives the translate tag
     */
    public function getTranslate() {
        return $this->translate;
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
        $data = array(self::ID_TAG_I18N => $this->getIdTagI18n(), self::ID_TAG => $this->getIdTag(), self::ISOLANG, self::TRANSLATE);
        $sql = new Sql();
        
        if (is_null($this->getIdTagI18n())) {
            $sql->insert($data, self::TABLE);
            $this->idTagI18n = $sql->lastRow(self::TABLE)->id_tag_i18n;
            $this->idTag = $sql->lastRow(self::TABLE)->id_tag;
            return true;
        } else {
            $pk = array(self::ID_TAG_I18N => $this->getIdTagI18n());
            
            return $sql->update($data, self::TABLE, $pk);
        }
    
    }

    /**
     * Delete Tag
     * @return bollean
     */
    public function delete() {
        $pk = array(self::ID_TAG_I18N => $this->getIdTagI18n());
        $sql = new Sql();
        return $sql->delete(self::TABLE, $pk);
    }

    /**
     * Converts the object to the object class
     * @param stdClass $stdClass
     * @return object
     */
    private function ConvertingObject(stdClass $stdClass) {
        $ObjTagI18nPeer = new TagI18nPeer();
        $ObjTagI18nPeer->setIdTagI18n($stdClass->id_tag_i18n);
        $ObjTagI18nPeer->setIdTag($stdClass->id_tag);
        $ObjTagI18nPeer->setIsoLang($stdClass->isolang);
        $ObjTagI18nPeer->setTranslate($stdClass->translate);
        
        $tag = new Tag();
        /*@var $objTag Tag */
        $objTag = $tag->retriveByIdTag($stdClass->id_tag);
        $ObjTagI18nPeer->setTag($objTag->getTag());
        return $ObjTagI18nPeer;
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
