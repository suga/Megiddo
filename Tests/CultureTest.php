<?php
require_once 'autoLoadTest.php';

class CultureTest extends PHPUnit_Framework_TestCase {

    private $objCulture;

    public function __construct() {
        $this->objCulture = new Culture();
    }

    public function testGetCultureEmpty() {
        $this->objCulture->setCulture('');
        $test = $this->objCulture->getCulture();
        $this->assertEquals('pt_BR', $test);
    }

    public function testGetCulture() {
        $this->objCulture->setCulture('en_US');
        $test = $this->objCulture->getCulture();
        $this->assertEquals('en_US', $test);
    }

    public function testGetByPk() {
        /* @var $objTest Culture */
        $objTest = Culture::retriveByPk('pt_BR');
        $test = $objTest->getCulture();
        $this->assertEquals('pt_BR', $test);
    }

    public function testRetriveDefaultCulture() {
        $objTest = Culture::retriveDefaultCulture();
        $this->assertEquals('pt_BR', $objTest);
    }

    public function testRetriveDefaultCultureError() {
        $criteria = new Criteria();
        $criteria->add(CulturePeer::TABLE . CulturePeer::DEFAULT_CULTURE, true);
        $Culture = new Culture();
        $objCulture = $Culture->doSelectOne($criteria);
        $objCulture->setDefault(false);
        $objCulture->save();
        
        $test = Culture::retriveDefaultCulture();
        
        $criteria->clear();
        $criteria->add(CulturePeer::TABLE . CulturePeer::ISOLANG, 'pt_BR');
        $objCulture = new Culture();
        $objCulture = $objCulture->doSelectOne($criteria);
        $objCulture->setDefault(true);
        $objCulture->save();
        
        $this->assertEquals('pt_BR', $test);
    
    }

    public function testHasCultureEmpty() {
        $test = $this->objCulture->hasCulture('');
        $this->assertFalse($test);
    }

    public function testHasCulture() {
        $test = $this->objCulture->hasCulture('pt_BR');
        $this->assertTrue($test);
    }

    public function testHasCultureError() {
        $test = $this->objCulture->hasCulture('it_IT');
        $this->assertFalse($test);
    }

    public function testCheckCulture() {
        $test = $this->objCulture->checkCulture('pt_BR');
        $this->assertContains('pt_BR', $test);
    }

    public function testCheckCultureError() {
        $test = $this->objCulture->checkCulture('it_IT');
        $this->assertContains('pt_BR', $test);
    }

    public function testGetAllCultures() {
        $test = $this->objCulture->getAllCultures();
        $test = $test[0]->getIsoLang();
        $this->assertEquals('en_US', $test);
    }

    public function testReturnArrayLanguages() {
        $test = $this->objCulture->returnArrayLanguages();
        $this->assertArrayHasKey('pt_BR', $test);
    }
    
    public function testHasDefault(){
    	$test = $this->objCulture->hasDefault();
    	$this->assertFalse($test);
    }

    public function testHasDefaultOk(){
    	$this->objCulture->setDefault('pt_BR');
    	$test = $this->objCulture->hasDefault();
        $this->assertTrue($test);
    }
    
    public function testHasDefaultNotExists(){
        $this->objCulture->setDefault('it_IT');
        $test = $this->objCulture->hasDefault();
        $this->assertTrue($test);
    }
    
    public function testInsertCulture(){
    	$this->objCulture->setDefault(false);
    	$this->objCulture->setIsoLang('es_ES');
    	$this->objCulture->save();
    	
    	/* @var $obj Culture */
    	$obj = CulturePeer::retriveByPk('es_ES');
    	$test = $obj->getIsoLang();
    	$obj->delete();
    	$this->assertEquals('es_ES',$test);
    }
}

