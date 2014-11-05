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
	
	$service = new web_service();
	$service_field = new web_service_fields();
	$service_fields = array();
	$category = new web_category();
	$category_field = new web_category_fields();
	$field_group = new web_field_group();
	$id=0;
	if(isset($_REQUEST["id"])) $id = addslashes($_REQUEST["id"]);else die("Mungon id");
	
	if($id){
		$service = $service->get_by_id_service($id);
		$service_fields = $service_field->get_by_id_service($id);
		
	}
	
	
	if($_POST){
		
		$fields = $category_field->Find("id_category='".$service->id_category."' order by field_order");
		foreach($fields as $field){
			
			foreach($_POST as $k=>$v){
				if($k==$field->field_name){
					//echo "k:".$k."--v:".$v;
					$sf = new web_service_fields();
					$sf = $sf->get_by_unique($id,$k);
					
					$sf->id_service = $id;
					$sf->field_name = $k;
					$sf->field_type = $field->field_type;
					$sf->field_value = $v; // sanitize input
					$sf->field_order = $field->field_order;
					
					if($sf->id_service_field) $sf->Update();
					else $sf->Insert();
					continue;
				}
			}
		}
		
		/**********/
		header("Location:service-gallery.php?id=".$id);die(); //redirect to second step
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
		<title>Extra Information</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css"/>
		<link rel="stylesheet" href="css/wizard.css" type="text/css"/>
		<!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/simplex/bootstrap.min.css" type="text/css" />-->
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<style>
			div#gmap { width: 100%; height: 300px; }
		</style>
	</head>
	<body>
		<?php include_once("menu.php");?>
		<div class="container">
			
			<div class="stepwizard">
				<div class="stepwizard-row">
					<div class="stepwizard-step">
						<a class="btn btn-primary btn-circle" href='service-edit.php?id=<?php echo $id;?>'>1</a>
						<p>Basic Data</p>
					</div>
					<div class="stepwizard-step">
						<a class="btn btn-primary btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-extra.php?id=<?php echo $id;?>'>2</a>
						<p>Extra Info</p>
					</div>
					<div class="stepwizard-step">
						<a class="btn btn-default btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-subs.php?id=<?php echo $id;?>'>3</a>
						<p>Services</p>
					</div> 
					<div class="stepwizard-step">
						<a class="btn btn-default btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-gallery.php?id=<?php echo $id;?>'>4</a>
						<p>Gallery</p>
					</div> 
					<div class="stepwizard-step">
						<a class="btn btn-default btn-circle" <?php if($id==0) echo 'disabled="disabled"';?> href='service-rel.php?id=<?php echo $id;?>'>5</a>
						<p>Related Services</p>
					</div> 
				</div>
			</div>
			
		</div>
		<div class="container">
			<form method='post' action='' role="form" class="" enctype="multipart/form-data">
				<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
				<div class="form-group col-md-12">
					<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
					<a href="service-edit.php" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> New</a>
					<a href="service-list.php" class="btn btn-info"><span class="glyphicon glyphicon-list"></span> View List</a>
					<?php if($id) echo '<a href="../service.php?id='.$id.'" class="btn btn-default" target="_blank"><span class="glyphicon glyphicon-eye-open"></span> Preview</a>';?>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<label for="service_name">Emri i sherbimit</label>
						<input type="text" class="form-control" id="service_name" name="service_name" placeholder="Emri i sherbimit" value="<?php echo $service->service_name;?>" disabled="disabled">
					</div>
				</div>
				
				<div class="row">
					<div class="form-group col-md-12">
						<!--Fushat shtese-->
						<?php
							$groups = $field_group->Find("id_group in (select distinct id_group from `web_category_fields` where id_category='".$service->id_category."')");
							foreach($groups as $field_group){
								echo "<h4>".$field_group->group_name."</h4>";
								$fields = $category_field->Find("id_category='".$service->id_category."' and id_group='".$field_group->id_group."' order by field_order");
								foreach($fields as $field){
									$v = $field->field_value;

									$sf = new web_service_fields();
									$sf = $sf->get_by_unique($id,$field->field_name);
									if($sf->id_service_field) $v = $sf->field_value;
									
									switch($field->field_type){
										case "textbox":case "numberbox":case "datepicker": case "timepicker": {
											echo "<div class='form-group'><label for='".$field->field_name."'>".$field->field_label."</label><input type='text' class='form-control ".$field->field_type."' name='".$field->field_name."' id='".$field->field_name."' value='".$v."' placeholder='".$field->field_label."'/></div>";
											break;
										}
										case "textarea": {
											echo "<div class='form-group'><textarea class='form-control ".$field->field_type."' name='".$field->field_name."' id='".$field->field_name."' >".$v."</textarea></div>";
											break;
										}
										case "checkbox": {
											//echo "<label for='".$field->field_name."'>".$field->field_label."</label><input type='checkbox' class=' ".$field->field_type."' name='".$field->field_name."' id='".$field->field_name."' ".($v=="on"?"checked='checked'":"")."  />";
											
											echo '<span class="button-checkbox">
												<button type="button" class="btn" data-color="info" id="btn_'.$field->field_name.'">'.$field->field_label.'</button>
												<input type="checkbox" class="hidden" id="'.$field->field_name.'" name="'.$field->field_name.'" '.($v=="on"?"checked='checked'":"").' />
											</span>';
											break;
										}
										case "file": case "image": {
											echo "<div class='form-group'><input type='file' class='form-control ".$field->field_type."' name='".$field->field_name."' id='".$field->field_name."' /></div>";
											break;
										}
										case "dropdown":{
											echo "<div class='form-group'><label for='".$field->field_name."'>".$field->field_label."</label><select class='form-control ".$field->field_type."' name='".$field->field_name."' id='".$field->field_name."' >";
											if($field->field_query) {
												$res = mysql_query($field->field_query) or die(mysql_error());
												while($r = mysql_fetch_array($res))
												{
													echo "<option value='".$r[0]."'";
													if($v == $r[0])echo "selected='selected'";
													echo ">".$r[1]."</option>";
													
												}
											}
											echo "</select></div>";
											break;
										}
										default:{echo "Undefined Field type:".$field->field_type;break;}
									}
								}
							}
						?>
					</div>
				</div>
			</form>
		</div>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="ckeditor/ckeditor.js"></script>
		<script src="js/checkboxes.js?v=2" type="text/javascript"></script>
	</body>
</html>	