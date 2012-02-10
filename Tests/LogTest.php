<?php
require_once 'autoLoadTest.php';

class LogTest extends PHPUnit_Framework_TestCase {

    private $objLog;

    public function __construct() {
        $this->objLog = new Log();
    }

    public function testInsert() {
        $test = false;
    	$this->objLog->setDate(date('Y-m-d H:i:s'));
        $this->objLog->setFile('test');
        $this->objLog->setIsError(true);
        $this->objLog->setMessage('Testing');
        $this->objLog->save();
        $bla = $this->objLog;
        $log = new Log();
        /* @var $objLog Log */
        $objLog = $log->retriveByDate(date('Y-m-d H:i:s'));
        if(count($objLog) > 0 ){
        	$test = true;
        }        
        $this->assertTrue($test);
        
        $objLog = new Log();
        $test = $objLog->retriveByError(true , 1);
        $this->assertType('ArrayObject',$test);
        
        $objLog = new Log();
        $test = $objLog->retriveByError(true);
        $this->assertType('ArrayObject',$test);
        
        $objLog = new Log();
        $obj = $objLog->retriveByPk($this->objLog->getId());
        $test = $obj->getId();
        $this->assertEquals($this->objLog->getId(),$test);
    }

    public function testUpDelete(){
    	$this->objLog->setLog('Test','testUpdadeDelete',false);
    	$criteria = new Criteria();
    	$criteria->add(LogPeer::MESSAGE, 'testUpdadeDelete');
    	$log = new Log();
    	/* @var $obj Log */
    	$obj = $log->doSelectOne($criteria);
    	$test = $obj instanceof Log;
    	$this->assertTrue($test);
    	$test = $obj->getId();
    	$log = new Log();
    	$log->setId($test);
    	$log->setMessage('removeTest');
    	$log->save();
    	
    	   	
    	$criteria = new Criteria();
        $criteria->add(LogPeer::MESSAGE, 'removeTest');
        $log = new Log();
        /* @var $obj Log */
        $obj = $log->doSelectOne($criteria);
        $this->assertEquals('removeTest',$obj->getMessage());
        $obj->delete();
    }
    
    public function testGets(){
    	$arrayObj = Log::retriveByDate(date('Y-m-d'),1);
    	$this->assertEquals('1',count($arrayObj));
    	
    	$arrayObj = $this->objLog->getLog();
    	$this->assertNotEquals('0',count($arrayObj));
    	
    	$arrayObj = $this->objLog->getLog(1);
        $this->assertEquals('1',count($arrayObj));
    	
    }
    
}

