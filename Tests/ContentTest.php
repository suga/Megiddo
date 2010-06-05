<?php
require_once 'autoLoadTest.php';

class ContentTest extends PHPUnit_Framework_TestCase {

    private $objContent;

    public function __construct() {
        $this->objContent = new Content();
    }

    public function testContentSetHasLayoutFalse() {
        $this->objContent->setHasLayout(ViewActions::VIEW_NONE);
        $test = $this->objContent->hasLayout();
        $this->assertFalse($test);
    }

    public function testContentSetHasLayoutSuccess() {
        $this->objContent->setHasLayout(ViewActions::VIEW_SUCCESS);
        $test = $this->objContent->hasLayout();
        $this->assertTrue($test);
    }

    public function testContentSetHasLayoutError() {
        $this->objContent->setHasLayout(ViewActions::VIEW_ERROR);
        $test = $this->objContent->hasLayout();
        $this->assertTrue($test);
    }

    public function testContentSetHasLayoutOther() {
        $this->objContent->setHasLayout('Other');
        $test = $this->objContent->hasLayout();
        $this->assertTrue($test);
    }

    public function testTypeLayoutError() {
        $this->objContent->typeLayout(ViewActions::VIEW_ERROR);
        $test = $this->objContent->getTypeLayout();
        $this->assertContains('ERROR', $test);
    }

    public function testTypeLayoutOther() {
        $this->objContent->typeLayout('Other');
        $test = $this->objContent->getTypeLayout();
        $this->assertEquals('', $test);
    }

    public function testGetObjCultureWithObject() {
        $objCulture = new Culture();
        $objCulture->setCulture('pt_BR');
        $this->objContent->setCulture($objCulture);
        $test = $this->objContent->getObjCulture()->getCulture();
        $this->assertEquals('pt_BR', $test);
    }

    public function testGetObjCultureNoObject() {
        $test = $this->objContent->getObjCulture()->getCulture();
        $this->assertEquals('pt_BR', $test);
    }

    public function testSetAttributeEmpty() {
        $test = $this->objContent->setAttribute('');
        $this->assertFalse($test);
    }

    public function testGetAttributeNoValue() {
        $this->objContent->setAttribute('test');
        $test = $this->objContent->getAttribute('test');
        $this->assertNull($test);
    }

    public function testGetAttributeValue() {
        $this->objContent->setAttribute('test', 'myTest');
        $test = $this->objContent->getAttribute('test');
        $this->assertEquals('myTest', $test);
    }

    public function testGetAttributeInvalid() {
        $this->objContent->setAttribute('test', 'myTest');
        $test = $this->objContent->getAttribute('other');
        $this->assertNull($test);
    }

    public function testSetFlushEmpty() {
        $test = $this->objContent->setFlush('');
        $this->assertFalse($test);
    }

    public function testGetFlushNoValue() {
        $this->objContent->setFlush('test');
        $test = $this->objContent->getFlush('test');
        $this->assertNull($test);
    }

    public function testGetFlushValue() {
        $this->objContent->setFlush('test', 'myTest');
        $test = $this->objContent->getFlush('test');
        $this->assertEquals('myTest', $test);
    }

    public function testGetFlushInvalid() {
        $this->objContent->setFlush('test', 'myTest');
        $test = $this->objContent->getFlush('other');
        $this->assertNull($test);
    }

    public function testGetFlush2x() {
        $this->objContent->setFlush('test', 'myTest');
        $this->objContent->getFlush('test');
        $test = $this->objContent->getFlush('test');
        $this->assertNull($test);
    }
    
    public function testGetTemplateNoObject(){
    	$test = $this->objContent->getObjTemplate();
    	$this->assertObjectHasAttribute('action',$test);
    }
    
    public function testGetTemplateWithObject(){
    	$this->objContent->setTemplate(new Template());
        $test = $this->objContent->getObjTemplate();
        $this->assertObjectHasAttribute('action',$test);
    }
    
    public function testGetInformationLoad(){
    	$this->objContent->setInformationLoad(array('test' => 'myTest'));
    	$test = $this->objContent->getInformationLoad();
    	$this->assertArrayHasKey('test',$test);
    }

}

