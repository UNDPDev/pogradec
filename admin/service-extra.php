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
		$service_fields = $service_field->get_bby_id_service($id);
		$termrels = $termrel->get_by_id_service($id);
		if(isset($_REQUEST["a"]) && $_REQUEST["a"]=="delete")
		{
			mysql_query("delete from web_service_fields where id_service='".$id."'");
			$service->Delete();		
			header("Location:service-list.php");
			die();
		}
	}
	if($_POST){
		$service->service_name=$_POST["service_name"];
		$service->service_desc=$_POST["service_desc"];
		$service->content_al=$_POST["contentAL"];
		$service->content_en=$_POST["contentEN"];
		$service->service_img=$_POST["service_img"];
		$photo = $_FILES['img-upload']['name'];
		if($photo){
			$photo = "../images/".time().substr($photo ,strrpos($photo,"."));
			$filename = time().substr($photo ,strrpos($photo,"."));
			//die($photo);
			if (is_uploaded_file($_FILES['img-upload']['tmp_name'])) {
				move_uploaded_file($_FILES['img-upload']['tmp_name'], $photo);
				} else {
				echo "Possible file upload attack. Filename: " . $_FILES['img-upload']['name'];
			}
			$service->service_img = $root_path."/images/".$filename;
		}
		$service->publish_date = date("Y-m-d H:i:s");
		if(isset($_POST["publish-date"]) && $_POST["publish-date"]) $service->publish_date = addslashes($_POST["publish-date"]);
		$service->post_type = "page";
		$service->post_parent = $_POST["parent"];
		$service->post_order = $_POST["rend"];
		
		if($id==0){ //insert
			$service = $service->Insert();
			$id = $service->id_post;
			}else{ //update
			$service = $service->Update();
		}
		//post terms		
		$termrels = $_POST["kat"];
		//delete previous
		$res = mysql_query("DELETE wtr.* FROM web_termrel wtr inner join web_term t on wtr.id_term=t.id_term where t.term_type='category' and id_post='".$id."'");
		if(count($termrels))
		foreach($termrels as $kat)
		{			
			$termrel = new web_termrel();
			$termrel = $termrel->get_by_unique($kat, $id);
			if(!$termrel->id_term_rel){
				$termrel->id_post = $id;
				$termrel->id_term = $kat;
				$termrel->term_order = ($i++);
				$termrel->Insert();
			}
			
		}
		
		$res = mysql_query("DELETE wtr.* FROM web_termrel wtr inner join web_term t on wtr.id_term=t.id_term where t.term_type='tag' and id_post='".$id."'");
		$termrels = $_POST["tags"];
		
		$tags = explode(",",$termrels);
		//shto taget e reja
		$i = 0;
		foreach($tags as $tag)
		{
			$term = new web_term();
			$tag = trim($tag);
			$term = $term->get_by_unique("tag",$tag);
			if(!($term->id_term > 0) && strlen($tag))
			{
				$term->term_al = $tag;
				$term->term_en = $tag;
				$term->term_type = "tag";
				$term->term_parent = 0;
				$term = $term->Insert();
				
			}
			//bej lidhjen
			$termrel = new web_termrel();
			$termrel = $termrel->get_by_unique($term->id_term, $id);
			if(!$termrel->id_term_rel && $term->id_term){
				$termrel->id_post = $id;
				$termrel->id_term = $term->id_term;
				$termrel->term_order = ($i++);
				$termrel->Insert();
			}
			
		}
		
		
		/*postmeta*/
		$service_field = $service_field->get_by_unique($id,"sidebar");
		$service_field->post_id = $id;
		$service_field->meta_key = "sidebar";
		$service_field->meta_value = $_POST["sidebar"];
		if($service_field->meta_id) $service_field->Update(); else $service_field->Insert();
		
		$service_field = $service_field->get_by_unique($id,"sidebar-menu");
		$service_field->post_id = $id;
		$service_field->meta_key = "sidebar-menu";
		$service_field->meta_value = $_POST["smenu"];
		if($service_field->meta_id) $service_field->Update(); else $service_field->Insert();
		
		/**********/
		header("Location:pageedit.php?id=".$id);die();
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
		<title>Modifikim Sherbimi</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css" />
		<link rel="stylesheet" href="../css/style.css" type="text/css" />
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
				<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
				<?php if($msg){echo '<div class="alert alert-success alert-dismissable ">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div>';}?>
				<div class="form-group col-md-12">
					<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> Ruaj</button>
					<a href="pageedit.php" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> Krijo tjeter</a>
					<a href="pagelist.php" class="btn btn-info"><span class="glyphicon glyphicon-back"></span> Kthehu te lista</a>
					<?php if($id) echo '<a href="../p.php?id='.$id.'" class="btn btn-default" target="_blank"><span class="glyphicon glyphicon-eye-open"></span> Shiko si duket</a>';?>
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
									
									if($t->id_category == $id_category) 
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
						<textarea class="form-control ckeditor" id="service_desc" name="service_desc" rows="5" ><?php echo $service->service_desc;?></textarea>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-9">
						<!--Google Map -->
						<div id="gmap">
							
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
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-9">
						<!--Galeria -->
						<label for="img">Imazhi Kryesor</label>
						<a href="upload.php" data-toggle="modal" data-target="#galery"><img data-src="<?php echo get_image_url($service->service_img);?>" src="<?php echo get_image_url($service->service_img);?>" id="img" class="img-rounded" width="250px" alt="Featured Image"></a>
						<input type="text" class="form-control" id="service_img" name="service_img" placeholder="Path" value='<?php echo $service->service_img;?>' onchange="$('#img').attr('src',this.value);"><input type="file" name="img-upload" />
					</div>
					<div class="form-group col-md-3">
						<!--Fushat shtese-->
						<?php
							$groups = $field_group->Find("id_group in (select distinct id_group from web_category_fields` where id_category='".$service->id_category."')");
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
			</form>
		</div>
		<script src="js/holder.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="ckeditor/ckeditor.js"></script>
	</body>
</html>	