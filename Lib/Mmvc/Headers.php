<?php
/**
 * Headers class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 16/05/2010
 * Facilitates some html commands
 * Last revision : 16/05/2010
 */
class Headers {

    /**
     * Form the Url for the action of a specific module
     * @param String $module
     * @param String $action
     * @param array $arrayParameters
     */
    public static function linkTo($module, $action, array $arrayParameters = null) {
        $host = $_SERVER['HTTP_HOST'];
        $url = $_SERVER['SCRIPT_NAME'];
        $parameters = '';
        if (count($arrayParameters) > 0) {
            $parameters = '/';
            foreach ($arrayParameters as $parameter => $value) {
                $parameters .= '/' . $parameter . '/' . $value;
            }
        }
        
        return "http://$host$url/$module/$action$parameters";
    
    }

    /**
     * Link to the web directory
     */
    private static function linkToWeb() {
        $host = $_SERVER['HTTP_HOST'];
        $url = new Url();
        $url = explode($url->getModule() . '/' . $url->getAction(), $_SERVER['PHP_SELF']);
        $url = explode('index.php', $url[0]);
        
        return "http://$host$url[0]web/";
    }

    /**
     * path to the web directory
     */
    private static function pathToWeb() {
      return PATH_WEB;
    }

    /**
     * Link to the css directory of the module
     * @param String $module
     * @param String $file
     */
    public static function linkToCss($module, $file) {
        $urlWeb = self::linkToWeb();
        $urlWeb .= $module . '/css/' . $file;
        return $urlWeb;
    }

    /**
     * Link to the image directory of the module 
     * @param String $module
     * @param String $file
     */
    public static function linkToImage($module, $file) {
        $urlWeb = self::linkToWeb();
        $urlWeb .= $module . '/images/' . $file;
        return $urlWeb;
    }

    /**
     * Path to the image directory of the module 
     * @param String $module
     * @param String $file
     */
    public static function pathToImage($module, $file = null) {
        $pathWeb = self::pathToWeb();
        $pathWeb .= $module . '/images/' . $file;
        return $pathWeb;
    }

    /**
     * Link to the js (javascript) directory of the module
     * @param String $module
     * @param String $file
     */
    public static function linkToJs($module, $file) {
        $urlWeb = self::linkToWeb();
        $urlWeb .= $module . '/js/' . $file;
        return $urlWeb;
    }

    /**
     * Link to the config directory
     */
    private static function linkToConfig() {
        $path = explode('index.php', $_SERVER['SCRIPT_FILENAME']);
        return $path[0] . 'Config/';
    }

    /**
     * Raises the link to the YML Module
     * @param String $module
     * @param String $file
     */
    public static function linkToYml($module, $file) {
        $urlWeb = self::linkToConfig();
        $urlWeb .= $module . '/' . $file;
        return $urlWeb;
    }

}
