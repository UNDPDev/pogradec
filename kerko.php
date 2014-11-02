<?php
	require_once("start.php");
	require_once("config.php");
	require_once("db.php");	
	
	$a = "service";if(isset($_GET["a"])) { $a=$_GET["a"];}
	$q = "";if(isset($_GET["q"])) { $q=$_GET["q"];}
	switch($a){
		case "service":
		$query ="select id_service,service_name from web_service where service_name like '%".$q."%' and id_parent=0 and id_status=1";
		$res = mysql_query($query, $link) or die(mysql_error());
		$results = array();
		while ($row = mysql_fetch_array( $res )) {
			// All results onto a single array
			$results[] = $row;
		}
		// Supply header for JSON mime type
		header("Content-type: application/json");
		// Depending on how you want the JSON to look, you may wish to use
		// JSON_FORCE_OBJECT
		echo json_encode($results);
		mysql_close();
		break;
	}
?>