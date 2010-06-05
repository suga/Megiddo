<?php
require_once '/usr/share/php/PHPUnit/Framework.php';

require_once ("/home/marco/public_html/mmvc/trunk/Config/path_test.php");
require_once ("/home/marco/public_html/mmvc/trunk/Config/db_test.php");


function __autoload($classe) {
    require_once ('/home/marco/public_html/mmvc/trunk/Lib/Mmvc/Content.php');
    require_once ('/home/marco/public_html/mmvc/trunk/Lib/Mmvc/ViewActions.php');
    require_once ('/home/marco/public_html/mmvc/trunk/Lib/Mmvc/Culture.php');
    require_once ('/home/marco/public_html/mmvc/trunk/Lib/Mmvc/Template.php');
    require_once ('/home/marco/public_html/mmvc/trunk/Lib/Mmvc/Log.php');
    require_once ('/home/marco/public_html/mmvc/trunk/Lib/Mmvc/Db/CulturePeer.php');
    require_once ('/home/marco/public_html/mmvc/trunk/Lib/Mmvc/Db/Criteria.php');
    require_once ('/home/marco/public_html/mmvc/trunk/Lib/Mmvc/Db/Sql.php');
    require_once ('/home/marco/public_html/mmvc/trunk/Lib/Mmvc/Db/LogPeer.php');
}