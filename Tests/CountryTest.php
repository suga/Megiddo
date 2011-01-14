<?php
require_once 'autoLoadTest.php';

class CountryTest extends PHPUnit_Framework_TestCase {

    private $country;

    public function __construct() {
        $this->country = new Country();
    }

    /**
     * Conducting the test in class peer, checking if the repository returns the data correctly
     */
    public function testCountryPeer() {
        $countryPeer = new CountryPeer();
        $countryPeer->searchByIdCountry(1);
        $objCountry = $countryPeer->get();
        $this->assertTrue($objCountry instanceof Country);
        
        $countryPeer->clear();
        $countryPeer->searchByCountryIso('BRA');
        $objCountry = $countryPeer->get();
        $this->assertTrue($objCountry instanceof Country);
        
        $countryPeer->clear();
        $countryPeer->searchByIsolang('pt_BR');
        $objCountry = $countryPeer->get();
        $this->assertTrue($objCountry instanceof Country);
        
        $countryPeer->clear();
        $countryPeer->searchByCountryName('Brasil');
        $objCountry = $countryPeer->get();
        $this->assertTrue($objCountry instanceof Country);
        
        $countryPeer->clear();
        $countryPeer->orderByAsc(CountryPeer::ID_COUNTRY);
        $objCountry = $countryPeer->get();
        $this->assertEquals(1, $objCountry->getIdCountry());
        
        $countryPeer->clear();
        $countryPeer->orderByDesc(CountryPeer::ID_COUNTRY);
        $objCountry = $countryPeer->get();
        $this->assertEquals(239, $objCountry->getIdCountry());
        
        $countryPeer = new CountryPeer();
        $countryPeer->orderByAsc(CountryPeer::ID_COUNTRY);
        $arrayCountry = $countryPeer->findAll();
        $this->assertEquals(239, count($arrayCountry));
        
        $countryPeer = new CountryPeer();
        $arrayCountry = $countryPeer->amountResults();
        $this->assertEquals(239, $arrayCountry);
    }

    /**
     * Testing the Base class
     */
    public function testBaseCountry() {
        $country = CountryBase::retriveByPk(30);
        $this->assertTrue($country instanceof Country);
        
        $country = new Country();
        $country->setIdCountry(30);
        $this->assertTrue($country->getCountry() instanceof Country);
        $this->assertEquals(30, $country->getCountry()->getIdCountry());
        
        try {
            $country->setIdCountry(3000);
            $this->fail();
        } catch (Exception  $e) {
            $this->assertTrue(true);
        }
        
        $country = CountryBase::retriveByPk(30);
        $country2 = new Country();
        $country2->setCountry($country);
        $this->assertEquals(30,$country2->getCountry()->getIdCountry());
        
        $country = new Country();
        $country->setCountryName('FooTest');
        $country->setIsolang('pt_MM');
        $country->setCountryIso('BLA');
        $country->save();
        if($country->getIdCountry() > 239){
            $this->assertTrue(true);
        }else{
            $this->fail();
        }
    
        $country->delete();
        $countryPeer = new CountryPeer();
        $countryPeer->orderByDesc(CountryPeer::ID_COUNTRY);
        $objCountry = $countryPeer->get();
        $this->assertEquals(239, $objCountry->getIdCountry());
        
        $country = new Country();
        $country->setCountryName('Brazil');
        $country->setIdCountry(30);
        $country->save();
        
        $country = CountryBase::retriveByPk(30);
        $this->assertEquals('Brazil',$country->getCountryName());
        
        $country->setCountryName('Brasil');
        $country->setIdCountry(30);
        $country->save();
        
        $country = CountryBase::retriveByPk(30);
        $this->assertEquals('Brasil',$country->getCountryName());
        
    }

}

