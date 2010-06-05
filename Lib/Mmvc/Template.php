<?php

class Template {

	/**
	 * Stores Module
	 * @var String $module
	 */
    private $module;

    /**
     * Stores Action
     * @var String $action
     */
    private $action;

    /**
     * Stores Layout
     * @var String 4layout
     */
    private $layout;

    /**
     * Stores Path Layout
     * @var String $pathlayout
     */
    private $pathLayout;

    /**
     * Includes a template module
     * @param String $module
     * @param String $file
     * @return String
     */
    public static function includeTemplate($module, $file) {
        $host = $_SERVER['HTTP_HOST'];
        $fileName = PATH . PATH_TEMPLATES . $module . "/" . PATH_INCLUDES . "/" . $file;
        
        if (!file_exists($fileName)) {
            $log = new Log();
            $log->setLog((__FILE__), 'File Not Found ' . $fileName, true);
            throw new Exception('File not Found : ' . $fileName);
        }
        
        require ($fileName);
    
    }

    /**
     * Includes a Layout
     * @param String $nameLayout
     */
    public function setLayout($nameLayout = null) {
        if (is_null($nameLayout) || $nameLayout == false) {
            $this->layout = null;
            $this->pathLayout = null;
            return false;
        }
        $layout = $this->checkLayout($nameLayout);
        $this->layout = $layout;
        $this->setPathLayout($layout);
    }

    /**
     * Checks if the layout exist
     * @param String $nameLayout
     * @return String
     */
    private function checkLayout($nameLayout) {
        if (empty($nameLayout)) {
            return self::getDefaultLayout();
        }
        
        $file = PATH . PATH_LAYOUTS . $this->module . "/" . $nameLayout . '.php';
        
        if (!is_file($file)) {
            return self::getDefaultLayout();
        }
        
        return $nameLayout;
    
    }

    /**
     * Get the Default layout
     * @return String
     */
    public function getDefaultLayout() {
        $file = PATH . PATH_LAYOUTS . MODULE_DEFAULT . "/" . ACTION_DEFAULT . ".php";
        if (!is_file($file)) {
            return null;
        }
        return ACTION_DEFAULT;
    }

    /**
     * Set Path Layout
     * @param String $nameLayout
     */
    public function setPathLayout($nameLayout) {
        $file = PATH . PATH_LAYOUTS . $this->module . "/" . $nameLayout . '.php';
        if (is_file($file)) {
            $this->pathLayout = $file;
        }
    
    }

    /**
     * Get Path Layout
     * @return String
     */
    public function getPathLayout() {
        return $this->pathLayout;
    }

    /**
     * Set the action name
     * @param string $action
     */
    public function setAction($action) {
        $this->action = preg_replace(array('/^[A-Z]/'), strtolower($action[0]), $action);
    }

    /**
     * Set the module name
     * @param string $module
     */
    public function setModule($module) {
        $this->module = $module;
    }

    /**
     * Set a custom layout, and can get the layout of another module
     * @param String $nameLayout
     * @param String $module
     */
    public function setLayoutPersonalite($nameLayout = null, $module = null) {
        if (empty($nameLayout) && $nameLayout == false) {
            $this->layout = null;
            $this->pathLayout = null;
            return false;
        }
        $layout = $this->checkLayoutPersonalite($nameLayout, $module);
        $this->layout = $layout;
        $this->setPathLayout($layout);
    }

    /**
     * Checks if the layout personalite exist
     * @param String $nameLayout
     * @param String $module
     * @return String
     */
    private function checkLayoutPersonalite($nameLayout, $module) {
        if (empty($nameLayout) || empty($module)) {
        	$this->module = MODULE_DEFAULT;
            return self::getDefaultLayout();
        }
        
        $file = PATH . PATH_LAYOUTS . $module . "/" . $nameLayout . '.php';
        
        if (!is_file($file)) {
            return self::getDefaultLayout();
        }
        $this->module = $module;
        return $nameLayout;
    
    }

}
