<?php
/**
 * Culture class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 30/03/2010
 * Class responsible for the System Log
 * Last revision : 30/03/2010
 */
class Culture extends CulturePeer {

	/* @var String $culture */
	private $culture;
	
	/**
	 * Culture = Isolang
	 * @param String $culture
	 */
	public function setCulture($culture){
		$culture = $this->checkCulture($culture);
		$this->culture = $culture;
	}
	
	/**
	 * @return String Culture
	 */
	public function getCulture(){
		return empty($this->culture) ? self::retriveDefaultCulture() : $this->culture;
	}
	
	
    /**
     * @return ArrayObject
     */
    public function getAllCultures() {
        $criteria = new Criteria();
        $criteria->addNotWhere();
        $objCulture = $this->doSelect($criteria);
        return $objCulture;
    }

    /**
     * 
     * @param $isoLang
     * @return boollean
     */
    public function hasCulture($isoLang) {
        $has = CulturePeer::hasCulture($isoLang);
        return $has;
    }

    /**
     * Checks if culture is a valid
     * @param $isolang
     * @return String $isolang
     */
    public function checkCulture($isolang) {
        $obj = $this->hasCulture($isolang);
        if (!$obj) {
            return self::retriveDefaultCulture();
        }
        
        return $isolang;
    }
    
    /**
     * Returns array of languages
     * @return array
     */
    public function returnArrayLanguages(){       
        $arrayObjetc = $this->getAllCultures();
        $arrayLanguages = array();
        /* @var $obj Culture */
        foreach($arrayObjetc as $obj){
           $arrayLanguages[$obj->getIsoLang()] = $obj->getDefault();
        }
        return $arrayLanguages;
    }

}
