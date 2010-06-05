<?php
/**
 * View class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 12/02/2010
 * Forward content
 * Last revision : 13/02/2010
 */
class View extends Url {

    public function __construct(Autoload $objAutoload) {
        $_SESSION['POST'] = serialize($_POST);
        $_SESSION['GET'] = serialize($_GET);        
        parent::__construct($objAutoload);
        
        /* @var $objContent  Content */
        $objContent = unserialize($_SESSION['objContent']);
        
        $arrayFiles = $objAutoload->getClassName();
        
        $module = ucfirst($this->getModule());
        $action = ucfirst($this->getAction());
        
        if (empty($module) && empty($action)) {
            $this->redirectIndex(MODULE_DEFAULT, ACTION_DEFAULT, array());
            exit();
        }
        
        $module = empty($module) ? MODULE_DEFAULT : $module;
        $action = empty($action) ? ACTION_DEFAULT : $action;
        
        $className = "Action" . $module;
        if (!in_array($className . ".php", $arrayFiles)) {
            echo ERRO_404;
            $log = new Log();
            $log->setLog((__FILE__), $className . ' It was found in line ' . (__LINE__) . ' - Module [' . $module . '] does not exist');
            return false;
        }
        
        $_SESSION['objContent'] = serialize($objContent);
        
        $preActionClass = new ActionGeneral();
        $preLoad = new PreLoad($preActionClass);
        
        $actionClass = new $className();
        $load = new Load($actionClass, $action, $module);
    }

}
