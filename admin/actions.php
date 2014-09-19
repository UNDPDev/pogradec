<?php
	require_once("../start.php");
	require_once("../config.php");
	require_once("db.php");
	require_once("../cls/cls_web_rights.php");
	
	$rights = new web_rights();
	
	$q="";if(isset($_REQUEST["q"])) $q = addslashes($_REQUEST["q"]);
	$s="0";if(isset($_REQUEST["s"])) $s = addslashes($_REQUEST["s"]);
	$a="";if(isset($_REQUEST["a"])) $a = addslashes($_REQUEST["a"]);
	$id=0;
	if(isset($_REQUEST["id"])) $id = addslashes($_REQUEST["id"]);
	
	if($id){
		$rights = $rights->get_by_id_rights($id);
	}
	
	if($a=="delete"){
		$rights->Delete();
		header("Location:actions.php");die();
	}
	if($_POST){
		$rights->action=$_POST["action"];
		$rights->description=$_POST["description"];
		
		if($id==0){ //insert
			$rights = $rights->Insert();
			$id = $rights->id_rights;
			}else{ //update
			$rights = $rights->Update();
		}
		header("Location:actions.php");die();	
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
		<meta name="description" content="Roles Edit" />
		<meta name="Publisher" content="www.dyqaniim.com" />
		<meta name="Author" content="Besmir Alia" />
		<meta name="copyright" content="www.dyqaniim.com 2013-2015" />
		<meta name="keywords" content="" />
		<meta name="robots" content="index, follow" />
		<meta name="abstract" content="Best Company for Web Design" />
		
		<link rel="shortcut icon" href="favicon.ico" />
		<title>Lista e roleve</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		
	</head>
	<body>
		<?php include_once("menu.php");?>
		<div id="main" class="container">
			<ol class="breadcrumb">
				<li><a href="./">Home</a></li>
				<li><a href="actions.php">Te drejtat</a></li>
			</ol>
			<div class="row">
				<div class="col-md-3">
					<form role="form" method="post">
						<div class="form-group">
							<label for="role">Action</label>
							<input type="text" class="form-control" id="action" name="action" placeholder="Action" value="<?php echo $rights->action;?>">
						</div>
						<div class="form-group">
							<label for="description">Pershkrimi</label>
							<input type="text" class="form-control" id="description" name="description" placeholder="Pershkrimi" value="<?php echo $rights->description;?>">
						</div>
						<button type="submit" class="btn btn-success">Ruaj</button>
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
								$rights = $rights->Find(" (action like '%".$q."%' or description like '%".$q."%' )  limit $s,20");
								foreach($rights as $rights){
									$id = $rights->id_rights;
								?>
								<tr>
									<td class="col-md-5">
									<label><input type="checkbox" id='chk_<?php echo $id;?>'></label>
									<?php for($i=0;$i<$j;$i++) echo "- ";?><?php echo $rights->action;?> 
									</td>
									<td class="col-md-4"><?php echo $rights->description;?></td>
									<td class="col-md-2"><a href="actions.php?id=<?php echo $id;?>" class="">Modifiko</a>&nbsp;|&nbsp;<a href="actions.php?a=delete&id=<?php echo $id;?>" class="text-danger">Fshi</a></td>
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