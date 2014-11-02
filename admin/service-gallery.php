<?php
	require_once("../start.php");
	require_once("../config.php");
	require_once("db.php");
	
	/* BESMIR ALIA
	 * 02-11-2014
	 * CHECK IF THE USER HAS ACCESS
	 */
	if(!checkAccess("Edit-Sherbim")){ header("Location:index.php");die(); }
	
	require_once("../cls/cls_web_service.php");
	require_once("../cls/cls_web_service_gallery.php");
	
	$service = new web_service();
	$arrfields = array();
	// Denisi
	//$arr = $category->GetAll()
	$id=0;
	if(isset($_REQUEST["id"])&&$_REQUEST["id"]!=0)
	{
		$id = addslashes($_REQUEST["id"]);
		$service_images = new web_service_gallery();
		$arrfields = $service_images->get_by_id_service($id);
		$service=$service->get_by_id_service($id);
		// Denisi
		//$arrfields = $category_fields->get_by_id_category_field($cat);
	}
	if($_POST)
	{
		$id = addslashes($_REQUEST["id"]);
		$service=$service->get_by_id_service($id);
		$service_images = new web_service_gallery();
		$service_images->id_gallery=$_REQUEST["gallery"];
		$service_images->id_service=$_REQUEST["id"];
		$service_images->img_path=$_REQUEST["img"];
		$service_images->img_desc=$_REQUEST["desc"];
		$service_images->img_order=$_REQUEST["order"];
		$service_images->Update();
		/**********/
		header("Location:service-gallery.php?id=".$_REQUEST["id"]);die();
	}
	
	if(isset($_REQUEST['imgdele'])&&($_REQUEST['imgdele']!=""))
	{
		$cat_field = new web_service_gallery();
		$cat_field->id_gallery=$_REQUEST["imgdele"];
		$cat_field->Delete();
		/**********/
		(file_exists($_REQUEST['img_path']))?unlink($_REQUEST['img_path']) : "";
		header("Location:service-gallery.php?id=".$_REQUEST["id"]);die();
	}
	
	if(isset($_REQUEST['imgdefault'])&&($_REQUEST['imgdefault']!=""))
	{
		$id_serv = addslashes($_REQUEST["id"]);
		$id_img_default=addslashes($_REQUEST["imgdefault"]);
		$serv= new web_service();
		$serv=$serv->get_by_id_service($id_serv);
		$serv->service_img=$_REQUEST['img_path'];
		$serv->Update();
		/**********/
		header("Location:service-gallery.php?id=".$id_serv);die();
	}
	
