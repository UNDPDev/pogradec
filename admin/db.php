<?php
mysql_pconnect($TheServer,$TheUser,$ThePassword)
or die(mysql_error());
mysql_select_db($TheDatabase)
or die (mysql_error());
ini_set('date.timezone', 'Europe/Rome');

include_once('../functions.php');
global $root_path;
$root_path=get_option_value("site_url");

if(!(isset($_SESSION["user_id"]) && $_SESSION["user_id"]>0))
{
	header("Location:./");
}

function checkAccess($action)
{
	$res = mysql_query("select * from web_rolerights rr inner join web_rights r on rr.id_rights=r.id_rights where rr.id_role='".$_SESSION["id_role"]."' and action='".$action."'");
	if(mysql_fetch_array($res)) return 1;
	
	return 0;
}

?>