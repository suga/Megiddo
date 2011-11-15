<?php
/**
 * I18n class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 30/03/2010
 * Class responsible for internationalization
 * Last revision : 30/03/2010
 */
class I18n {

	/**
	 * Performs the translation
	 * @param String $tag
	 * @param String $culture
	 * @return String
	 */
    public static function translate($tag, $culture = null) {
    	$objCulture = new Culture();
        $culture = $objCulture->checkCulture($culture);
        $arrayXml = I18nXml::read($culture);
        $count = count($arrayXml);
        for ($i = 0; $i < $count; $i++) {
            if ($arrayXml[$i]->tag == $tag) {
                return $arrayXml[$i]->i18n;
            }
        }
        
        return $tag;
    }
    
}
