<?php
/**
 * TagI18n class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 27/03/2010
 * Class responsible for the System Log
 * Last revision : 27/03/2010
 */
class TagI18n extends TagI18nPeer {

		
    /**
     * Returns the log for the primary key
     * @param interger $idLog
     * @param string $isoLang
     * @return Object
     */
    public static function retriveByPk($idTag,$isoLang = 'pt_BR')  {
        $criteria = new Criteria();
        $criteria->add(self::TABLE . self::ID_TAG, $idTag);
        $criteria->add(self::TABLE . self::ISOLANG, $isoLang);
        $criteria->setLimit(1);
        $objTagI18n = new TagI18n();
        return $objTagI18n->doSelectOne($criteria);
    }

    
    /**
     * Save translate tags
     * @param integer $idTag
     * @param string $isoLang
     * @param string $translate
     */
    public function setTagI18n($idTag, $isoLang, $translate) {
        $this->setIdTag($idTag);
        $this->setIsoLang($isoLang);
        $this->setTranslate($translate);
        $this->save();
    
    }

}
