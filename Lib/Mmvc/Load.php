<?php
/**
 * Load class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 12/02/2010
 * Class responsible for the correct insertion of the template as the module and action required
 * Last revision : 13/02/2010
 */
class Load {

    /**
     * 
     * @param object $var
     * @param string $action
     * @param string $module
     */
    public function __construct($var, $action, $module) {
        /* @var $objContent  Content */
        $objContent = unserialize($_SESSION['objContent']);
        
        $instance = "Action" . $module;
        if (!$var instanceof $instance) {
            echo ERRO_404;
            $log = new Log();
            $log->setLog((__FILE__), ' The error occurred on line ' . (__LINE__) . ' - Module [' . $module . '] does not exist');
            return false;
        }
        $method = "execute" . $action;
        if (!method_exists($var, $method)) {
            echo ERRO_404;
            $log = new Log();
            $log->setLog((__FILE__), ' The error occurred on line ' . (__LINE__) . ' - Method [' . $method . '] does not exist');
            return false;
        }
        
        $template = new Template();
        $template->setModule($module);
        $template->setAction($action);
        $template->setLayout();
        
        $objContent->setInformationLoad(array($var, $method));
        $objContent->setTemplate($template);
        
        if (method_exists($var, 'preExecute')) {
            $var->preExecute($objContent);
        }
        
        $returnAction = $var->$method($objContent);        
        
        $moduleTemplate = $objContent->getObjTemplate()->getModule();
        $moduleTemplate = empty($moduleTemplate) ? $module : $objContent->getObjTemplate()->getModule();
        $actionTemplate = $objContent->getObjTemplate()->getAction();
        $actionTemplate = empty($actionTemplate) ? $action : $objContent->getObjTemplate()->getAction();
        if ($moduleTemplate != $module) {
            $template->setModule($moduleTemplate);
        }
        if ($actionTemplate != $action) {
            $template->setAction($actionTemplate);
        }        
        
        $objContent->setHasLayout($returnAction);
        $objContent->typeLayout($returnAction);
        
        if ($returnAction == ViewActions::VIEW_SUCCESS || is_null($returnAction)) {
            $file = PATH . PATH_TEMPLATES . $moduleTemplate . "/" . preg_replace(array('/^[A-Z]/'), strtolower($actionTemplate[0]), $actionTemplate) . ".php";
        }
        
        if ($returnAction == ViewActions::VIEW_ERROR) {
            $file = PATH . PATH_TEMPLATES . $moduleTemplate . "/" . preg_replace(array('/^[A-Z]/'), strtolower($actionTemplate[0]), $actionTemplate) . "Error.php";
        }
        
        if ($returnAction != ViewActions::VIEW_NONE && !is_file($file)) {
            if (!$var instanceof ActionGeneral) {
                echo ERRO_404;
                $log = new Log();
                $log->setLog((__FILE__), ' The error occurred on line ' . (__LINE__) . ' - The template file not found: [' . $file . ']');
                return false;
            }
        }
        
        $templateRead = new TemplateRead();
        $templateRead->getContentFromLayout($template->getPathLayout(), $var);
        $templateRead->getContentFromTemplate($file, $var);
        echo $templateRead->getContentFromMerge();
        
        if (method_exists($var, 'endExecute')) {
            $var->endExecute($objContent);
        }
        
        $objContent->getObjTemplate()->setTemplateAction(null, null);
        
        $_SESSION['objContent'] = serialize($objContent);
    }
}

?>