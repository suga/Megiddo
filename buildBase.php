<?php
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

$schema = sfYaml::load(PATH . 'Config/schema.yml');

$base = new CreateBase($schema);
$base->Create();

$peer = new CreatePeerBase($schema);
$peer->Create();

$class = new CreateClass($schema);
$class->Create();
