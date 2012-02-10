<?php
#require_once '/usr/local/Zend/ZendStudio-7.2.1/plugins/com.zend.php.phpunit_7.2.0.v20100324-1300/resources/library/PHPUnit/Framework.php';

require_once ("/home/marco/public_html/Megiddo/Config/path_test.php");
require_once ("/home/marco/public_html/Megiddo/Config/db_test.php");
require_once ('/home/marco/public_html/Megiddo/Lib/Db/Peer.php');


function __autoload($classe) {
    require_once ('/home/marco/public_html/Megiddo/Lib/Mmvc/Content.php');
    require_once ('/home/marco/public_html/Megiddo/Lib/Mmvc/ViewActions.php');
    require_once ('/home/marco/public_html/Megiddo/Lib/Mmvc/Culture.php');
    require_once ('/home/marco/public_html/Megiddo/Lib/Mmvc/Template.php');
    require_once ('/home/marco/public_html/Megiddo/Lib/Mmvc/Log.php');
    require_once ('/home/marco/public_html/Megiddo/Lib/Mmvc/Url.php');
    require_once ('/home/marco/public_html/Megiddo/Lib/Mmvc/Db/CulturePeer.php');
    require_once ('/home/marco/public_html/Megiddo/Lib/Mmvc/Db/Criteria.php');
    require_once ('/home/marco/public_html/Megiddo/Lib/Mmvc/Db/Sql.php');
    require_once ('/home/marco/public_html/Megiddo/Lib/Mmvc/Db/LogPeer.php');
    
    require_once ('/home/marco/public_html/Megiddo/Lib/Db/Base/AbstractBase.php');
    require_once ('/home/marco/public_html/Megiddo/Lib/Db/Base/Base.php');

    require_once ('/home/marco/public_html/Megiddo/Lib/Db/Peer.php');
    
    require_once ('/home/marco/public_html/Megiddo/Lib/InvalidsArguments.php');
    
    
}