<?php
	require_once("../start.php");
	require_once("../config.php");
	require_once("db.php");
	require_once("../cls/cls_web_users.php");
	include_once("../cls/cls_web_roles.php");
	global $root_path;
		
	if(!(checkAccess("USERS"))) die("Not allowed <a href='index.php'>Login</a>");
	
	$users = new web_users();
	$role = new web_roles();
	
	$q="";if(isset($_REQUEST["q"])) $q = addslashes($_REQUEST["q"]);
	$s="0";if(isset($_REQUEST["s"])) $s = addslashes($_REQUEST["s"]);
	$a="";if(isset($_REQUEST["a"])) $a = addslashes($_REQUEST["a"]);
	$id=0;
	if(isset($_REQUEST["id"])) $id = addslashes($_REQUEST["id"]);
	
	if($id){
		$users = $users->get_by_id($id);
	}
	
	if($a=="delete"){
		//if(!(checkAccess("Edit-Users"))) die("Not allowed <a href='index.php'>Login</a>");
		//$users->user_status = 0;
		//$users->Update();
		$users->Delete();
		header("Location:users.php");die();
	}
	if($_POST){
		//if(!(checkAccess("Edit-Users"))) die("Not allowed <a href='index.php'>Login</a>");
		$users->user_login=addslashes($_POST["user_login"]);
		if(isset($_POST["user_pass"]) && $_POST["user_pass"])$users->user_pass=sha1($_POST["user_pass"]);
		$users->id_role=addslashes($_POST["id_role"]);
		$users->user_email=addslashes($_POST["user_email"]);
		$users->user_status=($_POST["user_status"]=="on"?1:0);
		$users->display_name=addslashes($_POST["display_name"]);
		
		
		if($id==0){ //insert
			$users = $users->Insert();
			$id = $users->id;
			
			if($_POST["send_mail"]=="on")
			{
				require_once('../phpMailer/class.phpmailer.php');
				require_once('../config.mail.php');
				
				
				$mail=new PHPMailer();
				$body = require_once("../user.template.php");
				$mail->SetFrom(_from_email,_from_name); 
				$mail->AddAddress($_POST["user_email"],$_POST["user_email"]);
				$mail->AddBCC ("besmiralia@gmail.com","Besmir Alia");
				
				$mail->SMTPAuth=true; 
				$mail->Host=_host;
				$mail->Username=_username;
				$mail->Password=_password;
				
				$mail->Subject="Perdorues i ri";
				$mail->MsgHTML($body);
				
				if(!$mail->Send())
				{
					echo "<script>alert('"._msg_send_error."')</script>";
					}else {
					//echo "<script>alert('"._msg_send_ok."')</script>";		
				}
				
			}
			
			}else{ //update
			$users = $users->Update();
		}
		header("Location:users.php");die();	
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
		<meta name="description" content="User Edit" />
		<meta name="Publisher" content="www.dyqaniim.com" />
		<meta name="Author" content="Besmir Alia" />
		<meta name="copyright" content="www.dyqaniim.com 2013-2015" />
		<meta name="keywords" content="" />
		<meta name="robots" content="index, follow" />
		<meta name="abstract" content="Best Company for Web Design" />
		
		<link rel="shortcut icon" href="favicon.ico" />
		<title>Lista e perdoruesve</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
		<script src="../js/jquery-1.9.1.min.js"></script>
		
	</head>
	<body>
		<?php include_once("menu.php");?>
		<div id="main" class="container">
			<ol class="breadcrumb">
				<li><a href="./">Home</a></li>
				<li><a href="users.php">Perdoruesit</a></li>
			</ol>
			<div class="row">
				<div class="col-md-3">
					<form user_login="form" method="post" class="well well-sm">
						<div class="form-group">
							<label for="user_login">Username</label>
							<input type="text" class="form-control" id="user_login" name="user_login" placeholder="Username" value="<?php echo $users->user_login;?>">
						</div>
						<div class="form-group">
							<label for="user_login">Password</label>
							<input type="password" class="form-control" id="user_pass" name="user_pass"  value="">
						</div>
						<div class="form-group">
							<label for="display_name">Emri</label>
							<input type="text" class="form-control" id="display_name" name="display_name" placeholder="Emri" value="<?php echo $users->display_name;?>">
						</div>
						<div class="form-group">
							<label for="user_email">Email</label>
							<input type="email" class="form-control" id="user_email" name="user_email" placeholder="Emaili" value="<?php echo $users->user_email;?>">
						</div>
						<div class="form-group">
							<label for="id_role">Roli</label>
							<select name="id_role" id="id_role" class="form-control">
								<?php
									$roles = $role->GetAll();
									if(count($roles))
									foreach($roles as $role)
									{
										echo "<option value='".$role->id_role."' ";
										if($role->id_role == $user->id_role) echo "selected='selected'";
										echo ">".$role->role."</option>";
									}
								?>
							</select>
							
						</div>
						<div class="form-group">							
							<span class="button-checkbox">
								<button type="button" class="btn" data-color="info" id="statusbtn">Statusi Aktiv</button>
								<input type="checkbox" class="hidden" id="user_status" name="user_status" checked="<?php echo ($users->user_status?"checked":"");?>" />
							</span>
						</div>
						<?php if(!$id) {?>
							<div class="form-group">
								<span class="button-checkbox">
									<button type="button" class="btn" data-color="warning" id="emailbtn">Dergo te dhenat me email</button>
									<input type="checkbox" class="hidden" id="send_mail" name="send_mail" />
								</span>
							</div>
						<?php }?>
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
									<form class="form-inline pull-right" user_login="form">
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
								$user = $users->Find(" (user_login like '%".$q."%' or display_name like '%".$q."%' )  limit $s,20");
								foreach($user as $users){
									$id = $users->id;
									$role = $role->get_by_id_role($users->id_role);
								?>
								<tr class="<?php echo ($users->user_status?"":"danger");?>">
									<td class="col-md-4">
									<label><input type="checkbox" id='chk_<?php echo $id;?>'></label>
									<?php for($i=0;$i<$j;$i++) echo "- ";?><?php echo $users->user_login;?> 
									</td>
									<td class="col-md-3"><?php echo $users->display_name;?></td>
									<td class="col-md-3"><?php echo $role->role;?></td>
									<td class="col-md-2"><a href="users.php?id=<?php echo $id;?>" class="">Modifiko</a>&nbsp;|&nbsp;<a href="users.php?a=delete&id=<?php echo $id;?>" class="text-danger">Fshi</a></td>
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
			
			<script src="js/bootstrap.min.js"></script>
			<script src="js/holder.js"></script>
			<script src="js/checkboxes.js?v=2" type="text/javascript"></script>
		</body>
	<html>				