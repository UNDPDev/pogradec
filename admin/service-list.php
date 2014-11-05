<?php
	require_once("../start.php");
	require_once("../config.php");
	require_once("db.php");
	/* BESMIR ALIA
	 * 02-11-2014
	 * CHECK IF THE USER HAS ACCESS
	 */
	 if(!checkAccess("Lexim-Sherbim")){ header("Location:index.php");die(); }
	require_once("../cls/cls_web_service.php");
	require_once("../cls/cls_web_category.php");
	
	global $root_path;
	$service = new web_service();
	$term = new web_category();
	
	$q="";if(isset($_REQUEST["q"])) $q = addslashes($_REQUEST["q"]);
	$c="0";if(isset($_REQUEST["c"])) $c = addslashes($_REQUEST["c"]);
	$s="0";if(isset($_REQUEST["s"])) $s = addslashes($_REQUEST["s"]);
	
	
?>
<!DOCTYPE HTML>
<!--[if lt IE 7 ]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" class=""> <!--<![endif]-->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Service List" />
		<meta name="Publisher" content="www.dyqaniim.com" />
		<meta name="Author" content="Besmir Alia" />
		<meta name="copyright" content="www.dyqaniim.com 2013-2015" />
		<meta name="keywords" content="" />
		<meta name="robots" content="index, follow" />
		<meta name="abstract" content="Best Company for Web Design" />
		
		<link rel="shortcut icon" href="favicon.ico" />
		<title>Lista e Sherbimeve</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<style type="text/css">
			.widget .panel-body { padding:0px; }
			.widget .list-group { margin-bottom: 0; }
			.widget .panel-title { display:inline }
			.widget .label-info { float: right; }
			.widget li.list-group-item {border-radius: 0;border: 0;border-top: 1px solid #ddd;}
			.widget li.list-group-item:hover { background-color: rgba(86,61,124,.1); }
			.widget .mic-info { color: #666666;font-size: 11px; }
			.widget .action { margin-top:5px; }
			.widget .comment-text { font-size: 12px; }
			.widget .btn-block { border-top-left-radius:0px;border-top-right-radius:0px; }
		</style>
	</head>
	<body>
		<?php include_once("menu.php");?>
		<div id="main" class="container">
			<div class="row">
				<div class="col-md-12"><a href="service-edit.php" class="btn btn-primary btn-info" role="button"><span class="glyphicon glyphicon-plus"></span> Shto nje Sherbim</a></div>
			</div>
			<div class="row">
				<div class="panel panel-default widget">
					<!-- Default panel contents -->
					<div class="panel-heading">
						<div class="row">
							<div class="col-md-3 form-inline">
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
							<div class="col-md-3">
								<select class="form-control" name="c" onchange="window.location='service-list.php?c='+this.value">
									<option value='0' >Zgjidh Kategorine</option>
									<?php							
										$terms = $term->Find(" id_category in (select distinct id_category from web_service )  order by category_name");
										foreach($terms as $t){
											$selected ="";
											
											if($t->id_category == $c) 
											$selected = ' selected="selected"';
											echo "<option value='".$t->id_category."' ".$selected .">".$t->category_name."</option>";
										}
									?>
								</select>
							</div>
							<div class="col-md-4">
								<form class="form-inline pull-right" role="form">
									<div class="form-group">									
										<input type="search" class="form-control" id="q" name="q" placeholder="Kerko" value="<?php echo $q;?>">
									</div>
									<button type="submit" class="btn btn-default">Kerko</button>
								</form>
							</div>
							<div class="col-md-2">
								<div class="btn-toolbar pull-right" role="toolbar">
									<div class="btn-group">
										<?php if($s>0) {?><a href="<?php echo '?q='.$q.'&s='.($s-1).'&c='.$c;?>" type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-backward"></span></a>
										<?}?>
										<button type="button" class="btn btn-default"><?php echo ($s+1);?></button>
										<a href="<?php echo '?q='.$q.'&s='.($s+1).'&c='.$c;?>" type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-forward"></span></a>
									</div>
								</div>
							</div>
						</div>
						
					</div>
					
					<!-- Table -->
					<div class="panel-body">
						<ul class="list-group">
							<?php
								$posts = $service->Find(" (id_category ='".$c."' or '0'='".$c."') and (service_name like '%".$q."%' or service_desc like '%".$q."%') and id_parent=0 order by id_service desc limit ".($s*20).",20");
								foreach($posts as $service){
									$id = $service->id_service;
									$img = $service->service_img;
									if($img=="") $img = "holder.js/50x50";
								?>
								<li class="list-group-item">
									<div class="row">
										<div class="col-xs-2 col-md-1">
										<img src="<?php echo get_image_url($img);?>" class="img-rounded img-responsive" alt="" /></div>
										<div class="col-xs-10 col-md-11">
											<div>
												<a href="service-edit.php?id=<?php echo $id;?>">
												<?php echo $service->service_name;?></a>
												<div class="mic-info">
													Kategoria: <strong><?php $cat = $term->get_by_id_category($service->id_category);echo $cat->category_name; ?></strong>
													on <?php echo $service->dt_created;?>
												</div>
											</div>
											<div class="action">
												<a href="service-edit.php?id=<?php echo $id;?>" type="button" class="btn btn-primary btn-xs" title="Edit">
													<span class="glyphicon glyphicon-pencil"></span>
												</a>
												<a type="button" href="service-edit.php?id=<?php echo $id;?>&a=delete" class="btn btn-danger btn-xs" title="Delete">
													<span class="glyphicon glyphicon-trash"></span>
												</a>
												<a target="_blank" href="../service-edit.php?id=<?php echo $id;?>" type="button" class="btn btn-default btn-xs" title="Preview">
													<span class="glyphicon glyphicon-search"></span>
												</a>
											</div>
										</div>
									</div>
								</li>
								
								<?php
								}
							?>	
							
						</ul>
						<a href="#" class="btn btn-primary btn-sm btn-block" role="button"><span class="glyphicon glyphicon-refresh"></span> Me shume</a>
					</div>
				</div>
			</div>
		</div>
		
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="js/holder.js"></script>
	</body>
<html>