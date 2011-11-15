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
    private $attributeFlash = array();

    /**
     * @var Array $informationLoad
     */
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
    public function setFlash($nameAttribute, $valueAttribute = null) {
        if (empty($nameAttribute)) {
            return false;
        }
        $this->attributeFlash[$nameAttribute] = $valueAttribute;
    }

    /**
     * Get values that are stored prior to being caught in any module and action temporarily before being captured
     * @param String $nameAttribute
     * @return String
     */
    public function getFlash($nameAttribute) {
        if (!array_key_exists($nameAttribute, $this->attributeFlash)) {
            return null;
        }
        
        $value = $this->attributeFlash[$nameAttribute];
        $this->attributeFlash[$nameAttribute] = null;
        
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
    public function setTemplateAction($action = null, $module = null) {
        if (!$this->template instanceof Template) {
            $this->template = new Template();
        }
        
        $this->template->setTemplateAction($action, $module);
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

    /**
     * Generates the name of Class
     * @param string $nameTable
     * @return String
     */
    public static function returnClassName($nameTable) {
        if (empty($nameTable)) {
            return false;
        }
        $class = '';
        $className = explode('_', $nameTable);
        if (count($className) <= 1) {
            $class = ucfirst($className[0]);
        }
        
        if (count($className) > 1) {
            foreach ($className as $name) {
                $class .= ucfirst($name);
            }
        }
        return $class;
    }

    /**
     * Generates the name of method
     * @param string $variableRequestParameter
     * @return String
     */
    public static function returnMethodName($variableRequestParameter) {
        if (empty($variableRequestParameter)) {
            return false;
        }
        $variable = '';
        $variableName = explode('_', $variableRequestParameter);
        if (count($variableName) <= 1) {
            $variable = $variableName[0];
        }
        
        if (count($variableName) > 1) {
            foreach ($variableName as $index => $name) {
                if ($index == 0) {
                    $variable .= $name;
                }
                if ($index > 0) {
                    $variable .= ucfirst($name);
                }
            }
        }
        return $variable;
    }

}