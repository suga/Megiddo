<?php

class I18nXml {

    public static function create($isoLang = 'pt_BR') {
        $xmlDoc = new DOMDocument('1.0', 'utf-8');
        $xmlDoc->formatOutput = true;
        
        $culture = $xmlDoc->createElement($isoLang);
        $culture = $xmlDoc->appendChild($culture);
        
        $criteria = new Criteria();
        $criteria->add(TagI18n::TABLE . TagI18n::ISOLANG, $isoLang);
        $objTagI18n = new TagI18nPeer();
        $arrayObjTagI18n = $objTagI18n->doSelect($criteria);
        
        if (!is_object($arrayObjTagI18n) && count($arrayObjTagI18n == 0)) {
            $log = new Log();
            $log->setLog((__FILE__), 'There are no tags with that language ' . $isoLang, true);
            throw new Exception('There are no tags with that language ' . $isoLang);
        }
        
        foreach ($arrayObjTagI18n as $objTagI18nPeer) {
            $item = $xmlDoc->createElement('item');
            $item->setAttribute('idTagI18n', $objTagI18nPeer->getIdTagI18n());
            $item = $culture->appendChild($item);
            
            $title = $xmlDoc->createElement('tag', utf8_encode($objTagI18nPeer->getTag()));
            $title = $item->appendChild($title);
            
            $link = $xmlDoc->createElement('i18n', utf8_encode($objTagI18nPeer->getTranslate()));
            $link = $item->appendChild($link);
        }
        
        //header("Content-type:application/xml; charset=utf-8");
        $file = PATH . PATH_I18N . $isoLang . '.xml';
        
        try {
            file_put_contents($file, $xmlDoc->saveXML());
        } catch (Exception $e) {
            $log = new Log();
            $log->setLog((__FILE__), 'Unable to write the XML file I18n ' . $e->getMessage(), true);
        }
        
        return true;
    
    }

    public static function read($isoLang = 'pt_BR') {
        $file = PATH . PATH_I18N . $isoLang . '.xml';
        try {
            $xml = simplexml_load_file($file);
        } catch (Exception $e) {
            $log = new Log();
            $log->setLog((__FILE__), 'Could not open file [' . $file . '] for reading :' . $e->getMessage(), true);
            throw new Exception('Could not open file [' . $file . '] for reading ');
        }
        
        $count = count($xml->item);
        if($count == 0){
        	$log = new Log();
            $log->setLog((__FILE__), 'Open file [' . $file . '] is empty ', true);
        	throw new Exception('Open file [' . $file . '] is empty ');
        }
        
        return $xml->item;
    }

}
