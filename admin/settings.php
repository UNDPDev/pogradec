<?php
	require_once("../start.php");
	require_once("../config.php");
	require_once("db.php");
	require_once("../cls/cls_web_options.php");
	
	$sett = new web_options();
	
	$q="";if(isset($_REQUEST["q"])) $q = addslashes($_REQUEST["q"]);
	$p="0";if(isset($_REQUEST["p"])) $p = addslashes($_REQUEST["p"]);
	$o="0";if(isset($_REQUEST["o"])) $o = addslashes($_REQUEST["o"]);
	$link="#";if(isset($_REQUEST["link"])) $link = addslashes($_REQUEST["link"]);
	$a="";if(isset($_REQUEST["a"])) $a = addslashes($_REQUEST["a"]);
	$id=0;
	if(isset($_REQUEST["id"])) $id = addslashes($_REQUEST["id"]);
	
	if($id){
		$sett = $sett->get_by_option_id($id);
	}
	if($a=="delete"){
		$sett->Delete();
		header("Location:settings.php");die();
	}
	if($_POST){
		$sett->option_name=$_POST["option_name"];
		$sett->option_value=$_POST["option_value"];
		
		if($id==0){ //insert
			$sett = $sett->Insert();
			$id = $sett->option_id;
		}else{ //update
			$sett = $sett->Update();
		}
		header("Location:settings.php");die();	
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
		<meta name="description" content="Menu Edit" />
		<meta name="Publisher" content="www.dyqaniim.com" />
		<meta name="Author" content="Besmir Alia" />
		<meta name="copyright" content="www.dyqaniim.com 2013-2015" />
		<meta name="keywords" content="" />
		<meta name="robots" content="index, follow" />
		<meta name="abstract" content="Best Company for Web Design" />
		
		<link rel="shortcut icon" href="favicon.ico" />
		<title>Opsione te pergjithshme</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css" />
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/simplex/bootstrap.min.css" type="text/css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		
	</head>
	<body>
		<?php include_once("menu.php");?>
		<div id="main" class="container">
			<ol class="breadcrumb">
				<li><a href="./">Home</a></li>
				<li><a href="settings.php"><?php echo ucwords($sett->option_name);?></a></li>
			</ol>
			<div class="row">
				<div class="col-md-3">
					<form role="form" method="post">
						<div class="form-group">
							<label for="option_name">Option Name</label>
							<input type="text" class="form-control" id="option_name" name="option_name" placeholder="Option Name" value="<?php echo $sett->option_name;?>">
						</div>
						<div class="form-group">
							<label for="option_value">Option Value</label>
							<textarea class="form-control" id="option_value" name="option_value" rows="4"><?php echo $sett->option_value;?></textarea>
						</div>
						<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> Ruaj</button>
						<a href="settings.php" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> Krijo tjeter</a>
					</form>
				</div>
				<div class="col-md-9">
					<div class="panel panel-default">
						<!-- Default panel contents -->
						<div class="panel-heading">
							<div class="row">
								<div class="col-md-4 form-inline">
									<label class="sr-only" for="chk_all"></label><input type="checkbox" id='chk_all'>
									<div class="form-group">
										<select class="form-control">
											<option value='0' >Zgjidh Opsionin</option>
											<option value='1' >Modifiko</option>
											<option value='2' >Fshi</option>
										</select>
									</div>
									<button type="button" class="btn btn-default">Apliko</button>
								</div>
								<div class="col-md-6">
									<form class="form-inline pull-right" role="form">
										<div class="form-group">									
											<input type="search" class="form-control" id="q" name="q" placeholder="Kerko" value="<?php echo $q;?>">
										</div>
										<button type="submit" class="btn btn-default">Kerko</button>
									</form>
								</div>
								<div class="">
									
								</div>
							</div>
							
						</div>
						
						<!-- Table -->
						<table class="table table-hover">
							<?php
							
								$setts = $sett->Find("(option_name like '%".$q."%' or option_value like '%".$q."%' ) order by 2");
								foreach($setts as $sett){
									$id = $sett->option_id;
								?>
								<tr>
									<td class="col-md-3">
									<label><input type="checkbox" id='chk_<?php echo $id;?>'></label>
									<?php echo $sett->option_name;?> 
									</td>
									<td class="col-md-3"><?php echo $sett->option_value;?></td>
									<td class="col-md-2"><a href="settings.php?id=<?php echo $id;?>" type="button" class="btn btn-info btn-xs" title="Modifiko"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;<a href="settings.php?a=delete&id=<?php echo $id;?>" type="button" class="btn btn-danger btn-xs" title="Delete"><span class="glyphicon glyphicon-trash"></span></a></td>
								</tr>
								<?php
								}
							?>	
						</table>
						<div class="panel-footer">
							<div>
								<ul class="pagination pagination-sm">
									<li class="previous disabled"><a href="#">&larr;&nbsp;</a></li>
									<li class="next"><a href="#">&nbsp;&rarr;</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
			<script src="js/holder.js"></script>
		</body>
	<html>				