<?php
/**
 * Url class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 13/02/2010
 * Class responsible for processing the information coming at the URL
 * Last revision : 09/05/2010
 */
class Url {

    /**
     * Contains the array of parameters from url
     * @var array
     */
    public $gets;

    /**
     *The posts will be stored
     * @var array
     */
    private $post = array();

    /**
     * The gets will be stored
     * @var array
     */
    private $get = array();

    /**
     * Getting data from the url and setting the array
     */
    public function __construct() {
        $path = substr($_SERVER['SCRIPT_FILENAME'], strlen($_SERVER['DOCUMENT_ROOT']), -10);
        $uri = $_SERVER["REQUEST_URI"];
        $gets = explode("/", str_replace('=', '/', str_replace('&', '/', str_replace('.php?', '/', $uri))));
        array_shift($gets);
        $this->gets = array_slice($gets, count(explode('/', $path)));
    }

    /**
     * Gets the module
     * @return string
     */
    public function getModule() {
        if(is_array($this->gets) && array_key_exists(0, $this->gets)){
        	return $this->gets[0];
        }
        
        return $this->gets[0] = MODULE_DEFAULT;
    }

    /**
     * Gets the action
     * @return string
     */
    public function getAction() {
        if (empty($this->gets[1])) {
            $this->gets[1] = strtolower(ACTION_DEFAULT);
        }
        $gets = explode("/", str_replace('=', '/', str_replace('&', '/', str_replace('?', '/', $this->gets[1]))));
        $this->gets[1] = $gets[0];
        $array = array();
        $array[0] = $this->gets[0];
        $array[1] = $this->gets[1];
        $array[2] = array_key_exists(1, $gets) ? $gets[1] : null;
        foreach ($this->gets as $key => $value) {
            if ($key == 0 || $key == 1) {
                continue;
            }
            $array[] = $value;
        }
        $this->gets = $array;
        return $this->gets[1];
    }

    /**
     * Corrects the url encoder
     * @return array
     */
    private function getArrayUrl() {
        $this->post = array_key_exists('POST', $_SESSION) ? unserialize($_SESSION['POST']) : null;
        $this->get = array_key_exists('GET', $_SESSION) ? unserialize($_SESSION['GET']) : null;
        
        foreach ($this->gets as $key => $value) {
            //$this->gets[$key] = utf8_decode(urldecode($value));
            $value = is_array($value) ? $value : urldecode($value);
            $this->gets[$key] = $value;
        }
        
        if (is_array($this->post) && count($this->post) >= 1) {
            $key++;
            foreach ($this->post as $keyPost => $value) {
                $this->gets[$key++] = urldecode($keyPost);
                $value = is_array($value) ? $value : urldecode($value);
                $this->gets[$key++] = $value;
            }
        }
        
        if (is_array($this->get) && count($this->get) >= 1) {
            $key++;
            foreach ($this->get as $keyPost => $value) {
                $this->gets[$key++] = urldecode($keyPost);
                $value = is_array($value) ? $value : urldecode($value);
                $this->gets[$key++] = $value;
            }
        }
        return $this->gets;
    }

    /**
     * Fetch the url parameter coming
     * @param string $parameter
     * @return void
     */
    public function getRequestParameter($parameter = null) {
        $arrayUrl = $this->getArrayUrl();
        
        if(empty($parameter)) {
        	return $arrayUrl;
        }
        
        if (!in_array($parameter, $arrayUrl)) {
            return null;
        }
        
        foreach ($arrayUrl as $key => $value) {
            if ($value == $parameter) {
                $chave = $key;
            }
        }
        
        $chave++;
        
        if (!array_key_exists($chave, $arrayUrl)) {
            return null;
        }
        
        $parameter = is_array($arrayUrl[$chave]) ? $arrayUrl[$chave] : urldecode($arrayUrl[$chave]);
        return $parameter;
    
    }

    /**
     * Forward the page to another
     * @param String $module
     * @param String $action
     * @param Content $objContent
     */
    public function forward($module, $action) {
        
        /* @var $autoLoad Autoload */
        $autoLoad = new Autoload();
        
        $arrayFiles = $autoLoad->getClassName();
        
        $module = ucfirst(strtolower($module));
        $action = ucfirst($action);
        
        $module = empty($module) ? MODULE_DEFAULT : $module;
        $action = empty($action) ? ACTION_DEFAULT : $action;
        
        $className = "Action" . $module;
        if (!in_array($className . ".php", $arrayFiles)) {
            echo ERRO_404;
            $log = new Log();
            $log->setLog((__FILE__), $className . ' It was found in line ' . (__LINE__) . ' - Module [' . $module . '] does not exist');
            return false;
        }
        $class = new $className();
        $load = new Load($class, $action, $module);
    }

    /**
     * Forward the page to another
     * @param String $module
     * @param String $action
     */
    public function forwardHeader($module, $action) {
        $host = $_SERVER['HTTP_HOST'];
        $url = explode($this->getModule() . '/' . $this->getAction(), $_SERVER['PHP_SELF']);
        header("Location: http://$host$url[0]$module/$action$url[1]");
    }

    /**
     * Does internal redirection
     * @param String $module Default
     * @param String $action Index
     */
    public function redirectIndoor($module, $action, array $arrayParameters = null) {
        $host = $_SERVER['HTTP_HOST'];
        $url = $_SERVER['SCRIPT_NAME'];
        $parameters = '';
        if (count($arrayParameters) > 0) {
            $parameters = '/';
            foreach ($arrayParameters as $parameter => $value) {
                $parameters .= $parameter . '/' . $value;
            }
        }
        
        header("Location: http://$host$url/$module/$action$parameters");
    
    }

    /**
     * Does index redirection
     * @param String $module Default
     * @param String $action Index
     */
    public function redirectIndex($module, $action, array $arrayParameters = null) {
        $host = $_SERVER['HTTP_HOST'];
        $url = explode($this->getModule() . '/' . $this->getAction(), $_SERVER['PHP_SELF']);
        
        $parameters = '';
        if (count($arrayParameters) > 0) {
            $parameters = '/';
            foreach ($arrayParameters as $parameter => $value) {
                $parameters .= $parameter . '/' . $value;
            }
        }
        $path = $_SERVER['PHP_SELF'];
        header("Location: http://$host$url[0]$path/$module/$action$parameters");
    }

    /**
     * Redirect page
     * @param $url
     */
    public function redirect($url) {
        header("Location: http://$url");
    }

}

?>