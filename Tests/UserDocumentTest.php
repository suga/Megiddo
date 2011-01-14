<?php
require_once 'autoLoadTest.php';

class UserDocumentTest extends PHPUnit_Framework_TestCase {

    /**
     * Conducting the test in class peerBase, checking if the repository returns the data correctly
     */
    public function testDocumentPeerBase() {
        $user = new User();
        $user->setAgreeTerms(true);
        $user->setEnable(true);
        $user->setGender(UserEnum::to_String(UserEnum::MALE));
        $user->setName('Marco Antonio Sugamele');
        $user->setVisible(true);
        $user->save();
        
        $userDocument = new UserDocument();
        $userDocument->setIdUser($user->getIdUser());
        $userDocument->setCpf('309.352.918-22');
        $userDocument->save();
        
        $userDocumentPeer = new UserDocumentPeer();
        $userDocumentPeer->searchByIdUser($user->getIdUser());
        $userDocumentPeer->searchByCpf('309.352.918-22');
        $result = $userDocumentPeer->get();
        
        $this->assertTrue($result instanceof UserDocument);
        
        $user->delete();
    }

    

}

