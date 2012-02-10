<?php
ini_set('display_errors', 'ON');

require_once '/var/www/Megiddo/Lib/Mmvc/Twig/lib/Twig/Autoloader.php';

class BaseController {
    
    public $twigObject;
    
    public function __construct() {
        
        Twig_Autoloader::register();
        
        $loader = new Twig_Loader_Filesystem(dirname(__FILE__) . '/templates');
        if (!is_dir('/var/www/Megiddo/cache')) {
            mkdir('/var/www/Megiddo/cache');
        }
        $this->twigObject = new Twig_Environment($loader, array(
                'cache' => '/var/www/Megiddo/cache',
        ));
    }
}

$teste = new BaseController();
echo $teste->twigObject->render('index.html');