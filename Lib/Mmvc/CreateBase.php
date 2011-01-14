<?php
/**
 * Base - Class responsible for the creation of the bases
 * @author Marco Antonio Sugamele
 * @version 15 Ago 2010
 */

class CreateBase {

    /**
     * @var String
     */
    private $schema;

    /**
     * @var String
     */
    private $fileTemplateBase;

    /**
     * @var String
     */
    private $fileTemplateConstBase;

    /**
     * @var String
     */
    private $privateTemplate;

    /**
     * @var String
     */
    private $pkTemplate;

    /**
     * @var String
     */
    private $fkTemplate;

    /**
     * @var String
     */
    private $intTemplate;

    /**
     * @var String
     */
    private $stringTemplate;

    /**
     * @var String
     */
    private $boolTemplate;

    /**
     * @var String
     */
    private $rtTemplate;

    /**
     * @var String
     */
    private $delTemplate;

    /**
     * @var String
     */
    private $setPkTemplate;

    /**
     * @var String
     */
    private $setFkTemplate;

    /**
     * @var String
     */
    private $setTemplate;

    /**
     * @var String
     */
    private $getPkTemplate;

    /**
     * @var String
     */
    private $getPkFkTemplate;

    /**
     * @var String
     */
    private $getFkTemplate;

    /**
     * @var String
     */
    private $getTemplate;

    /**
     * @var String
     */
    private $startTemplate;

    /**
     * @var String
     */
    private $endTemplate;

    /**
     * @var String
     */
    private $pkTemplateConvertingObject;

    /**
     * @var String
     */
    private $setTemplateConvertingObject;

    /**
     * @var String
     */
    private $fkTemplateConvertingObject;

    /**
     * @var String
     */
    private $startTemplateSave;

    /**
     * @var String
     */
    private $fieldsTemplateSave;

    /**
     * @var String
     */
    private $fkTemplateSave;

