<?php
require_once 'autoLoadTest.php';

class UrlTest extends PHPUnit_Framework_TestCase {

    private $objUrl;

    public function __construct() {
    	$_SERVER['SCRIPT_FILENAME'] = '/home/marco/public_html/mmvc/trunk/index.php';
        $_SERVER['DOCUMENT_ROOT'] = '/home/marco/public_html';
        $_SERVER["REQUEST_URI"] = '/mmvc/trunk/index.php/Default/index';
        $this->objUrl = new Url();        
    }

    public function testGets() {
    	$this->assertEquals('Default',$this->objUrl->getModule());
        $this->assertEquals('index',$this->objUrl->getAction());
        $this->assertEquals('Default',$this->objUrl->getModule());
        $objUrl = $this->setUrl('/mmvc/trunk/index.php/Default');
        $this->assertEquals('index',$objUrl->getAction());
        
        $_POST['test'] = 1234;
        $_SESSION['POST'] = serialize($_POST);
        $objUrl = $this->setUrl('/mmvc/trunk/index.php/Default/index/test/1234');
        $this->assertEquals('1234',$objUrl->getRequestParameter('test'));
        
        $_GET['test'] = 1234;
        $_SESSION['GET'] = serialize($_GET);
        $objUrl = $this->setUrl('/mmvc/trunk/index.php/Default/index/test/1234');
        $this->assertEquals('1234',$objUrl->getRequestParameter('test'));
        
        $objUrl = $this->setUrl('/mmvc/trunk/index.php/Default/index/test/1234');
        $test = $objUrl->getRequestParameter('test2');
        $this->assertNull($test);
        
    }
    
    private function setUrl($requestUri){
    	$_SERVER['SCRIPT_FILENAME'] = '/home/marco/public_html/mmvc/trunk/index.php';
        $_SERVER['DOCUMENT_ROOT'] = '/home/marco/public_html';
        $_SERVER["REQUEST_URI"] = $requestUri;
        return new Url();
    }

}

