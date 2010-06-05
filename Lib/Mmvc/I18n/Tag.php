<?php
/**
 * Tag class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 10/12/2009
 * Class responsible for Tags
 * Last revision : 13/02/2010
 */
class Tag extends TagPeer {

    private $i18n;

    /**
     * Set Tag
     * @param TagI18nPeer $objTagI18n
     */
    public function setTagI18n(TagI18nPeer  $objTagI18n) {
        $this->i18n = $objTagI18n;
    }

    /**
     * Get Obj I18n
     * @return TagI18nPeer
     */
    public function getTagI18n() {
        return $this->i18n;
    }

    /**
     * Get Translate
     * @return String
     */
    public function getI18n() {
        if(!$this->i18n instanceof TagI18nPeer){
            return false;
        }
        return $this->i18n->getTranslate();
    }

    /**
     * 
     * @param $tag
     * @param $isoLang
     */
    public static function retriveByPk($tag, $isoLang = 'pt_BR') {
        $criteria = new Criteria();
        $criteria->add(self::TABLE . self::TAG, $tag);
        $criteria->setLimit(1);
        $objTag = new Tag();
        $objTag->doSelectOne($criteria);
        
        $objTagI18n = new TagI18n();
        $tagI18n = $objTagI18n->retriveByPk($objTag->getIdTag(), $isoLang);
        if ($tagI18n instanceof TagI18nPeer) {
            $objTag->setTagI18n($tagI18n);
        }
        
        return $objTag;
    }
    
    /**
     * 
     * @param Interger $id
     */
    public function retriveByIdTag($id){
    	$criteria = new Criteria();
        $criteria->add(self::TABLE . self::ID_TAG, $id);
        $criteria->setLimit(1);
        $objTag = new Tag();
        $objTag->doSelectOne($criteria);
        return $objTag;
    }

    /**
     * 
     * @param $tag
     */
    public function setTag($tag) {
        $this->setTagName($tag);
        $this->save();
    
    }

}
