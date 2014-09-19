<?php
	require_once("../start.php");
	require_once("../config.php");
	
	if(
	isset($_SESSION["user_id"]) && $_SESSION["user_id"]>0 &&
	isset($_SESSION["user_name"]) && $_SESSION["user_name"] &&
	isset($_SESSION["id_role"]) && $_SESSION["id_role"]>0
	){
		header("Location:menuedit.php");die();
	}
	$msg="";
	if($_POST)
	{
		mysql_pconnect($TheServer,$TheUser,$ThePassword) or die(mysql_error());
		mysql_select_db($TheDatabase) or die (mysql_error());
		ini_set('date.timezone', 'Europe/Rome');
		
		$username = addslashes($_POST["username"]);
		$pass = $_POST["password"];
		$sql="select * from web_users where sha1(concat('".session_id()."',user_pass))='".$pass."' and user_login='".$username."'";
		$res = mysql_query($sql);
		
		if($r = mysql_fetch_array($res)){
			
				$_SESSION["user_id"]=$r["ID"];
				$_SESSION["user_name"]=$r["user_login"];
				$_SESSION["id_role"]=$r["id_role"];
				
				if ($_REQUEST["remember_me"])
				{
					setcookie("user_name", $username, time() + 30 * 24 * 60 * 60 * 1000 , "/");
				}
				
				header("Location:menuedit.php");
				die();
			
		}
		else
		{
			$msg="Te dhenat jane te pasakta";
		}
	}
	else
	{
		$username=$_COOKIE["user_name"];
	}
?>
<!DOCTYPE HTML>
<!--[if lt IE 7 ]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" class=""> <!--<![endif]-->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Paneli i administrimit" />
		<meta name="Publisher" content="www.dyqaniim.com" />
		<meta name="Author" content="Besmir Alia" />
		<meta name="copyright" content="www.dyqaniim.com 2013-2015" />
		<meta name="keywords" content="" />
		<meta name="robots" content="index, follow" />
		<meta name="abstract" content="Best Company for Web Design" />
		
		<link rel="shortcut icon" href="favicon.ico" />
		<title>Hyr ne panelin e administrimit</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha1.js"></script>
		<script>
			function encrypt()
			{
				var passw = CryptoJS.SHA1($("#password").val());
				var sess = "<?php echo session_id();?>";
				//alert(sess+passw);
				var encpass = CryptoJS.SHA1(sess+passw);
				$("#password").val(encpass);
				//alert(encpass);
				return true;
			}
		</script>
		<style>
			/* Credit to bootsnipp.com for the css for the color graph */
			.colorgraph {
			height: 5px;
			border-top: 0;
			background: #c4e17f;
			border-radius: 5px;
			background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
			background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
			background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
			background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
			}
		</style>
	</head>
	<body>
		<div class="container">
			
			<div class="row" style="margin-top:20px">
				<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
					<form role="form" action="" method="post" onsubmit="return encrypt();">
						<input type="hidden" id="sessid" name="sessid" value="<?php echo session_id();?>" />
						<fieldset>
							<h2>Hyrje ne sistem</h2>
							<?php if($msg) echo "<div class='alert alert-danger'>".$msg."</div>";?>
							<hr class="colorgraph">
							<div class="form-group">
								<input type="text" name="username" id="username" class="form-control input-lg" placeholder="Username" value="<?php echo $username;?>">
							</div>
							<div class="form-group">
								<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Fjalekalimi">
							</div>
							<span class="button-checkbox">
								<button type="button" class="btn" data-color="info">Me mbaj mend</button>
								<input type="checkbox" name="remember_me" id="remember_me" checked="checked" class="hidden">
								<a href="#" class="btn btn-link pull-right">Kam harruar fjalekalimin?</a>
							</span>
							<hr class="colorgraph">
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6">
									<input type="submit" class="btn btn-lg btn-success btn-block" value="Dergo">
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<a href="../" class="btn btn-lg btn-primary btn-block">Kthehu te faqja</a>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
			
		</div>
		<script src="js/checkboxes.js?v=2" type="text/javascript"></script>
	</body>
</html>