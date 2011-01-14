<?php
#require_once '/usr/local/Zend/ZendStudio-7.2.1/plugins/com.zend.php.phpunit_7.2.0.v20100324-1300/resources/library/PHPUnit/Framework.php';

require_once ("/home/marco/public_html/clicando/Config/path_test.php");
require_once ("/home/marco/public_html/clicando/Config/db_test.php");
require_once ('/home/marco/public_html/clicando/Lib/Db/Peer.php');


function __autoload($classe) {
    require_once ('/home/marco/public_html/clicando/Lib/Mmvc/Content.php');
    require_once ('/home/marco/public_html/clicando/Lib/Mmvc/ViewActions.php');
    require_once ('/home/marco/public_html/clicando/Lib/Mmvc/Culture.php');
    require_once ('/home/marco/public_html/clicando/Lib/Mmvc/Template.php');
    require_once ('/home/marco/public_html/clicando/Lib/Mmvc/Log.php');
    require_once ('/home/marco/public_html/clicando/Lib/Mmvc/Url.php');
    require_once ('/home/marco/public_html/clicando/Lib/Mmvc/Db/CulturePeer.php');
    require_once ('/home/marco/public_html/clicando/Lib/Mmvc/Db/Criteria.php');
    require_once ('/home/marco/public_html/clicando/Lib/Mmvc/Db/Sql.php');
    require_once ('/home/marco/public_html/clicando/Lib/Mmvc/Db/LogPeer.php');
    
    require_once ('/home/marco/public_html/clicando/Lib/Db/Base/AbstractBase.php');
    require_once ('/home/marco/public_html/clicando/Lib/Db/Base/Base.php');
    require_once ('/home/marco/public_html/clicando/Lib/Db/Base/CountryBase.php');
    require_once ('/home/marco/public_html/clicando/Lib/Db/Base/CityBase.php');
    require_once ('/home/marco/public_html/clicando/Lib/Db/Base/StateBase.php');
    require_once ('/home/marco/public_html/clicando/Lib/Db/Base/UserBase.php');
    require_once ('/home/marco/public_html/clicando/Lib/Db/Base/UserDocumentBase.php');
    require_once ('/home/marco/public_html/clicando/Lib/Db/Base/UserDocumentPeerBase.php');
    
    require_once ('/home/marco/public_html/clicando/Lib/Db/CountryPeer.php');
    require_once ('/home/marco/public_html/clicando/Lib/Db/Peer.php');
    require_once ('/home/marco/public_html/clicando/Lib/Db/CityPeer.php');
    require_once ('/home/marco/public_html/clicando/Lib/Db/StatePeer.php');
    require_once ('/home/marco/public_html/clicando/Lib/Db/UserPeer.php');
    require_once ('/home/marco/public_html/clicando/Lib/Db/UserDocumentPeer.php');    
    
    require_once ('/home/marco/public_html/clicando/Lib/InvalidsArguments.php');
    require_once ('/home/marco/public_html/clicando/Lib/Country.php');
    require_once ('/home/marco/public_html/clicando/Lib/City.php');
    require_once ('/home/marco/public_html/clicando/Lib/State.php');
    require_once ('/home/marco/public_html/clicando/Lib/User.php');
    require_once ('/home/marco/public_html/clicando/Lib/UserDocument.php');
    
    require_once ('/home/marco/public_html/clicando/Lib/Enum/UserEnum.php');
    
    
}