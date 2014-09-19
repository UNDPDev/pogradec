<?php
	require_once("../start.php");
	require_once("../config.php");
	require_once("db.php");
	require_once("../cls/cls_web_roles.php");
	require_once("../cls/cls_web_rights.php");
	require_once("../cls/cls_web_rolerights.php");
	
	$roles = new web_roles();
	$rights = new web_rights();
	$rolerights = new web_rolerights();
	
	$q="";if(isset($_REQUEST["q"])) $q = addslashes($_REQUEST["q"]);
	$s="0";if(isset($_REQUEST["s"])) $s = addslashes($_REQUEST["s"]);
	$a="";if(isset($_REQUEST["a"])) $a = addslashes($_REQUEST["a"]);
	$id=0;
	if(isset($_REQUEST["id"])) $id = addslashes($_REQUEST["id"]);
	
	if($id){
		$roles = $roles->get_by_id_role($id);
	}
	
	if($a=="delete"){
		$roles->Delete();
		header("Location:roles.php");die();
	}
	if($_POST){
		$roles->role=$_POST["role"];
		$roles->description=$_POST["description"];
		
		if($id==0){ //insert
			$roles = $roles->Insert();
			$id = $roles->id_role;
			}else{ //update
			$roles = $roles->Update();
		}
		//set rights
		$res = mysql_query("DELETE FROM web_rolerights WHERE id_role='".$id."'");
		
		while(list($key,$val) = each($_POST["id_rights"]))
		{
			$rolerights = new web_rolerights();
			$rolerights->id_role=$id;
			$rolerights->id_rights=$val;
			$rolerights->Insert();
		}
		header("Location:roles.php?id=".$id);die();	
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
				<li><a href="roles.php?t=<?php echo $t;?>"><?php echo ucwords($t);?></a></li>
			</ol>
			<div class="row">
				<div class="col-md-3">
					<form role="form" method="post">
						<div class="form-group">
							<label for="role">Roli</label>
							<input type="text" class="form-control" id="role" name="role" placeholder="Roli" value="<?php echo $roles->role;?>">
						</div>
						<div class="form-group">
							<label for="description">Pershkrimi</label>
							<input type="text" class="form-control" id="description" name="description" placeholder="Pershkrimi" value="<?php echo $roles->description;?>">
						</div>
						<div class="form-group">
							<label for="id_rights">Te drejtat</label>
							<select name="id_rights[]" id="id_rights" size="15" multiple="multiple" style="width:100%">
							<?php
							$rights = $rights->GetAll();
							if(count($rights))
							foreach($rights as $action)
							{
								echo "<option value='".$action->id_rights."' ";
								if($id){
									$rolerights = new web_rolerights();
									$rolerights = $rolerights->get_by_unique($id,$action->id_rights);
									if($rolerights->id_rolerights) echo "selected='selected'";
								}
								echo ">".$action->action." - ".$action->description."</option>";
							}
							?>
							</select>
							
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
								$roles = $roles->Find(" (role like '%".$q."%' or description like '%".$q."%' )  limit $s,20");
								foreach($roles as $roles){
									$id = $roles->id_role;
								?>
								<tr>
									<td class="col-md-5">
									<label><input type="checkbox" id='chk_<?php echo $id;?>'></label>
									<?php for($i=0;$i<$j;$i++) echo "- ";?><?php echo $roles->role;?> 
									</td>
									<td class="col-md-4"><?php echo $roles->description;?></td>
									<td class="col-md-2"><a href="roles.php?id=<?php echo $id;?>" class="">Modifiko</a>&nbsp;|&nbsp;<a href="roles.php?a=delete&id=<?php echo $id;?>" class="text-danger">Fshi</a></td>
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