<?php
require_once 'autoLoadTest.php';

class TemplateTest extends PHPUnit_Framework_TestCase {

    private $objTemplate;

    public function __construct() {
        $this->objTemplate = new Template();
    }

    public function testIncludeTemplate(){
    	ob_start();
    	Template::includeTemplate('Default','Head.php');
    	$test = ob_get_contents();
    	ob_end_clean();
    	$this->assertEquals('REQUIRE SUCCESS!!!',$test);
    }
    
    public function testIncludeTemplateFail(){
        ob_start();
        try{
            Template::includeTemplate('Default','Fail.php');
        }catch (Exception $e){        
            	
        }
        $test = ob_get_contents();        
        ob_end_clean();
        $this->assertNotContains('REQUIRE SUCCESS!!!',$test);
    }
    
    public function testGetPathLayoutFail(){
    	$test = $this->objTemplate->setLayout();
    	$this->assertFalse($test);
    }
    
    public function testGetPathLayoutFail2(){
        $this->objTemplate->setLayout('Default');
        $test = $this->objTemplate->getPathLayout();
        $this->assertNull($test);
    }
    
    public function testGetPath(){
    	$this->objTemplate->setAction('Default');
    	$this->objTemplate->setModule('Default');
        $this->objTemplate->setLayout('Default');
        $test = $this->objTemplate->getPathLayout();
        $test1 = PATH.PATH_LAYOUTS.'Default/Default.php';
        $this->assertEquals($test1,$test);
    }
    
    public function testGetDefaultLayout(){
    	$test = $this->objTemplate->getDefaultLayout();
    	$this->assertEquals('Index',$test);
    }
    
    public function testGetLayoutPersonalite(){
        $this->objTemplate->setLayoutPersonalite('Test', 'Test');
        $test  = $this->objTemplate->getPathLayout();
        $test1 = PATH.PATH_LAYOUTS.'Test/Test.php';
        $this->assertEquals($test1,$test);
    }
    
    public function testSetLayoutPersonalite(){
    	$test = $this->objTemplate->setLayoutPersonalite('', 'Test');
    	$this->assertFalse($test);
    }
    
    public function testSetLayoutPersonalite2(){
        $this->objTemplate->setLayoutPersonalite('Test', '');
        $test = $this->objTemplate->getPathLayout();
        $test1 = PATH.PATH_LAYOUTS.'Default/Index.php';
        $this->assertEquals($test1,$test);
    }
}

