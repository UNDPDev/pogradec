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
	require_once("../cls/cls_web_service_fields.php");
	require_once("../cls/cls_web_category.php");
	require_once("../cls/cls_web_category_fields.php");
	require_once("../cls/cls_web_field_group.php");
	require_once("../cls/cls_web_status.php");
	
	$service = new web_service();
	$service_field = new web_service_fields();
	$service_fields = array();
	$category = new web_category();
	$category_field = new web_category_fields();
	$field_group = new web_field_group();
	$status = new web_status();
	$id=0;
	if(isset($_REQUEST["id"])) $id = addslashes($_REQUEST["id"]);
	$msg="";
	if(isset($_REQUEST["msg"])) $msg = addslashes($_REQUEST["msg"]);
	
	$service->service_img="http://placehold.it/900x300.png";
	if($id){
		$service = $service->get_by_id_service($id);
		$service_fields = $service_field->get_by_id_service($id);
		
	}
	
	
	if($_POST){
		$service->id_parent=null;
		$service->id_category=addslashes($_REQUEST["id_category"]);
		$service->service_name=addslashes($_REQUEST["service_name"]);
		$service->service_desc=addslashes($_REQUEST["service_desc"]);
		$service->service_nipt=addslashes($_REQUEST["service_nipt"]);
		$service->service_email=addslashes($_REQUEST["service_email"]);
		$service->service_mobile=addslashes($_REQUEST["service_mobile"]);
		$service->service_address=addslashes($_REQUEST["service_address"]);
		//$service->service_rating=0;
		$service->map_lat=addslashes($_REQUEST["map_lat"]);
		$service->map_lng=addslashes($_REQUEST["map_lng"]);
		$service->service_hours=addslashes($_REQUEST["service_hours"]);
		//$service->service_img=addslashes($_REQUEST["service_img"]);
		//if($id==0)
		//{ //insert
			$service->dt_created=date("Y-m-d H:i:s");
			$service->id_user=$_SESSION["user_id"];
			$service->id_status=addslashes($_REQUEST["id_status"]);//Active
		//}
		if($id==0)
		{ //insert
			$service = $service->Insert();
			$id = $service->id_service;
			header("Location:service-extra.php?id=".$id);die(); //redirect to second step
		}
		else
		{ //update
			$service = $service->Update();
		}
		
		/**********/
		header("Location:service-edit.php?id=".$id);die(); //redirect to second step
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
		<title>Service Details</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css"/>
		<link rel="stylesheet" href="css/wizard.css" type="text/css"/>
		<!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/simplex/bootstrap.min.css" type="text/css" />-->
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<!--http://maps.google.com/maps/api/js?sensor=false-->
		<!--https://maps.googleapis.com/maps/api/js?v=3.exp-->
		<style>
			div#gmap { width: 100%; height: 250px; }
		</style>
		<script type="text/javascript">
			$(function() {
				var opts = {
					zoom: 16,
					center: new google.maps.LatLng(40.902667,20.659189), // Tirane
					mapTypeId: google.maps.MapTypeId.SATELLITE
				};
				var map = new google.maps.Map(document.getElementById('gmap'), opts);	
				var marker = new google.maps.Marker();
				google.maps.event.addListener(map, 'click', addMarkerHandler);
				function addMarkerHandler (e) {
					var lat = e.latLng.lat();
					var lng = e.latLng.lng();
					$("#map_lat").val(lat);
					$("#map_lng").val(lng);
					marker.setMap(null);
					marker = new google.maps.Marker({
						position: new google.maps.LatLng(lat, lng),
						icon: {
							path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
							scale: 5,
							fillColor : "#FF0000",
							fillOpacity: 0.9,
							strokeWeight: 2,
							strokeColor: "white",
						},
						animation: google.maps.Animation.BOUNCE,
						draggable:false,
						map: map,
						title : "Sherbim i ri" 
					});
					
				};
				<?php
					if($id && $service->map_lat != 0 && $service->map_lng != 0)
					{	
					?>
					marker.setMap(null);
					marker = new google.maps.Marker({
						position: new google.maps.LatLng(<?php echo $service->map_lat;?>, <?php echo $service->map_lng;?>),
						icon: {
							path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
							scale: 5,
							fillColor : "#FF0000",
							fillOpacity: 0.9,
							strokeWeight: 2,
							strokeColor: "white",
						},
						draggable:false,
						map: map,
						title : "<?php echo $service->service_name;?>"
					});
					map.setCenter(marker.getPosition());
					<?php
					
					}
				?>
			});
		</script>
	</head>
	<body>
		<?php include_once("menu.php");?>
		<div class="container">
			
			
			<div class="stepwizard"> 
				<div class="stepwizard-row"> 
					<div class="stepwizard-step"> <a class="btn btn-primary btn-circle" href='service-edit.php?id=<?php echo $id;?>'>1</a></button> 
						<p>Basic Data</p>
					</div>
					<div class="stepwizard-step"> <a class="btn btn-default btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-extra.php?id=<?php echo $id;?>'>2</a> 
						<p>Extra Info</p>
					</div>
					<div class="stepwizard-step"> <a class="btn btn-default btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-subs.php?id=<?php echo $id;?>'>3</a> 
						<p>Services</p>
					</div>
					<div class="stepwizard-step"> <a class="btn btn-default btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-gallery.php?id=<?php echo $id;?>'>4</a> 
						<p>Gallery</p>
					</div>
					<div class="stepwizard-step"> <a class="btn btn-default btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-rel.php?id=<?php echo $id;?>'>5</a> 
						<p>Related Services</p>
					</div>
				</div>
			</div>
			
		</div>
		<div class="container" id="main">
			<form method='post' action='' role="form" class="" enctype="multipart/form-data">
				<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
				<input type="hidden" name="map_lat" id="map_lat" value="<?php echo $service->map_lat;?>" />
				<input type="hidden" name="map_lng" id="map_lng" value="<?php echo $service->map_lng;?>" />
				<?php if($msg){echo '<div class="alert alert-success alert-dismissable ">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div>';}?>
				<div class="row">
					<div class="form-group col-md-12">
						<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
						<a href="service-edit.php" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> New</a>
						<a href="service-list.php" class="btn btn-info"><span class="glyphicon glyphicon-list"></span> View List</a>
						<?php if($id) echo '<a href="../service.php?id='.$id.'" class="btn btn-default" target="_blank"><span class="glyphicon glyphicon-eye-open"></span> Preview</a>';?>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-3">
						<label for="id_category">Kategoria</label>
						<select class="form-control" id="id_category" name="id_category" >
							<?php							
								$cats = $category->GetAll();
								foreach($cats as $t){
									$selected ="";
									
									if($t->id_category == $service->id_category) 
									$selected = ' selected="selected"';
									echo "<option value='".$t->id_category."' ".$selected .">".$t->category_name."</option>";
								}
							?>
						</select>
						<label for="service_name">Emri i sherbimit</label>
						<input type="text" class="form-control" id="service_name" name="service_name" placeholder="Emri i sherbimit" value="<?php echo $service->service_name;?>">
						<label for="service_address">Adresa</label>
						<input type="text" class="form-control" id="service_address" name="service_address" placeholder="Adresa" value="<?php echo $service->service_address;?>">
						<label for="service_mobile">Telefon</label>
						<input type="text" class="form-control" id="service_mobile" name="service_mobile" placeholder="3556..." value="<?php echo $service->service_mobile;?>">
						<label for="service_email">Email</label>
						<input type="text" class="form-control" id="service_email" name="service_email" placeholder="Adresa Email" value="<?php echo $service->service_email;?>">
						<label for="service_nipt">Nipt</label>
						<input type="text" class="form-control" id="service_nipt" name="service_nipt" placeholder="NIPT/ID" value="<?php echo $service->service_nipt;?>">
						<label for="service_hours">Orari</label>
						<input type="text" class="form-control" id="service_hours" name="service_hours" placeholder="24H" value="<?php echo $service->service_hours;?>">
						
						<label for="id_status">Statusi</label>
						<select name="id_status" id="id_status" class="form-control">
						<?php
						$statuses = $status->GetAll();
						foreach($statuses as $st)
						{
							$selected ="";
									
							if($st->id_status == $service->id_status) 
							$selected = ' selected="selected"';
							echo "<option value='".$st->id_status."' ".$selected .">".$st->status_name."</option>";
						}
						?>
						</select>
					</div>
					<div class="form-group col-md-9">
						<label for="service_desc">Pershkrim</label>
						<textarea class="form-control ckeditor" id="service_desc" name="service_desc" rows="2" ><?php echo $service->service_desc;?></textarea>
						<!--Google Map -->
						<div id="gmap" class="col-md-12">
							
						</div>
					</div>
				</div>
				
			</form>
		</div>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="ckeditor/ckeditor.js"></script>
	</body>
</html>