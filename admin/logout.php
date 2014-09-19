<?php
	session_start();
	$_SESSION["user_id"]=0;
	session_destroy();
	header("Location:./");
?>