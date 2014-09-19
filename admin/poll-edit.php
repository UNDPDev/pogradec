<?php
	require_once("../start.php");
	require_once("../config.php");
	require_once("db.php");
	require_once("../cls/cls_web_post.php");
	require_once("../cls/cls_web_postmeta.php");
	require_once("../cls/cls_web_term.php");
	require_once("../cls/cls_web_termrel.php");
	
	global $root_path;
	$post = new web_post();
	$postmeta = new web_postmeta();
	$id=0;$pid=0;
	$start_date=date("Y-m-d");
	$end_date=date("Y-m-d", time()+ 7*24*3600);// 1 jave
	if(isset($_REQUEST["id"])) $id = addslashes($_REQUEST["id"]);
	if(isset($_REQUEST["pid"])) $pid = addslashes($_REQUEST["pid"]);
	$msg="";
	if(isset($_REQUEST["msg"])) $msg = addslashes($_REQUEST["msg"]);
	
	
	if($id){
		$post = $post->get_by_id_post($id);
		if(isset($_REQUEST["a"]) && $_REQUEST["a"]=="delete")
		{
			$post->Delete();		
			header("Location:poll-edit.php?id=".$pid);
			die();
		}
	}
	if($_POST){
		$post->title_al=$_POST["titleAL"];
		$post->title_en=$_POST["titleEN"];
		$post->content_al=$_POST["contentAL"];
		$post->content_en=$_POST["contentEN"];
		
		$post->publish_date = date("Y-m-d H:i:s");
		//if(isset($_POST["publish-date"]) && $_POST["publish-date"]) $post->publish_date = addslashes($_POST["publish-date"]);
		$post->post_type = 'poll';
		if(isset($_REQUEST["a"]) && $_REQUEST["a"]=="poll-answer")
		{
			$post->id_post = 0;
			$post->post_type = 'poll-answer';
			$post->post_parent = $id;
			//$post->post_order = $_POST["rend"];
			$post = $post->Insert();
			header("Location:poll-edit.php?id=".$id);
			die();
		}
		if($id==0){ //insert
			$post = $post->Insert();
			$id = $post->id_post;
			}else{ //update
			$post = $post->Update();
		}
		
		header("Location:poll-edit.php?id=".$post->id_post);die();
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
		<meta name="description" content="Post Edit" />
		<meta name="Publisher" content="www.dyqaniim.com" />
		<meta name="Author" content="Besmir Alia" />
		<meta name="copyright" content="www.dyqaniim.com 2013-2015" />
		<meta name="keywords" content="" />
		<meta name="robots" content="index, follow" />
		<meta name="abstract" content="Best Company for Web Design" />
		
		<link rel="shortcut icon" href="favicon.ico" />
		<title>Modifikim Postimi</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
		<link rel="stylesheet" href="css/bootstrap-theme.min.css" type="text/css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script>
			function addmeta()
			{
				var mk,mv;
				mk = $("#meta-key").val();
				mv = $("#meta-value").val();
				$.post("postmeta.php",{a:"add",mk:mk,mv:mv,id:<?php echo $id;?>})
				.done(function( data ) {
					location.reload(false);
				});
			}
			function deletemeta(id)
			{
				$.post("postmeta.php",{a:"delete",mi:id,id:<?php echo $id;?>})
				.done(function( data ) {
					$("#d_"+id).remove();
					alert( "Data Removed: " + data );
				});
			}
		</script>
		
	</head>
	<body>
		<?php include_once("menu.php");?>
		<div class="container">
			<form method='post' action='' role="form" class="" enctype="multipart/form-data">
				
				<?php if($msg){echo '<div class="alert alert-success alert-dismissable ">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div>';}?>
				<div class="form-group col-md-12">
					<button type="submit" class="btn btn-success">Ruaj</button>
					<a href="poll-edit.php" class="btn btn-info">Krijo tjeter (Ankete)</a>
					<a href="poll-list.php" class="btn btn-info">Kthehu te lista</a>
				</div>
				<div class="col-md-9">
					<div class="form-group col-md-6">
						<label for="titleAL">Pyetja AL</label>
						<input type="text" class="form-control" id="titleAL" name="titleAL" placeholder="Pyetja Shqip" value="<?php echo $post->title_al;?>">
					</div>
					<div class="form-group col-md-6">
						<label for="titleEN">Pyetja EN</label>
						<input type="text" class="form-control" id="titleEN" name="titleEN" placeholder="Pyetja Anglisht" value="<?php echo $post->title_en;?>">
					</div>
					<?php
						$pergjigje = new web_post();
						$pergjigje = $pergjigje->Find("post_type='poll-answer' and post_parent='".$id."'");
						if(count($pergjigje)){
							foreach($pergjigje as $p){
							$pid = $p->id_post;
						?>
						<div class="form-group col-md-9">
							<label for="pergjigjeAL<?php echo $pid;?>">Pergjigja</label>
							<input type="text" class="form-control" id="pergjigjeAL<?php echo $pid;?>" name="pergjigjeAL" disabled placeholder="Pergjigje" value="<?php echo $p->title_al;?>">
						</div>
						<div class="form-group col-md-2">
							<label for="votaAL<?php echo $pid;?>">Vota</label>
							<input type="text" class="form-control" id="votaAL<?php echo $pid;?>" name="votaAL" placeholder="Nr Vota" value="<?php echo $p->post_order;?>">
						</div>
						<div class="form-group col-md-1">
							<label for="remove<?php echo $pid;?>">Fshije</label>
							<a href="?a=delete&pid=<?php echo $id;?>&id=<?php echo $pid;?>" id="remove<?php echo $pid;?>"><span class="label label-danger">X</span></a>
						</div>
						<?php
							}
						}
					?>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="start-date">Date Fillimi</label>
						<input type="date" class="form-control" id="start-date" name="start-date" placeholder="Date Fillimi" value="<?php echo $start_date;?>">
					</div>
					<div class="form-group">
						<label for="end-date">Date Mbarimi</label>
						<input type="date" class="form-control" id="end-date" name="end-date" placeholder="Date Mbarimi" value="<?php echo $end_date;?>">
					</div>
				</div>
				
			</form>
			<?php
			if($id){
			?>
			<form method='post' action='' class="">
				<div class="col-md-12 ">
					
					<div class="form-group col-md-9 ">
						<input type='hidden' name='a' value='poll-answer' />
						<input type="text" class="form-control" id="titleAL" name="titleAL" placeholder="Shto Pergjigje" value="">
					</div>
					<div class="form-group col-md-3 ">
						<button type="submit" class="btn btn-success">Shto</button>
					</div>
				</div>
			</form>
			<?php
			}
			?>
		</div>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>