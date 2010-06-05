<?php
/**
 * Content class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 30/03/2010
 * Class responsible for storing the content of other classes or parameters passed
 * Last revision : 30/03/2010
 */
class Content {

    /**
     * @var boolean $hasLayout
     */
    private $hasLayout = true;

    /**
     * @var String $typeLayout
     */
    private $typeLayout = '';

    /**
     * @var String $culture
     */
    private $culture;

    /**
     * @var Array $attribute
     */
    private $attribute = array();

    /**
     * @var Array $attributeFlush
     */
    private $attributeFlush = array();

    private $InformationLoad = array();

    /**
     * 
     * @var Template $template
     */
    private $template;

    /**
     * Arrow if action has layout
     * @param String $viewAction
     */
    public function setHasLayout($viewAction) {
        switch ($viewAction) {
            case ViewActions::VIEW_ERROR :
            case ViewActions::VIEW_SUCCESS :
                $this->hasLayout = true;
                break;
            case ViewActions::VIEW_NONE :
                $this->hasLayout = false;
                break;
            default :
                $this->hasLayout = true;
                break;
        }
    }

    /**
     * returns to action has layout
     * @return boolean
     */
    public function hasLayout() {
        return $this->hasLayout;
    }

    /**
     * Set type Layout
     * @param String $viewAction
     * @return String
     */
    public function typeLayout($viewAction) {
        if ($viewAction == ViewActions::VIEW_ERROR) {
            $this->typeLayout = ViewActions::VIEW_ERROR;
        }
    }

    /**
     * Returns type Lyout
     * @return String
     */
    public function getTypeLayout() {
        return $this->typeLayout;
    }

    /**
     * @param Culture $objCulture
     */
    public function setCulture(Culture $objCulture) {
        $this->culture = $objCulture;
    }

    /**
     * @return Culture
     */
    public function getObjCulture() {
        if (!$this->culture instanceof Culture) {
            $this->culture = new Culture();
        }
        return $this->culture;
    }

    /**
     * Sets values that are stored prior to being caught in any module and action
     * @param String $nameAttribute
     * @param String $valueAttribute
     */
    public function setAttribute($nameAttribute, $valueAttribute = null) {
        if (empty($nameAttribute)) {
            return false;
        }
        $this->attribute[$nameAttribute] = $valueAttribute;
    }

    /**
     * Get values that are stored prior to being caught in any module and action
     * @param String $nameAttribute
     * @return String
     */
    public function getAttribute($nameAttribute) {
        if (!array_key_exists($nameAttribute, $this->attribute)) {
            return null;
        }
        return $this->attribute[$nameAttribute];
    }

    /**
     * Sets values that are stored prior to being caught in any module and action temporarily before being captured
     * @param String $nameAttribute
     * @param String $valueAttribute
     */
    public function setFlush($nameAttribute, $valueAttribute = null) {
        if (empty($nameAttribute)) {
            return false;
        }
        $this->attributeFlush[$nameAttribute] = $valueAttribute;
    }

    /**
     * Get values that are stored prior to being caught in any module and action temporarily before being captured
     * @param String $nameAttribute
     * @return String
     */
    public function getFlush($nameAttribute) {
        if (!array_key_exists($nameAttribute, $this->attributeFlush)) {
            return null;
        }
        
        $value = $this->attributeFlush[$nameAttribute];
        $this->attributeFlush[$nameAttribute] = null;
        
        return $value;
    }

    /**
     * @param Template $objTemplate
     */
    public function setTemplate(Template $objTemplate) {
        $this->template = $objTemplate;
    }

    /**
     * @return Template
     */
    public function getObjTemplate() {
        if (!$this->template instanceof Template) {
            $this->template = new Template();
        }
        return $this->template;
    }

    /**
     * Sets the information load
     * @param array $arrayLoad
     */
    public function setInformationLoad(array $arrayLoad) {
        $this->InformationLoad = $arrayLoad;
    }

    /**
     * Get the information load
     * @return array
     */
    public function getInformationLoad() {
        return $this->InformationLoad;
    }

}