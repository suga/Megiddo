<?php
ini_set('display_errors', 'ON');
isset($_SESSION) ? '' : session_start();
header('Content-type: text/html; charset=utf-8');
require ("Config/path.php");
require ("Config/errors.php");
require ("Config/db.php");
require ("Lib/Mmvc/Autoload.php");

/* @var $autoLoad Autoload */
$autoLoad = new Autoload();

function __autoload($class_name) {
    if (!class_exists($class_name)) {
        require $class_name . '.php';
    }
}

if (!array_key_exists('objContent', $_SESSION)) {
    $objContent = new Content();
    $_SESSION['objContent'] = serialize($objContent);
}
new View($autoLoad);
