<?php
global $link;
$link = mysql_connect($TheServer,$TheUser,$ThePassword)
or die(mysql_error());
mysql_select_db($TheDatabase)
or die (mysql_error());
ini_set('date.timezone', 'Europe/Rome');
global $root_path;
$root_path="";
?>