<?php
/**
 * PreLoad class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 02/04/2010
 * Is performed before any other action to make it possible to centralize certain actions as setagem culture and check login.
 * Last revision : 02/04/2010
 */
class PreLoad {

    /**
     * 
     * @param object $var
     */
    public function __construct($var) {
    	/* @var $objContent  Content */
    	$objContent = unserialize($_SESSION['objContent']);
    	
        $instance = "ActionGeneral";
        if (!$var instanceof $instance) {
            echo ERRO_404;
            $log = new Log();
            $log->setLog((__FILE__), ' The error occurred on line ' . (__LINE__) . ' - Was not found to GeneralAction');
            return false;
        }
        
        
        $_SESSION['objContent'] = serialize($objContent);
    }
    
    
    
}

?>