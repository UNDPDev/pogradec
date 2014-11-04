<?php
require_once("start.php");
require_once("config.php");
require_once("db.php");
require_once("../cls/cls_web_service.php");

$service = new web_service();
$return = array();
$q="";if(isset($_REQUEST["q"])) {$q = addslashes($_REQUEST["q"]); $id_category = addslashes($_REQUEST["id_category"]); } 
$posts = $service->Find(" service_name like '%".$q."%' and id_parent!=0 and id_category=".$id_category." order by id_service desc limit 20",$GLOBALS['con']);
foreach($posts as $service){
    $return[] = $service->service_name;
}

$json = json_encode($return);
print_r($json);
?>