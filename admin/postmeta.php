<?php
	require_once("../start.php");
	require_once("../config.php");
	require_once("db.php");
	require_once("../cls/cls_web_postmeta.php");
	
	$postmeta = new web_postmeta();
	$id=0;$a="";
	if($_POST)
	{
		if(isset($_POST["id"])) $id = $_POST["id"]; else die("id? Per cilin postim?");
		if(isset($_POST["a"])) $a = $_POST["a"]; else die("a? Cfare veprimi?");
		
		switch($a)
		{
			case "add": {
				if(isset($_POST["mk"])) $mk = $_POST["mk"]; else die("mk? Meta Key?");
				if(isset($_POST["mv"])) $mv = $_POST["mv"]; else die("mv? Meta Value?");
				/*postmeta*/
				$postmeta = $postmeta->get_by_unique($id,$mk);
				$postmeta->post_id = $id;
				$postmeta->meta_key = $mk;
				$postmeta->meta_value = $mv;
				if($postmeta->meta_id) $postmeta->Update(); else $postmeta->Insert();
				break;
			}
			case "delete": {
				if(isset($_POST["mi"])) $mi = $_POST["mi"]; else die("mi? Per cilin postim?");
				$postmeta = $postmeta->get_by_meta_id($mi);
				$postmeta->Delete();
				break;
			}
		}
	}
?>