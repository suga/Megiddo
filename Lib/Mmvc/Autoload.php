<?php

/**
 * Manage PHP built-in autoload
 */
final class Autoload {

    private $arrayPath = array();

    private $arrayClassName = array();

    public function __construct() {
        $this->filesInArray('cache');
        $this->filesInArray('Lib');
        $this->filesInArray('Modules');
        $this->includePath();
    }

    /**
     * Build an array of paths  and name class for autoload
     */
    public function filesInArray($dirName) {
        $ite = new RecursiveDirectoryIterator(PATH . $dirName);
        foreach (new RecursiveIteratorIterator($ite) as $filename) {
            if ((strstr($filename, '.svn') !== false)) {
                continue;
            }
            if (strstr($filename, '.php') === false) {
                continue;
            }
            if (in_array($filename->getPath(), $this->arrayPath)) {
                continue;
            }
            $this->arrayPath[] = $filename->getPath();
            $this->arrayClassName[] = $filename->getFilename();
        }
    }

    /**
     * Includes the new paths for autoload
     */
    public function includePath() {
        foreach ($this->arrayPath as $path) {
            set_include_path(get_include_path() . PATH_SEPARATOR . $path);
        }
    }

    /**
     * Returns the filename of the system classes
     * @return array
     */
    public function getClassName() {
        return $this->arrayClassName;
    }
}