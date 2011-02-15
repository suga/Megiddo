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

if($_POST['module']) {
	$createModule = new CreateModule();
	if($createModule->newModule($_POST['module'])) {
		echo 'Module successfully created';
	}

}

?>
<form name="module" action="buildModule.php" method="POST">
	<label>
		To create a new module, type its name in the field below
	</label>
	<br>	
	<input type="text" name="module" value="">
	<input type="submit" value="ok">
</form>