?>
<!DOCTYPE HTML>
<!--[if lt IE 7 ]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" class=""> <!--<![endif]-->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Modifikim sherbimi" />
		<meta name="Publisher" content="www.dyqaniim.com" />
		<meta name="Author" content="Besmir Alia" />
		<meta name="copyright" content="www.dyqaniim.com 2013-2015" />
		<meta name="keywords" content="" />
		<meta name="robots" content="index, follow" />
		<meta name="abstract" content="Pogradeci online" />
		
		<link rel="shortcut icon" href="favicon.ico" />
		<title>Gallery</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css"/>
		<link rel="stylesheet" href="css/wizard.css" type="text/css"/>
		<!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/simplex/bootstrap.min.css" type="text/css" />-->
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script>
			function getdesc(str)
			{
				return this.document.getElementById(str).value;
			}
		</script>
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
			form div.photos {
            margin-right: -19px;
            overflow: hidden;
			}
			form div.photos > div {
            border-radius: 3px;
            float: left;
            height: 90px;
            margin: 19px 19px 0 0;
            width: 120px;
			}
			form div.photos > div.uploading {
            border: 1px #ccc solid;
			}
			form div.photos > div.uploaded {
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
			}
			form div.photos > div.uploading span.progress {
            background: white;
            border-radius: 2px;
            display: block;
            height: 10px;
            margin: 40px 5px;
            overflow: hidden;
			}
			form div.photos > div.uploading span.progress span {
            display: block;
            height: 100%;
			}
			
		</style>
	</head>
	<body>
		
		<?php
			//Denisi
			include_once("menu.php");
		?>
		<div class="container">
			
			
			<div class="stepwizard"> 
				<div class="stepwizard-row"> 
					<div class="stepwizard-step"> <a class="btn btn-primary btn-circle" href='service-edit.php?id=<?php echo $id;?>'>1</a> 
						<p>Basic Data</p>
					</div>
					<div class="stepwizard-step"> <a class="btn btn-primary btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-edit.php?id=<?php echo $id;?>'>2</a> 
						<p>Extra Info</p>
					</div>
					<div class="stepwizard-step"> <a class="btn btn-primary btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-subs.php?id=<?php echo $id;?>'>3</a> 
						<p>Services</p>
					</div>
					<div class="stepwizard-step"> <a class="btn btn-primary btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-gallery.php?id=<?php echo $id;?>'>4</a> 
						<p>Gallery</p>
					</div>
					<div class="stepwizard-step"> <a class="btn btn-default btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-rel.php?id=<?php echo $id;?>'>5</a> 
						<p>Related Services</p>
					</div>
				</div>
			</div>
			
		</div>
		<div id="main" class="container">
			<div class="row">
				<div class="form-group col-md-12">
					<a href="service-edit.php" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> New</a>
					<a href="service-list.php" class="btn btn-info"><span class="glyphicon glyphicon-list"></span> View List</a>
					<?php if($id) echo '<a href="../service.php?id='.$id.'" class="btn btn-default" target="_blank"><span class="glyphicon glyphicon-eye-open"></span> Preview</a>';?>
				</div>
			</div>
			<div class="row">
				<div class="panel panel-default widget">
					<!-- Default panel contents -->
					<div class="panel-heading">
						<div class="row">
							<div class="col-md-6">
								<label><h3><?php echo $service->service_name;?></h3></label>
								<select style="visibility:hidden" class="form-control" name="c" id="c" >
									
									<?php
										
										echo "<option value='".$service->id_service."'  >".$service->service_name."</option>";
										
									?>
								</select> 
							</div>
						</div>
						
					</div>
					
					<!-- Table -->
					<div class="panel-body">
						
							<?php
								$i=0;
								echo '';
								foreach($arrfields as $img)
								{
									$i++;
									$col='btn-default';
									if($service->service_img==$img->img_path)
									$col='btn-success';
									echo '<div class="col-md-6"><div class="row"><div class="col-md-3">';
									echo '<a href="'.$img->img_path.'" target="_blank"><img src="'.$img->img_path.'" class="img-thumbnail" style="height:100px;width:100px;"/></a></div> 
									<form action="service-gallery.php" method="post" role="form">
									
									<div class="col-md-9">
									<input type="hidden" name="gallery" value="'.$img->id_gallery.'"/>
									<input type="hidden" name="id" value="'.$img->id_service.'"/>
									<input type="hidden" name="img" value="'.$img->img_path.'"/>
									<div class="col-md-8"><input type="text" value="'.$img->img_desc.'" name="desc" placeholder="Image description" class="form-control" title="Pershkrimi"/></div>
									<div class="col-md-4"><input type="number" value="'.$img->img_order.'" name="order" placeholder="Image order" class="form-control" title="Renditja"/></div>
									<div class="col-md-4">
									<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"> Save</span></button>
									</div>
									<div class="col-md-4">
									<a type="button" class="btn '.$col.'" href="service-gallery.php?imgdefault='.$img->id_gallery.'&'.
									'img_path='.$img->img_path.'&id='.$img->id_service.'">
									<span class="glyphicon glyphicon-star"> Featured</span></a>
									</div>
									<div class="col-md-4">
									<a type="button" class="btn btn-danger" href="service-gallery.php?imgdele='.$img->id_gallery.'&'.
									'img_path='.$img->img_path.'&id='.$img->id_service.'">
									<span class="glyphicon glyphicon-remove"> Delete</span></a>
									</div>
									</div>';
									
									echo '</form></div></div>';
									
								}
								echo '';
							?>
					</div>
					
					<!-- Table -->
					<div class="panel-body">
						<br>
						
						<form id="upload">
							<input  type="file" multiple  />
							<input type="hidden" value="<?php echo $_REQUEST["id"];?>" id="service"/>
							<div class="photos" id="photos">
							</div>
							
							<script src="js/upload.js"></script>
							
							<form>
							</div>
						</div>
					</div>
				</div>
				
				<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
				<script src="js/holder.js"></script>
				
			</body>
		<html>						