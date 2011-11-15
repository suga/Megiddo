<?php
/**
 * Base - Class responsible for the creation of the Peer bases
 * @author Marco Antonio Sugamele
 * @version 15 Ago 2010
 */

class CreatePeerBase {

    /**
     * @var String
     */
    private $schema;

    /**
     * @var String
     */
    private $fileTemplateBasePeer;

    /**
     * @var String
     */
    private $fileTemplateSearchBasePeer;
    
    /**
     * @var String
     */
    private $fileTemplatePeer;

   
    /**
     * The class constructor stores in memory the paths of the templates
     * @param String $schema
     */
    public function __construct($schema) {
        $path = PATH . PATH_TEMPLATE_BASE;
        
        $this->schema = $schema;
        $this->fileTemplateBasePeer = $path . "TemplateBasePeer.php";
        $this->fileTemplateSearchBasePeer = $path . "TemplateSearchBasePeer.php";
        $this->fileTemplatePeer = $path. "TemplatePeer.php";
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

    /**
     * Will create the contents of the classes Base and delegate your writing
     */
    public function Create() {
        foreach ($this->schema as $table => $rows) {
            $classPeerBase = $this->returnClassNameType('PeerBase', $table);
            $classBase = $this->returnClassNameType('Base', $table);
            $classPeer = $this->returnClassNameType('Peer',$table);
            
            $content = str_replace("[%nameClassPeer%]", $classPeerBase, $this->getContentTemplate($this->fileTemplateBasePeer));
            $content = str_replace("[%nameClassBase%]", $classBase, $content);
            $content = str_replace("[%obj%]", $this->returnClassName($table), $content);
            $content = str_replace("[%searchBy%]", $this->returnSearch($rows, $table), $content);
            
            $contentPeer = str_replace("[%nameClassPeer%]", $classPeerBase, $this->getContentTemplate($this->fileTemplatePeer));
            $contentPeer = str_replace("[%nameClass%]", $classPeer, $contentPeer);
            
            foreach ($rows as $index => $infoClass) {
                if ($index == '$doc$') {
                    $content = str_replace("[%doc%]", $infoClass, $content);
                    $content = str_replace("[%date%]", date('d-m-Y'), $content);
                    $contentPeer = str_replace("[%doc%]", $infoClass, $contentPeer);
                    $contentPeer = str_replace("[%date%]", date('d-m-Y'), $contentPeer);
                }
                
                if (!is_array($infoClass)) {
                    continue;
                }
            }
           $fileName = $classPeerBase.'.php';
           $fileNamePeer = $classPeer. '.php'; 
           WriteToFile::writeContent($content,CLASS_BASE,$fileName,true,true);
           WriteToFile::writeContent($contentPeer,CLASS_PEER,$fileNamePeer,false,false);
        }
    }



    /**
     * searches of repository mounts
     * @param array $rows
     * @param string $table
     * @return string
     */
    private function returnSearch($rows, $table) {
        $private = '';
        foreach ($rows as $index => $infoClass) {
            if ($index == '$doc$') {
                continue;
            }
            
            if (!is_array($infoClass)) {
                continue;
            }
            $private .= $this->mountSearch($infoClass, $index, $table);
        }
        return $private;
    }

    /**
     * searches of repository mounts
     * @param array $infoClass
     * @param string $variable
     * @param string $table
     */
    private function mountSearch($infoClass, $variable, $table) {
        $search = '';
        foreach ($infoClass as $index => $info) {
            switch ($index) {
                case "doc" :
                    $search = str_replace("[%doc%]", $info, $this->getContentTemplate($this->fileTemplateSearchBasePeer));
                    break;
                case "type" :
                    switch ($info) {                        
                        default :
                            $search = str_replace("[%variable%]", $this->returnVaribleName($variable), $search);
                            $search = str_replace("[%nameMethod%]", $this->returnClassName($variable), $search);
                            $search = str_replace("[%constant%]", strtoupper($variable), $search);
                            $search = str_replace("[%type%]", $info, $search);
                            $search = str_replace("[%obj%]", $this->returnClassName($table), $search);    
                            break;
                    }
                    
                    break;
            }
        }
        return $search;
    }

    
    /**
     * Generates the name of Class
     * @param string $table
     * @return String
     */
    private function returnClassName($table) {
        $class = '';
        $className = explode('_', $table);
        if (count($className) <= 1) {
            $class = ucfirst($className[0]);
        }
        
        if (count($className) > 1) {
            foreach ($className as $name) {
                $class .= ucfirst($name);
            }
        }
        return $class;
    }

    /**
     * Generates the name of variable
     * @param string $var
     * @return String
     */
    private function returnVaribleName($var) {
        $variable = '';
        $variableName = explode('_', $var);
        if (count($variableName) <= 1) {
            $variable = $variableName[0];
        }
        
        if (count($variableName) > 1) {
            foreach ($variableName as $index => $name) {
                if ($index == 0) {
                    $variable .= $name;
                }
                if ($index > 0) {
                    $variable .= ucfirst($name);
                }
            }
        }
        return $variable;
    }

    /**
     * Generates the name of type Class
     * @param string $type
     * @param string $table
     * @return string
     */
    private function returnClassNameType($type, $table) {
        return $this->returnClassName($table) . $type;
    }

    /**
     * Returns the first letter and lowercase
     * @return string
     */
    private function firstLower($string) {
        $first = strtolower($string{0});
        $string = substr($string, 1);
        return $first . $string;
    }
}
