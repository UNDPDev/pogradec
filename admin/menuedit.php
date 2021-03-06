<?php
	require_once("../start.php");
	require_once("../config.php");
	require_once("db.php");
	require_once("../cls/cls_web_menu.php");
	
	$wmenu = new web_menu();
	
	$q="";if(isset($_REQUEST["q"])) $q = addslashes($_REQUEST["q"]);
	$menu_class="";if(isset($_REQUEST["menu_class"])) $menu_class = addslashes($_REQUEST["menu_class"]);
	$p="0";if(isset($_REQUEST["p"])) $p = addslashes($_REQUEST["p"]);
	$o="0";if(isset($_REQUEST["o"])) $o = addslashes($_REQUEST["o"]);
	$menu_link="#";if(isset($_REQUEST["menu_link"])) $menu_link = addslashes($_REQUEST["menu_link"]);
	$a="";if(isset($_REQUEST["a"])) $a = addslashes($_REQUEST["a"]);
	$id=0;
	if(isset($_REQUEST["id"])) $id = addslashes($_REQUEST["id"]);
	
	if($id){
		$wmenu = $wmenu->get_by_id_menu($id);
	}
	if($a=="delete"){
		$wmenu->Delete();
		header("Location:menuedit.php");die();
	}
	if($_POST){
		$wmenu->menu_title=$_POST["menu_title"];
		$wmenu->menu_desc=$_POST["menu_desc"];
		$wmenu->id_parent=$p;
		$wmenu->menu_class=$menu_class;
		$wmenu->menu_order=$o;
		$wmenu->menu_link=$menu_link;
		
		if($id==0){ //insert
			$wmenu = $wmenu->Insert();
			$id = $wmenu->id_menu;
		}else{ //update
			$wmenu = $wmenu->Update();
		}
		header("Location:menuedit.php");die();	
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
		<title>Menuja kryesore</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css" />
		<!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/simplex/bootstrap.min.css" type="text/css" />-->
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script>
		function changemenu_link(id)
		{
			if(id>0)
				$("#menu_link").val("p.php?id="+id);
		}
		function chooseParent(i){ $("#parent").val(i);}
		</script>
	</head>
	<body>
		<?php include_once("menu.php");?>
		<div id="main" class="container">
			<ol class="breadcrumb">
				<li><a href="./">Home</a></li>
				<li><a href="menuedit.php"><?php echo ucwords($wmenu->menu_title);?></a></li>
			</ol>
			<div class="row">
				<div class="col-md-3">
					<form role="form" method="post">
						<div class="form-group">
							<label for="menu_title">Title</label>
							<input type="text" class="form-control" id="menu_title" name="menu_title" placeholder="Title" value="<?php echo $wmenu->menu_title;?>">
						</div>
						<div class="form-group">
							<label for="menu_desc">Description</label>
							<input type="text" class="form-control" id="menu_desc" name="menu_desc" placeholder="Description" value="<?php echo $wmenu->menu_desc;?>">
						</div>
						<div class="form-group">
							<label for="menu_link">Menu Link</label>
							<input type="text" class="form-control" id="menu_link" name="menu_link" placeholder="http://" value="<?php echo $wmenu->menu_link;?>">
							<!--
							<select class="form-control" name="posts" id="posts" onchange='changemenu_link(this.value)'>
								<option value='0' ></option>
								<?php
									include_once("../cls/cls_web_service.php");
									$post = new web_service();
									$posts = $post->Find("id_status=1");
									foreach($posts as $post){
										echo "<option value='".$post->id_service."' >".get_excerpt($post->service_name,100)." (".$post->id_service.")</option>";
									}
								?>
							</select>
							-->
						</div>
						<div class="form-group">
							<label for="menu_class">Menu Class</label>
							<input type="text" class="form-control" id="menu_class" name="menu_class" placeholder="" value="<?php echo $wmenu->menu_class;?>">
						</div>
						<div class="form-group">
							<label for="parent">Choose(click) from the right menu </label>
							<select class="form-control" name="p" id="parent" >
								<option value='0' >No Parent</option>
								<?php							
									$wmenus = $wmenu->GetAll();
									foreach($wmenus as $tr){
										$selected ="";
										
										if($tr->id_menu == $wmenu->id_parent) 
										$selected = ' selected="selected"';
										echo "<option value='".$tr->id_menu."' ".$selected .">".$tr->menu_title."</option>";
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="o">Order</label>
							<input type="text" class="form-control" id="o" name="o" placeholder="" value="<?php echo $wmenu->menu_order;?>">
						</div>
						<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> Ruaj</button>
						<a href="menuedit.php" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> Krijo tjeter</a>
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
							function display_menu($id,$j){
								global $wmenu;
								global $menu_link;
								global $q;
								
								$sql="id_parent =".$id."";
								if($q) {$sql="(menu_link='".$q."' or menu_title like '%".$q."%' or menu_desc like '%".$q."%' ) ";$q="";}
								$wmenus = $wmenu->Find($sql." order by menu_order");
								foreach($wmenus as $menu){
									$id = $menu->id_menu;
								?>
								<tr>
									<td class="col-md-9" onclick='chooseParent(<?php echo $id;?>)'>
									<label><?php echo $id;?></label>
									<?php for($i=0;$i<$j;$i++) echo "- ";?><a href="menuedit.php?id=<?php echo $id;?>"><?php if($j==0)echo "<strong>".$menu->menu_title."</strong>"; else echo $menu->menu_title;?> </a>
									</td>
									<td class="col-md-2"><a href="<?php echo get_image_url($menu->menu_link);?>" target="_blank"><?php echo $menu->menu_link;?></a></td>
									<td class="col-md-1"><a href="menuedit.php?a=delete&id=<?php echo $id;?>" type="button" class="btn btn-danger btn-xs" title="Delete"><span class="glyphicon glyphicon-trash"></span></a></td>
								</tr>
								<?php
								display_menu($id,$j+1);
								}
							}
							display_menu(0,0);
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
		</body>
	<html>				