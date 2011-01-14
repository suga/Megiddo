<?php
require_once 'autoLoadTest.php';

class CityTest extends PHPUnit_Framework_TestCase {

    private $city;

    public function __construct() {
        $this->city = new City();
    }

    /**
     * Conducting the test in class peer, checking if the repository returns the data correctly
     */
    public function testCityPeer() {
        $cityPeer = new CityPeer();
        $cityPeer->searchByIdCity('1');
        $this->assertTrue($cityPeer->get() instanceof  City);
        $cityPeer->clear();
        $cityPeer->searchByCityName('São Paulo');
        $cityPeer->searchByIdCountry(30);
        $cityPeer->searchByStateCode('sp');
        $cityPeer->searchByDdd(11);
        $this->assertTrue($cityPeer->get() instanceof  City);
        
        $cityPeer = new CityPeer();
        $cityPeer->orderByAsc(CityBase::ID_CITY);
        $cityPeer->limit(1);
        $this->assertEquals(1, $cityPeer->get()->getIdCity());
        
        $cityPeer = new CityPeer();
        $cityPeer->orderByDesc(CityBase::ID_CITY);
        $this->assertEquals(9181, $cityPeer->get()->getIdCity());
        
        $cityPeer = new CityPeer();
        $cityPeer->orderByAsc(CityBase::ID_CITY);
        $cityPeer->limit(10);
        $this->assertEquals(10, count($cityPeer->findAll()));
        
        $cityPeer = new CityPeer();        
        $this->assertEquals(5237, $cityPeer->amountResults());
    }

    /**
     * Testing the Base class
     */
    public function testBaseCity() {
        $city = CityBase::retriveByPk(8957);
        $this->assertTrue($city instanceof  City);
        $this->assertTrue($city->getCountry() instanceof Country);
        
        $city = new City();
        $city->setCity(CityBase::retriveByPk(8957));
        $this->assertTrue($city->getCity() instanceof  City);
        $this->assertEquals($city->getIdCity(), 8957);
        
        $city = new City();
        $city->setCity(CityBase::retriveByPk(8957));
        $this->assertEquals(8957, $city->getIdCity());
        $this->assertEquals(30, $city->getCity()->getCountry()->getIdCountry());
        $this->assertEquals('SÃO PAULO', $city->getCity()->getCityName());
        $city->setCityName('üatIbAiaç');
        $this->assertEquals('ÜATIBAIAÇ',$city->getCityName());
        $city->setStateCode('sa');
        $this->assertEquals('SA',$city->getStateCode());
        $city->setIdCountry(31);
        $this->assertTrue($city->getCountry() instanceof Country);
        
        $city = new City();
        $city->setCountry(CountryBase::retriveByPk(30));
        $this->assertTrue($city->getCountry() instanceof Country);
        $this->assertEquals($city->getIdCountry(), 30);
        $city->setDdd(12);
        $this->assertEquals(12,$city->getDdd());
        
        $city = new City();
        $city->setCityName('atibaiaUnitTest');
        $city->setStateCode('sp');
        $city->setIdCountry(30);
        $city->setDdd(11);
        $city->save();
        
        $cityPeer = new CityPeer();
        $cityPeer->searchByCityName('ATIBAIAUNITTEST');
        $this->assertTrue($cityPeer->get() instanceof City);
        $cityPeer = $cityPeer->get();
        $cityPeer->setCityName('PHPUNITTEST');
        $cityPeer->save();
        
        $cityPeer = new CityPeer();
        $cityPeer->searchByCityName('PHPUNITTEST');
        $this->assertTrue($cityPeer->get() instanceof City);
        $cityPeer = $cityPeer->get();
        $cityPeer->delete();
        $cityPeer = new CityPeer();
        $cityPeer->searchByCityName('PHPUNITTEST');
        $this->assertFalse($cityPeer->get() instanceof City);
        
        $this->assertEquals(5237,CityBase::getTotalRecords());
    }

}

