<?php
/**
 * This class is responsible for creating modules
 * @author Marco Antonio Sugamele
 * @since 14 fev 2011
 */
class CreateModule {

    /**
     * @var String
     */
    private $templateLayout;

    /**
     * @var String
     */
    private $templateModule;

    /**
     * @var String
     */
    private $templateTemplate;

    /**
     * The class constructor stores in memory the paths of the templates
     * @param String $schema
     */
    public function __construct() {
        $path = PATH . PATH_TEMPLATE_CREATES;
        
        $this->templateLayout = $path . "layoutIndex.php";
        $this->templateModule = $path . "templateAction.php";
        $this->templateTemplate = $path . "indexTemplate.php";
    }

    /**
     * Grab the contents of the template files
     * @param String $fileTemplate
     * @return String
     */
    private function getContentTemplate($fileTemplate) {
        if (!file_exists($fileTemplate)) {
            $log = new Log();
            $log->setLog((__FILE__), 'Could not find file -> ' . $fileTemplate);
            throw new Exception('Could not find file -> ' . $fileTemplate);
        }
        $open = fopen($fileTemplate, "r");
        $contentTemplate = fread($open, filesize($fileTemplate));
        fclose($open);
        return $contentTemplate;
    }

    public function newModule($module) {
        $module = ucfirst($module);
        
        if (is_dir(PATH_LAYOUTS . $module)) {
            $log = new Log();
            $log->setLog((__FILE__), 'The directory of this module already exists: ' . PATH_LAYOUTS . $module);
            throw new Exception('The directory of this module already exists: ' . PATH_LAYOUTS . $module);
        }
        
        if (is_dir(PATH_MODULES . $module)) {
            $log = new Log();
            $log->setLog((__FILE__), 'The directory of this module already exists: ' . PATH_MODULES . $module);
            throw new Exception('The directory of this module already exists: ' . PATH_MODULES . $module);
        }
        
        if (is_dir(PATH_TEMPLATES . $module)) {
            $log = new Log();
            $log->setLog((__FILE__), 'The directory of this module already exists: ' . PATH_TEMPLATES . $module);
            throw new Exception('The directory of this module already exists: ' . PATH_TEMPLATES . $module);
        }
        
        if (is_dir(PATH_WEB . $module)) {
            $log = new Log();
            $log->setLog((__FILE__), 'The directory of this module already exists: ' . PATH_WEB . $module);
            throw new Exception('The directory of this module already exists: ' . PATH_WEB . $module);
        }
        
        mkdir(PATH_LAYOUTS . $module);
        mkdir(PATH_MODULES . $module);
        mkdir(PATH_MODULES . $module . '/lib/');
        mkdir(PATH_TEMPLATES . $module);
        mkdir(PATH_TEMPLATES . $module . '/Includes/');
        mkdir(PATH_WEB . $module);
        mkdir(PATH_WEB . $module . '/css/');
        mkdir(PATH_WEB . $module . '/images/');
        mkdir(PATH_WEB . $module . '/js/');
        
        $permission = 0777;
        
        chmod(PATH_LAYOUTS . $module, $permission);
        chmod(PATH_MODULES . $module, $permission);
        chmod(PATH_MODULES . $module.'/lib/', $permission);
        chmod(PATH_TEMPLATES . $module, $permission);
        chmod(PATH_TEMPLATES . $module.'/Includes/', $permission);
        chmod(PATH_WEB . $module, $permission);
        chmod(PATH_WEB . $module. '/css/', $permission);
        chmod(PATH_WEB . $module. '/images/', $permission);
        chmod(PATH_WEB . $module. '/js/', $permission);
        
        $templateLayout = $this->getContentTemplate($this->templateLayout);
        $pathLayout = PATH_LAYOUTS . $module.'/';
        WriteToFile::writeContent($templateLayout, $pathLayout, 'index.php', true, true);
        
        $templateModule = $this->getContentTemplate($this->templateModule);
        $templateModule = str_replace("[%module%]", $module, $templateModule);
        $templateModule = str_replace("[%date%]", date('d/m/Y H:i:s'), $templateModule);
        $pathModules = PATH_MODULES . $module.'/';
        $fileModule = 'Action' . $module . '.php';
        WriteToFile::writeContent($templateModule, $pathModules, $fileModule, true, true);
        
        $templateTemplate = $this->getContentTemplate($this->templateTemplate);
        $pathTemplate = PATH_TEMPLATES . $module.'/';
        WriteToFile::writeContent($templateTemplate, $pathTemplate, 'index.php', true, true);
        
        return true;
    }
}
