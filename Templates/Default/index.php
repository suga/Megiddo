<?php
Template::includeTemplate('Default','Head.php');
echo '<br>'. I18n::translate('no.layout.test',$var->culture) . '<br>';
echo time();
var_dump($var->var1);
var_dump($var->var2);
var_dump($var->var3);
var_dump($var->var4);
var_dump($var->var5,$var->var6);
var_dump($var->var7);
var_dump($var->var8);
var_dump($var->var9);
var_dump($var->var10);
?>