    /**
     * The class constructor stores in memory the paths of the templates
     * @param String $schema
     */
    public function __construct($schema) {
        $path = PATH . PATH_TEMPLATE_BASE;
        
        $this->schema = $schema;
        $this->fileTemplateBase = $path . "TemplateBase.php";
        $this->fileTemplateConstBase = $path . "TemplateConstBase.php";
        $this->privateTemplate = $path . "TemplatePrivateBase.php";
        $this->pkTemplate = $path . "TemplateIsValidPkBase.php";
        $this->fkTemplate = $path . "TemplateIsValidFkBase.php";
        $this->intTemplate = $path . "TemplateIsValidIntBase.php";
        $this->stringTemplate = $path . "TemplateIsValidStringBase.php";
        $this->boolTemplate = $path . "TemplateIsValidBoolBase.php";
        $this->rtTemplate = $path . "TemplateRetrivePkBase.php";
        $this->delTemplate = $path . "TemplateDeleteBase.php";
        $this->setPkTemplate = $path . "TemplateSetPkBase.php";
        $this->setFkTemplate = $path . "TemplateSetFkBase.php";
        $this->setTemplate = $path . "TemplateSetBase.php";
        $this->getPkTemplate = $path . "TemplateGetPkBase.php";
        $this->getPkFkTemplate = $path . "TemplateGetPkFkBase.php";
        $this->getFkTemplate = $path . "TemplateGetFkBase.php";
        $this->getTemplate = $path . "TemplateGetBase.php";
        $this->startTemplate = $path . "TemplateConvertingObjectStartBase.php";
        $this->endTemplate = $path . "TemplateConvertingObjectEndBase.php";
        $this->pkTemplateConvertingObject = $path . "TemplateConvertingObjectPkBase.php";
        $this->setTemplateConvertingObject = $path . "TemplateConvertingObjectSetBase.php";
        $this->fkTemplateConvertingObject = $path . "TemplateConvertingObjectFkBase.php";
        $this->startTemplateSave = $path . "TemplateSaveStartBase.php";
        $this->fieldsTemplateSave = $path . "TemplateSaveFieldsBase.php";
        $this->fkTemplateSave = $path . "TemplateSaveFkBase.php";
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
            $class = $this->returnClassNameType('Base', $table);
            $content = str_replace("[%nameClass%]", $class, $this->getContentTemplate($this->fileTemplateBase));
            $content = str_replace("[%table%]", $table, $content);
            $content = str_replace("[%consts%]", $this->returnConsts($rows), $content);
            $content = str_replace("[%privates%]", $this->returnPrivates($rows), $content);
            $content = str_replace("[%validates%]", $this->returnIsValid($rows), $content);
            $content = str_replace("[%retrive%]", $this->returnRetrive($rows), $content);
            $content = str_replace("[%delete%]", $this->returnDelete($rows), $content);
            $content = str_replace("[%sets%]", $this->returnSets($rows), $content);
            $content = str_replace("[%gets%]", $this->returnGets($rows), $content);
            $content = str_replace("[%ConvertingObject%]", $this->returnConvertingObject($rows, $table), $content);
            $content = str_replace("[%save%]", $this->returnSave($rows, $table), $content);
            
            foreach ($rows as $index => $infoClass) {
                if ($index == '$doc$') {
                    $content = str_replace("[%doc%]", $infoClass, $content);
                    $content = str_replace("[%date%]", date('d-m-Y'), $content);
                }
                
                if (!is_array($infoClass)) {
                    continue;
                }
            }
           $fileName = $class.'.php'; 
           WriteToFile::writeContent($content,CLASS_BASE,$fileName,true,true);
        }
    }

    /**
     * Assembles the constants
     * @param array $rows
     * @return string
     */
    private function returnConsts($rows) {
        $const = '';
        foreach ($rows as $index => $infoClass) {
            if ($index == '$doc$') {
                continue;
            }
            
            if (!is_array($infoClass)) {
                continue;
            }
            
            $const .= str_replace("[%constUppercase%]", strtoupper($index), $this->getContentTemplate($this->fileTemplateConstBase));
            $const = str_replace("[%constLowercase%]", strtolower($index), $const);
        }
        return $const;
    }

    /**
     * Assemble the variables of the class
     * @param array $rows
     * @return string
     */
    private function returnPrivates($rows) {
        $private = '';
        foreach ($rows as $index => $infoClass) {
            if ($index == '$doc$') {
                continue;
            }
            
            if (!is_array($infoClass)) {
                continue;
            }
            $private .= $this->mountPrivate($infoClass, $index);
        }
        return $private;
    }

    /**
     * Assemble the variables of the class
     * @param array $infoClass
     * @param string $variable
     */
    private function mountPrivate($infoClass, $variable) {
        $private = '';
        foreach ($infoClass as $index => $info) {
            switch ($index) {
                case "doc" :
                    $private = str_replace("[%doc%]", $info, $this->getContentTemplate($this->privateTemplate));
                    break;
                case "type" :
                    switch ($info) {
                        case 'int' :
                            $private = str_replace("[%return%]", 'integer', $private);
                            $private = str_replace("[%variable%]", $this->returnVaribleName($variable), $private);
                            break;
                        case 'pk' :
                        case 'fk' :
                            
                            $private = str_replace("[%return%]", 'integer', $private);
                            $private = str_replace("[%variable%]", $this->returnVaribleName($variable), $private);
                            if (array_key_exists('obj', $infoClass)) {
                                $privateObj = str_replace("[%doc%]", ucfirst($infoClass['obj']), $this->getContentTemplate($this->privateTemplate));
                                $privateObj = str_replace("[%return%]", ucfirst($infoClass['obj']), $privateObj);
                                $privateObj = str_replace("[%variable%]", $this->firstLower($infoClass['obj']), $privateObj);
                                $private .= $privateObj;
                            }
                            
                            break;
                        case 'string' :
                            $private = str_replace("[%return%]", 'String', $private);
                            $private = str_replace("[%variable%]", $this->returnVaribleName($variable), $private);
                            break;
                        case 'bool' :
                            $private = str_replace("[%return%]", 'Boolean', $private);
                            $private = str_replace("[%variable%]", $this->returnVaribleName($variable), $private);
                            break;
                        default :
                            break;
                    }
                    
                    break;
            }
        }
        return $private;
    }

    /**
     * Returns the validator class
     * @param array $rows
     * @return string
     */
    private function returnIsValid($rows) {
        $validate = '';
        foreach ($rows as $index => $infoClass) {
            if ($index == '$doc$') {
                continue;
            }
            
            if (!is_array($infoClass)) {
                continue;
            }
            $validate .= $this->mountValidate($infoClass, $index);
        }
        return $validate;
    }

    /**
     * Returns the validator class
     * @param array $infoClass
     * @param string $variable
     */
    private function mountValidate($infoClass, $variable) {
        $pk = '';
        $fk = '';
        $int = '';
        $string = '';
        $bool = '';
        foreach ($infoClass as $index => $info) {
            switch ($index) {
                case "doc" :
                    break;
                case "type" :
                    switch ($info) {
                        case 'int' :
                            $int = str_replace("[%doc%]", ucfirst($infoClass['doc']), $this->getContentTemplate($this->intTemplate));
                            $int = str_replace("[%variable%]", $this->returnVaribleName($variable), $int);
                            $int = str_replace("[%nameMethod%]", $this->returnClassName($variable), $int);
                            $int = str_replace("[%sizeMax%]", (int)$infoClass['size_max'], $int);
                            $int = str_replace("[%sizeMin%]", (int)$infoClass['size_min'], $int);
                            break;
                        case 'pk' :
                            $pk = str_replace("[%doc%]", ucfirst($infoClass['doc']), $this->getContentTemplate($this->pkTemplate));
                            $pk = str_replace("[%variable%]", $this->returnVaribleName($variable), $pk);
                            $pk = str_replace("[%nameMethod%]", $this->returnClassName($variable), $pk);
                            $pk = str_replace("[%obj%]", ucfirst($infoClass['obj']), $pk);
                            break;
                        case 'fk' :
                            $fk = str_replace("[%doc%]", ucfirst($infoClass['doc']), $this->getContentTemplate($this->fkTemplate));
                            $fk = str_replace("[%variable%]", $this->returnVaribleName($variable), $fk);
                            $fk = str_replace("[%nameMethod%]", $this->returnClassName($variable), $fk);
                            $fk = str_replace("[%obj%]", ucfirst($infoClass['obj']), $fk);
                            break;
                        case 'string' :
                            $string = str_replace("[%doc%]", ucfirst($infoClass['doc']), $this->getContentTemplate($this->stringTemplate));
                            $string = str_replace("[%variable%]", $this->returnVaribleName($variable), $string);
                            $string = str_replace("[%nameMethod%]", $this->returnClassName($variable), $string);
                            $string = str_replace("[%sizeMax%]", (int)$infoClass['size_max'], $string);
                            $string = str_replace("[%sizeMin%]", (int)$infoClass['size_min'], $string);
                            break;
                        case 'bool' :
                            $bool = str_replace("[%doc%]", ucfirst($infoClass['doc']), $this->getContentTemplate($this->boolTemplate));
                            $bool = str_replace("[%variable%]", $this->returnVaribleName($variable), $bool);
                            $bool = str_replace("[%nameMethod%]", $this->returnClassName($variable), $bool);
                            $bool = str_replace("[%sizeMax%]", (int)$infoClass['size_max'], $bool);
                            $bool = str_replace("[%sizeMin%]", (int)$infoClass['size_min'], $bool);
                            break;
                        default :
                            break;
                    }
                    
                    break;
            }
        }
        return $pk . $fk . $int . $string . $bool;
    }

    /**
     * Returns the retrive by PK class
     * @param array $rows
     * @return string
     */
    private function returnRetrive($rows) {
        $retrive = '';
        foreach ($rows as $index => $infoClass) {
            if ($index == '$doc$') {
                continue;
            }
            
            if (!is_array($infoClass)) {
                continue;
            }
            $retrive .= $this->mountRetrive($infoClass, $index);
        }
        return $retrive;
    }

    /**
     * Returns the retive class
     * @param array $infoClass
     * @param string $variable
     */
    private function mountRetrive($infoClass, $variable) {
        $rt = '';
        foreach ($infoClass as $index => $info) {
            switch ($index) {
                case "type" :
                    switch ($info) {
                        case 'pk' :
                            $rt = str_replace("[%variable%]", $this->returnVaribleName($variable), $this->getContentTemplate($this->rtTemplate));
                            $rt = str_replace("[%constant%]", strtoupper($variable), $rt);
                            $rt = str_replace("[%obj%]", ucfirst($infoClass['obj']), $rt);
                            break;
                        default :
                            break;
                    }
                    
                    break;
            }
        }
        return $rt;
    }

    /**
     * Returns the delete by PK class
     * @param array $rows
     * @return string
     */
    private function returnDelete($rows) {
        $delete = '';
        foreach ($rows as $index => $infoClass) {
            if ($index == '$doc$') {
                continue;
            }
            
            if (!is_array($infoClass)) {
                continue;
            }
            $delete .= $this->mountDelete($infoClass, $index);
        }
        return $delete;
    }

    /**
     * Returns the retive class
     * @param array $infoClass
     * @param string $variable
     */
    private function mountDelete($infoClass, $variable) {
        $del = '';
        foreach ($infoClass as $index => $info) {
            switch ($index) {
                case "type" :
                    switch ($info) {
                        case 'pk' :
                            $del = str_replace("[%variable%]", $this->returnVaribleName($variable), $this->getContentTemplate($this->delTemplate));
                            $del = str_replace("[%constant%]", strtoupper($variable), $del);
                            break;
                        default :
                            break;
                    }
                    
                    break;
            }
        }
        return $del;
    }

    /**
     * Returns the method set class
     * @param array $rows
     * @return string
     */
    private function returnSets($rows) {
        $set = '';
        foreach ($rows as $index => $infoClass) {
            if ($index == '$doc$') {
                continue;
            }
            
            if (!is_array($infoClass)) {
                continue;
            }
            $set .= $this->mountSets($infoClass, $index);
        }
        return $set;
    }

    /**
     * Returns the method sets class
     * @param array $infoClass
     * @param string $variable
     */
    private function mountSets($infoClass, $variable) {
        $setpk = '';
        $setfk = '';
        $set = '';
        foreach ($infoClass as $index => $info) {
            switch ($index) {
                case "type" :
                    switch ($info) {
                        case 'pk' :
                            $setpk = str_replace("[%variable%]", $this->returnVaribleName($variable), $this->getContentTemplate($this->setPkTemplate));
                            $setpk = str_replace("[%nameMethod%]", $this->returnClassName($variable), $setpk);
                            $setpk = str_replace("[%obj%]", $infoClass['obj'], $setpk);
                            $setpk = str_replace("[%objLower%]", $this->firstLower($infoClass['obj']), $setpk);
                            break;
                        case 'fk' :
                            $setfk = str_replace("[%variable%]", $this->returnVaribleName($variable), $this->getContentTemplate($this->setFkTemplate));
                            $setfk = str_replace("[%nameMethod%]", $this->returnClassName($variable), $setfk);
                            $setfk = str_replace("[%obj%]", $infoClass['obj'], $setfk);
                            $setfk = str_replace("[%objLower%]", $this->firstLower($infoClass['obj']), $setfk);
                            break;
                        default :
                            $set = str_replace("[%variable%]", $this->returnVaribleName($variable), $this->getContentTemplate($this->setTemplate));
                            $set = str_replace("[%nameMethod%]", $this->returnClassName($variable), $set);
                            $set = str_replace("[%doc%]", $infoClass['doc'], $set);
                            $set = str_replace("[%type%]", $info, $set);
                            break;
                    }
                    
                    break;
            }
        }
        return $setpk . $setfk . $set;
    }

    /**
     * Returns the method get class
     * @param array $rows
     * @return string
     */
    private function returnGets($rows) {
        $get = '';
        $pkFk = $this->isFk($rows);
        foreach ($rows as $index => $infoClass) {
            if ($index == '$doc$') {
                continue;
            }
            
            if (!is_array($infoClass)) {
                continue;
            }
            $get .= $this->mountGets($infoClass, $index, $pkFk);
        }
        return $get;
    }

    /**
     * Returns the method sets class
     * @param array $infoClass
     * @param string $variable
     */
    private function mountGets($infoClass, $variable, $pkFk) {
        $getpk = '';
        $getfk = '';
        $get = '';
        foreach ($infoClass as $index => $info) {
            switch ($index) {
                case "type" :
                    switch ($info) {
                        case 'pk' :
                            if (!$pkFk['pkfk']) {
                                $getpk = str_replace("[%variable%]", $this->returnVaribleName($variable), $this->getContentTemplate($this->getPkTemplate));
                                $getpk = str_replace("[%nameMethod%]", $this->returnClassName($variable), $getpk);
                                $getpk = str_replace("[%obj%]", $infoClass['obj'], $getpk);
                                $getpk = str_replace("[%objLower%]", $this->firstLower($infoClass['obj']), $getpk);
                                $getpk = str_replace("[%type%]", $info, $getpk);
                            } else {
                                $getpk = str_replace("[%variable%]", $this->returnVaribleName($variable), $this->getContentTemplate($this->getPkFkTemplate));
                                $getpk = str_replace("[%nameMethod%]", $this->returnClassName($variable), $getpk);
                                $getpk = str_replace("[%obj%]", $infoClass['obj'], $getpk);
                                $getpk = str_replace("[%objLower%]", $this->firstLower($infoClass['obj']), $getpk);
                                $getpk = str_replace("[%type%]", $info, $getpk);
                                $getpk = str_replace("[%objFk%]", $pkFk['obj'], $getpk);
                                $getpk = str_replace("[%objLowerFk%]", $this->firstLower($pkFk['obj']), $getpk);
                                $getpk = str_replace("[%variableFk%]", $this->returnVaribleName($pkFk['variable']), $getpk);
                            }
                            break;
                        case 'fk' :
                            $getfk = str_replace("[%variable%]", $this->returnVaribleName($variable), $this->getContentTemplate($this->getFkTemplate));
                            $getfk = str_replace("[%nameMethod%]", $this->returnClassName($variable), $getfk);
                            $getfk = str_replace("[%obj%]", $infoClass['obj'], $getfk);
                            $getfk = str_replace("[%objLower%]", $this->firstLower($infoClass['obj']), $getfk);
                            $getfk = str_replace("[%type%]", $info, $getfk);
                            break;
                        default :
                            $get = str_replace("[%variable%]", $this->returnVaribleName($variable), $this->getContentTemplate($this->getTemplate));
                            $get = str_replace("[%nameMethod%]", $this->returnClassName($variable), $get);
                            $get = str_replace("[%type%]", $info, $get);
                            break;
                    }
                    
                    break;
            }
        }
        return $getpk . $getfk . $get;
    }

    /**
     * Returns the populate object
     * @param array $rows
     * @param string $table
     * @return string
     */
    private function returnConvertingObject($rows, $table) {
        $start = '';
        $end = '';
        $retrive = '';
        foreach ($rows as $index => $infoClass) {
            if ($index == '$doc$') {
                continue;
            }
            
            if (!is_array($infoClass)) {
                continue;
            }
            $retrive .= $this->mountConvertingObject($infoClass, $index);
        }
        $template = str_replace("[%obj%]", $this->returnClassName($table), $this->getContentTemplate($this->startTemplate));
        $template = str_replace("[%sets%]", $retrive, $template);
        $template = str_replace("[%end%]", $this->getContentTemplate($this->endTemplate), $template);
        return $template;
    }

    /**
     * Returns the populate Object class
     * @param array $infoClass
     * @param string $variable
     */
    private function mountConvertingObject($infoClass, $variable) {
        $pk = '';
        $set = '';
        $fk = '';
        
        foreach ($infoClass as $index => $info) {
            switch ($index) {
                case "type" :
                    switch ($info) {
                        case 'pk' :
                            $pk = str_replace("[%variable%]", $variable, $this->getContentTemplate($this->pkTemplateConvertingObject));
                            $pk = str_replace("[%nameMethod%]", $this->returnClassName($variable), $pk);
                            break;
                        case 'fk' :
                            $fk = str_replace("[%variable%]", $variable, $this->getContentTemplate($this->fkTemplateConvertingObject));
                            $fk = str_replace("[%obj%]", $infoClass['obj'], $fk);
                            $fk = str_replace("[%nameMethod%]", $this->returnClassName($variable), $fk);
                            break;
                        default :
                            $set = str_replace("[%variable%]", $variable, $this->getContentTemplate($this->setTemplateConvertingObject));
                            $set = str_replace("[%nameMethod%]", $this->returnClassName($variable), $set);
                            break;
                    }
                    
                    break;
            }
        }
        return $pk . $set . $fk;
    }

    /**
     * Returns the Save object
     * @param array $rows
     * @param string $table
     * @return string
     */
    private function returnSave($rows, $table) {
        $start = '';
        $retrive = '';
        $retrive2 = '';
        $retrive3 = '';
        $template = str_replace("[%obj%]", $this->returnClassName($table), $this->getContentTemplate($this->startTemplateSave));
        foreach ($rows as $index => $infoClass) {
            if ($index == '$doc$') {
                continue;
            }
            
            if (!is_array($infoClass)) {
                continue;
            }
            $retrive .= $this->mountSave($infoClass, $index, $table);
            $retrive2 .= $this->mountSaveFk($infoClass, $index);
            $retrive3 .= $this->mountSavePk($infoClass, $index);
            
            $template = str_replace("[%variable%]", $this->returnVaribleName($retrive3), $template);
            $template = str_replace("[%variableSQL%]", $retrive3, $template);
            $template = str_replace("[%constant%]", strtoupper($retrive3), $template);
            $template = str_replace("[%className%]", $this->returnClassName($table), $template);
        }
        $retrive = substr($retrive, 0, -1);
        $template = str_replace("[%fields%]", $retrive, $template);
        $template = str_replace("[%fk%]", $retrive2, $template);
        
        return $template;
    }

    /**
     * Returns the Save Object class
     * @param array $infoClass
     * @param string $variable
     */
    private function mountSave($infoClass, $variable) {
        $fields = '';
        foreach ($infoClass as $index => $info) {
            $fields = str_replace("[%variable%]", $this->returnVaribleName($variable), $this->getContentTemplate($this->fieldsTemplateSave));
            $fields = str_replace("[%constant%]", strtoupper($variable), $fields);
        }
        
        return $fields;
    }

    /**
     * Returns the Save Object class
     * @param array $infoClass
     * @param string $variable
     */
    private function mountSaveFk($infoClass, $variable) {
        $fk = '';
        foreach ($infoClass as $index => $info) {
            switch ($index) {
                case "type" :
                    switch ($info) {
                        case 'fk' :
                            $fk = str_replace("[%variableSQL%]", $variable, $this->getContentTemplate($this->fkTemplateSave));
                            $fk = str_replace("[%variable%]", $this->returnVaribleName($variable), $fk);
                            break;
                    }
                    
                    break;
            }
        }
        return $fk;
    }

    /**
     * Returns the Save Object class
     * @param array $infoClass
     * @param string $variable
     */
    private function mountSavePk($infoClass, $variable) {
        $pk = '';
        foreach ($infoClass as $index => $info) {
            switch ($index) {
                case "type" :
                    switch ($info) {
                        case 'pk' :
                            $pk = $variable;
                            break;
                    }
                    
                    break;
            }
        }
        return $pk;
    }

    /**
     * return if exists fk in array
     * @param array $infoClass
     * @return array
     */
    private function isFk($rows) {
        $isFk = array();
        $isFk['pkfk'] = false;
        foreach ($rows as $index => $infoClass) {
            if ($index == '$doc$') {
                continue;
            }
            
            if (!is_array($infoClass)) {
                continue;
            }
            if ((bool)in_array('fk', $infoClass)) {
                $isFk['variable'] = $index;
                $isFk['obj'] = $infoClass['obj'];
                $isFk['pkfk'] = true;
            }
        }
        return $isFk;
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
