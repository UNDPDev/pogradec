<?php
	require_once("../start.php");
	require_once("../config.php");
	require_once("db.php");	
	require_once("../cls/cls_web_service.php");
	require_once("../cls/cls_web_service_fields.php");
	require_once("../cls/cls_web_category.php");
	require_once("../cls/cls_web_category_fields.php");
	require_once("../cls/cls_web_field_group.php");
	
	$service = new web_service();
	$service_field = new web_service_fields();
	$service_fields = array();
	$category = new web_category();
	$category_field = new web_category_fields();
	$field_group = new web_field_group();
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
		if($id==0)
		{ //insert
			$service->dt_created=date("Y-m-d H:i:s");
			$service->id_user=$_SESSION["id_user"];
		}
		if($id==0)
		{ //insert
			$service = $service->Insert();
			$id = $service->id_service;
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
		<title>Modifikim Sherbimi</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css"/>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/simplex/bootstrap.min.css" type="text/css" />
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<!--http://maps.google.com/maps/api/js?sensor=false-->
		<!--https://maps.googleapis.com/maps/api/js?v=3.exp-->
		<style>
			div#gmap { width: 100%; height: 300px; }
			
			.stepwizard-step p {
			margin-top: 10px;    
			}
			
			.stepwizard-row {
			display: table-row;
			}
			
			.stepwizard {
			display: table;     
			width: 100%;
			position: relative;
			}
			
			.stepwizard-step button[disabled] {
			opacity: 1 !important;
			filter: alpha(opacity=100) !important;
			}
			
			.stepwizard-row:before {
			top: 14px;
			bottom: 0;
			position: absolute;
			content: " ";
			width: 100%;
			height: 1px;
			background-color: #ccc;
			z-order: 0;
			
			}
			
			.stepwizard-step {    
			display: table-cell;
			text-align: center;
			position: relative;
			}
			
			.btn-circle {
			width: 30px;
			height: 30px;
			text-align: center;
			padding: 6px 0;
			font-size: 12px;
			line-height: 1.428571429;
			border-radius: 15px;
			}
		</style>
		<script type="text/javascript">
			$(function() {
				var opts = {
					zoom: 15,
					center: new google.maps.LatLng(40.902667,20.659189), // Tirane
					mapTypeId: google.maps.MapTypeId.ROADMAP
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
					if($id && $service->map_lat)
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
					<div class="stepwizard-step">
						<button type="button" class="btn btn-primary btn-circle">1</button>
						<p>Te dhenat baze</p>
					</div>
					<div class="stepwizard-step">
						<button type="button" class="btn btn-default btn-circle" disabled="disabled">2</button>
						<p>Sherbimet e ofruara</p>
					</div>
					<div class="stepwizard-step">
						<button type="button" class="btn btn-default btn-circle" disabled="disabled">3</button>
						<p>Informactione shtese</p>
					</div> 
					<div class="stepwizard-step">
						<button type="button" class="btn btn-default btn-circle" disabled="disabled">4</button>
						<p>Galeria</p>
					</div> 
					<div class="stepwizard-step">
						<button type="button" class="btn btn-default btn-circle" disabled="disabled">5</button>
						<p>Sherbimet e lidhura</p>
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
						<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> Ruaj</button>
						<a href="service-edit.php" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> Krijo tjeter</a>
						<a href="service-list.php" class="btn btn-info"><span class="glyphicon glyphicon-back"></span> Kthehu te lista</a>
						<?php if($id) echo '<a href="../p.php?id='.$id.'" class="btn btn-default" target="_blank"><span class="glyphicon glyphicon-eye-open"></span> Shiko si duket</a>';?>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-9">
						<label for="service_name">Emri i sherbimit</label>
						<input type="text" class="form-control" id="service_name" name="service_name" placeholder="Emri i sherbimit" value="<?php echo $service->service_name;?>">
					</div>
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
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<label for="service_desc">Pershkrim</label>
						<textarea class="form-control ckeditor" id="service_desc" name="service_desc" rows="4" ><?php echo $service->service_desc;?></textarea>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-9">
						<!--Google Map -->
						<div id="gmap" class="col-md-12">
							
						</div>
					</div>
					<div class="form-group col-md-3">
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
					</div>
				</div>
				<!--
					<div class="row">
					<div class="form-group col-md-9">
					
					<label for="img">Imazhi Kryesor</label>
					<a href="upload.php" data-toggle="modal" data-target="#galery"><img data-src="<?php echo get_image_url($service->service_img);?>" src="<?php echo get_image_url($service->service_img);?>" id="img" class="img-rounded" width="250px" alt="Featured Image"></a>
					<input type="text" class="form-control" id="service_img" name="service_img" placeholder="Path" value='<?php echo $service->service_img;?>' onchange="$('#img').attr('src',this.value);"><input type="file" name="img-upload" />
					</div>
					<div class="form-group col-md-3">
					
					<?php
						$groups = $field_group->Find("id_group in (select distinct id_group from `web_category_fields` where id_category='".$service->id_category."')");
						foreach($groups as $field_group){
							echo "<h4>".$field_group->group_name."</h4>";
							$fields = $category_field->Find("id_category='".$service->id_category."' and id_group='".$field_group->id_group."' order by field_order");
							foreach($fields as $field){
								switch($field->field_type){
									case "textbox":case "numberbox":case "datepicker": case "timepicker": {
										echo "<input type='text' class='form-control ".$field->field_type."' name='".$field->field_name."' id='".$field->field_name."' value='".$field->field_value."' placeholder='".$field->field_label."'/>";
										break;
									}
									case "file": case "image": {
										echo "<input type='file' class='form-control ".$field->field_type."' name='".$field->field_name."' id='".$field->field_name."' />";
										break;
									}
									case "combobox":{
										echo "<select class='form-control ".$field->field_type."' name='".$field->field_name."' id='".$field->field_name."' >";
										if($field->field_query) {
											$res = mysql_query($field->field_query) or die(mysql_error());
											while($r = mysql_fetch_array($res))
											{
												echo "<option value='".$r[$field->field_value]."'>".$r[$field->field_label]."</option>";
												
											}
										}
										echo "</select>";
										break;
									}
									
								}
							}
						}
					?>
					</div>
					</div>
				-->
			</form>
		</div>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="ckeditor/ckeditor.js"></script>
	</body>
</html>