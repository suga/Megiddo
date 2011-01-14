<?php
require_once 'autoLoadTest.php';

class StateTest extends PHPUnit_Framework_TestCase {

    /**
     * Conducting the test in class peer, checking if the repository returns the data correctly
     */
    public function testStatePeer() {
        $statePeer = new StatePeer();
        $statePeer->searchByIdSate('1');
        $this->assertTrue($statePeer->get() instanceof  State);
        $statePeer->clear();
        $statePeer->searchByStateName('SP');
        $statePeer->searchByIdCountry(30);
        $statePeer->searchByStateCode('SP');
        $this->assertTrue($statePeer->get() instanceof  State);
        
        $statePeer = new StatePeer();
        $statePeer->orderByAsc(StateBase::ID_STATE);
        $statePeer->limit(1);
        $this->assertEquals(1, $statePeer->get()->getIdState());
        
        $statePeer = new StatePeer();
        $statePeer->orderByDesc(StateBase::ID_STATE);
        $this->assertEquals(27, $statePeer->get()->getIdState());
        
        $statePeer = new StatePeer();
        $statePeer->orderByAsc(StateBase::ID_STATE);
        $statePeer->limit(10);
        $this->assertEquals(10, count($statePeer->findAll()));
        
        $statePeer = new StatePeer();        
        $this->assertEquals(27, $statePeer->amountResults());
    }

    /**
     * Testing the Base class
     */
    public function testBaseState() {
        $state = StateBase::retriveByPk(24);
        $this->assertTrue($state instanceof  State);
        $this->assertTrue($state->getCountry() instanceof Country);
        
        $state = new State();
        $state->setState(StateBase::retriveByPk(24));
        $this->assertTrue($state->getState() instanceof  State);
        $this->assertEquals($state->getIdState(), 24);
        
        $state = new State();
        $state->setState(StateBase::retriveByPk(24));
        $this->assertEquals(24, $state->getIdState());
        $this->assertEquals(30, $state->getState()->getCountry()->getIdCountry());
        $this->assertEquals('SP', $state->getState()->getStateName());
        $this->assertEquals('SP', $state->getState()->getStateCode());
        $state->setStateName('sp');
        $this->assertEquals('SP',$state->getStateName());
        $state->setStateCode('sa');
        $this->assertEquals('SA',$state->getStateCode());
        $state->setIdCountry(31);
        $this->assertTrue($state->getCountry() instanceof Country);
        
        $state = new State();
        $state->setCountry(CountryBase::retriveByPk(30));
        $this->assertTrue($state->getCountry() instanceof Country);
        $this->assertEquals($state->getIdCountry(), 30);
        
        $state = new State();
        $state->setStateName('MM');
        $state->setStateCode('sp');
        $state->setIdCountry(30);
        $state->save();
        
        $StatePeer = new StatePeer();
        $StatePeer->searchByStateName('MM');
        $this->assertTrue($StatePeer->get() instanceof State);
        $StatePeer = $StatePeer->get();
        $StatePeer->setStateName('NN');
        $StatePeer->save();
        
        $StatePeer = new StatePeer();
        $StatePeer->searchByStateName('NN');
        $this->assertTrue($StatePeer->get() instanceof State);
        $StatePeer = $StatePeer->get();
        $StatePeer->delete();
        $StatePeer = new StatePeer();
        $StatePeer->searchByStateName('NN');
        $this->assertFalse($StatePeer->get() instanceof State);
        
        $this->assertEquals(27,StateBase::getTotalRecords());
    }

}

