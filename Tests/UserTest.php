<?php
require_once 'autoLoadTest.php';

class UserTest extends PHPUnit_Framework_TestCase {

    /**
     * Conducting the test in class peer, checking if the repository returns the data correctly
     */
    public function testUserPeer() {
        $user = new User();
        $user->setAgreeTerms(true);
        $user->setEnable(true);
        $user->setGender(UserEnum::to_String(UserEnum::MALE));
        $user->setName('Marco Antonio Sugamele');
        $user->setVisible(true);
        $user->save();
       
        $userPeer = new UserPeer();
        $userPeer->searchByIdUser($user->getIdUser());
        $this->assertTrue($userPeer->get() instanceof  User);
        $userPeer->clear();
        $userPeer->searchByName('Marco');
        $userPeer->searchByGender(UserEnum::to_String(UserEnum::MALE));
        $userPeer->searchByAgreeTerms(true);
        $userPeer->searchByEnable(true);
        $userPeer->searchByVisible(true);
        $this->assertTrue($userPeer->get() instanceof User);
        
        $userPeer = new UserPeer();
        $userPeer->orderByAsc(UserBase::ID_USER);
        $userPeer->limit(1);
        $this->assertEquals($user->getIdUser(), $userPeer->get()->getIdUser());
        
        $userPeer = new UserPeer();
        $userPeer->orderByDesc(UserBase::ID_USER);
        $this->assertEquals($user->getIdUser(), $userPeer->get()->getIdUser());
        
        $userPeer = new UserPeer();
        $userPeer->orderByAsc(UserBase::ID_USER);
        $userPeer->limit(10);
        $this->assertEquals(1, count($userPeer->findAll()));
        
        $userPeer = new UserPeer();        
        $this->assertEquals(1, $userPeer->amountResults());
        $user->delete();
    }

    /**
     * Testing the Base class
     */
    public function testBaseUser() {
        $user = new User();
        $user->setAgreeTerms(true);
        $user->setEnable(true);
        $user->setGender(UserEnum::to_String(UserEnum::MALE));
        $user->setName('Marco Antonio Sugamele');
        $user->setVisible(true);
        $user->save();
        
        $objUser = UserBase::retriveByPk($user->getIdUser());
        $this->assertTrue($objUser instanceof  User);
        $user = $objUser;
        
        $objUser = new User();
        $objUser->setUser($user);
        $this->assertTrue($objUser->getUser() instanceof User);
        $this->assertEquals($objUser->getIdUser(), $user->getIdUser());
        
        $this->assertTrue($user->isAgreeTerms());
        $this->assertTrue($user->isEnable());
        $this->assertTrue($user->isVisible());
        $this->assertEquals('Marco Antonio Sugamele', $user->getName());
        $this->assertEquals(UserEnum::to_String(UserEnum::FULL_MALE), $user->getGender());

        
        $userPeer = new UserPeer();
        $userPeer->searchByName('Antonio Sugamele');
        $user = $userPeer->get();
        
        $user->setAgreeTerms(false);
        $user->setEnable(false);
        $user->setGender(UserEnum::to_String(UserEnum::FEMALE));
        $user->setName('Marquinho');
        $user->setVisible(false);
        $user->save();
        
        $userPeer = new UserPeer();
        $userPeer->searchByName('Marquinho');
        $user = $userPeer->get();
        
        $this->assertFalse($user->isAgreeTerms());
        $this->assertFalse($user->isEnable());
        $this->assertFalse($user->isVisible());
        $this->assertEquals('Marquinho', $user->getName());
        $this->assertEquals(UserEnum::to_String(UserEnum::FULL_FEMALE), $user->getGender());
        
        $user->delete();
       
    }
    
    /**
     * Testing the Enum class
     */
    public function testEnumUser() {
        $this->assertEquals(UserEnum::to_String(UserEnum::FEMALE),UserEnum::to_String(UserEnum::FULL_FEMALE));
        $this->assertEquals(UserEnum::to_String(UserEnum::FEMALE),UserEnum::to_String(UserEnum::FEMALE));
        $this->assertEquals(UserEnum::to_String(UserEnum::MALE),UserEnum::to_String(UserEnum::FULL_MALE));
        $this->assertEquals(UserEnum::to_String(UserEnum::MALE),UserEnum::to_String(UserEnum::MALE));
        $this->assertNull(UserEnum::to_String('Foo'));
        
        $this->assertEquals(UserEnum::to_Name(UserEnum::FEMALE),UserEnum::to_Name(UserEnum::FULL_FEMALE));
        $this->assertEquals(UserEnum::to_Name(UserEnum::FEMALE),UserEnum::to_Name(UserEnum::FEMALE));
        $this->assertEquals(UserEnum::to_Name(UserEnum::MALE),UserEnum::to_Name(UserEnum::FULL_MALE));
        $this->assertEquals(UserEnum::to_Name(UserEnum::MALE),UserEnum::to_Name(UserEnum::MALE));
        $this->assertNull(UserEnum::to_Name('Foo'));
    }

}

