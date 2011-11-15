<?php
/**
 * Base - Class responsible for the creation of the class
 * @author Marco Antonio Sugamele
 * @version 19 Ago 2010
 */

class CreateClass {

    /**
     * @var String
     */
    private $schema;

    /**
     * @var String
     */
    private $fileTemplateClass;

    /**
     * The class constructor stores in memory the paths of the templates
     * @param String $schema
     */
    public function __construct($schema) {
        $path = PATH . PATH_TEMPLATE_BASE;
        
        $this->schema = $schema;
        $this->fileTemplateClass = $path . "TemplateClass.php";
    
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
            $class = $this->returnClassName($table);
            $classPeer = $this->returnClassNameType('Peer',$table);
            
            $content = str_replace("[%nameClass%]", $class, $this->getContentTemplate($this->fileTemplateClass));
            $content = str_replace("[%nameClassPeer%]", $classPeer, $content);
            
            foreach ($rows as $index => $infoClass) {
                if ($index == '$doc$') {
                    $content = str_replace("[%doc%]", $infoClass, $content);
                    $content = str_replace("[%date%]", date('d-m-Y'), $content);
                }
                
                if (!is_array($infoClass)) {
                    continue;
                }
            }
            $fileName = $class . '.php';
            WriteToFile::writeContent($content, CLASS_CLASS, $fileName, false, false);
        }
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
