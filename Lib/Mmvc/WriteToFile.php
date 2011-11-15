<?php
/**
 * Class responsible for writing any type of content in files of type text
 * @author Marco Antonio Sugamele
 * @version 15 Ago 2010
 */
class WriteToFile {

    /**
     * Full path where the file is saved
     * @var String
     */
    private static $path;

    /**
     * File name
     * @var String
     */
    private static $fileName;

    /**
     * Clear the contents of the file and add, or add to existing content
     * @var Boolean
     */
    private static $overwrite;

    /**
     * Erases the current file and replaces it with new
     * @var Boolean
     */
    private static $replace;

    /**
     * Write the contents of the file
     * @param String $content
     * @param String $path
     * @param String $fileName
     * @param Boolean $overwrite
     * @param Boolean $replace
     * @return Boolean
     */
    public static function writeContent($content, $path, $fileName, $overwrite = true, $replace = true) {
        self::$path = $path;
        self::$fileName = $fileName;
        
        if (!self::checkPathExists()) {
            $log = new Log();
            $log->setLog((__FILE__), 'The directory is not exists: ' . $path);
            throw new Exception('The directory is not exists: ' . $path);
        }
        
        if (!self::checkPathPermission()) {
            $log = new Log();
            $log->setLog((__FILE__), 'The directory is not writable: ' . $path);
            throw new Exception('The directory is not writable: ' . $path);
        }
        
        if ((!$overwrite && !$replace) && self::checkFileExists()) {
            return false;
        }
        
        $owner = fileowner($path);
        $group = filegroup($path);
        $permission = 0777;
        
        $type = "w";
        
        if ($overwrite && !$replace) {
            $type = "a";
            $content = '\n' . $content;
        }
        
        if ($overwrite && $replace) {
            @unlink($path . $fileName);
        }
        
        $open = fopen($path . $fileName, $type);
        fwrite($open, $content);
        fclose($open);
        
        chmod($path . $fileName, $permission);
        #chown($path.$fileName,$owner);
        #chgrp($path.$fileName,$group);
        

        return true;
    
    }

    /**
     * Checks the permission of the directory
     * @return Boolean
     */
    private static function checkPathPermission() {
        return is_writable(self::$path);
    }

    /**
     * Checks the permission of the /**
     * @return  Boolean
     */
    private static function checkFilePermission() {
        return is_writable(self::$path . self::$fileName);
    }

    /**
     * Checks if the file already exists
     * @return Boolean
     */
    private static function checkFileExists() {
        return is_file(self::$path . self::$fileName);
    }

    /**
     * Checks if the path already exists
     * @return Boolean
     */
    private static function checkPathExists() {
        return is_dir(self::$path);
    }

}
