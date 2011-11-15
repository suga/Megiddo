<?php
/**
 * Images Util Class
 * @author Otavio Luiz <otaviolcarvalho@gmail.com>
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * Class responsible for treatments related to images
 * Last revision : 13/02/2010
 */
class ImageUtil {

    /**
     * Sends the image to the server can resize it
     * @param string $file
     * @param string $extension
     * @param string $name
     * @param string $directory
     * @param integer $imageWidth
     * @param integer $imageHeight
     * @return boolean
     */
    static public function uploadImage($file, $extension, $name, $directory, $imageWidth, $imageHeight) {
        if (!$file) {
            $log = new Log();
            $log->setLog((__FILE__), 'The file ' . $file . ' can not be empty ');
            return false;
        }
        
        if (!(bool)preg_match("/^(pjpeg|jpeg|png|gif|jpg)$/i", $extension)) {
            return false;
        
        }
        
        $nameImage = $name;
        $imageSize = getimagesize($file);
        $maxWidth = $imageWidth;
        $maxHeight = $imageHeight;
        $img = $file;
        
        switch ($extension) {
            case ("image/gif") :
                $img = imagecreatefromgif($file);
                break;
            case ('image/png') :
                $img = imagecreatefrompng($file);
                break;
            case ('image/bmp') :
                $img = imagecreatefromwbmp($file);
                break;
            default :
                $img = imagecreatefromjpeg($file);
                break;
        }
        
        $width = imagesx($img);
        $height = imagesy($img);
        $scale = min($maxWidth / $width, $maxHeight / $height);
        
        if ($scale < 1) {
            $new_width = floor($scale * $width);
            $new_height = floor($scale * $height);
            // Creates a temporary image
            $tmp_img = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            imagedestroy($img);
            $img = $tmp_img;
        }
        
        if (!(imagejpeg($img, "$directory/" . $nameImage, 85))) {
            $log = new Log();
            $log->setLog((__FILE__), 'The file ' . $nameImage . ' does not exist in the directory ' . $directory);
            return false;
        } else {
            chmod($directory . "/" . $nameImage, 0777);
            return true;
        }
    }

    /**
     * Deletes the image
     * @param string $directory
     * @param string $fileName
     */
    public static function removeImage($directory, $fileName) {
        if (file_exists($directory . $fileName)) {
            unlink($directory . $fileName);
            return true;
        }
        $log = new Log();
        $log->setLog((__FILE__), 'The file ' . $fileName . ' does not exist in the directory ' . $directory);
        return false;
    }
}
?>
