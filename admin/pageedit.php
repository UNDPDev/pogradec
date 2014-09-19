<?php
	require_once("../start.php");
	require_once("../config.php");
	require_once("db.php");
	require_once("../cls/cls_web_post.php");
	require_once("../cls/cls_web_postmeta.php");
	require_once("../cls/cls_web_term.php");
	require_once("../cls/cls_web_termrel.php");
	require_once("../cls/cls_web_menu.php");
	
	$post = new web_post();
	$postmeta = new web_postmeta();
	$postmetas = array();
	$term = new web_term();
	$termrel = new web_termrel();
	$wmenu = new web_menu();
	$id=0;
	if(isset($_REQUEST["id"])) $id = addslashes($_REQUEST["id"]);
	$msg="";
	if(isset($_REQUEST["msg"])) $msg = addslashes($_REQUEST["msg"]);
	
	$post->post_image="http://placehold.it/900x300.png";
	if($id){
		$post = $post->get_by_id_post($id);
		if($post->post_type && $post->post_type !='page') {header("Location:".$post->post_type."edit.php?id=".$id);die();}
		$postmetas = $postmeta->get_by_post_id($id);
		$termrels = $termrel->get_by_id_post($id);
		if(isset($_REQUEST["a"]) && $_REQUEST["a"]=="delete")
		{
			mysql_query("delete from web_postmeta where post_id='".$id."'");
			$post->Delete();		
			header("Location:pagelist.php");
			die();
		}
	}
	if($_POST){
		$post->title_al=$_POST["titleAL"];
		$post->title_en=$_POST["titleEN"];
		$post->content_al=$_POST["contentAL"];
		$post->content_en=$_POST["contentEN"];
		$post->post_image=$_POST["post_image"];
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
			$post->post_image = $root_path."/images/".$filename;
		}
		$post->publish_date = date("Y-m-d H:i:s");
		if(isset($_POST["publish-date"]) && $_POST["publish-date"]) $post->publish_date = addslashes($_POST["publish-date"]);
		$post->post_type = "page";
		$post->post_parent = $_POST["parent"];
		$post->post_order = $_POST["rend"];
		
		if($id==0){ //insert
			$post = $post->Insert();
			$id = $post->id_post;
			}else{ //update
			$post = $post->Update();
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
		$postmeta = $postmeta->get_by_unique($id,"sidebar");
		$postmeta->post_id = $id;
		$postmeta->meta_key = "sidebar";
		$postmeta->meta_value = $_POST["sidebar"];
		if($postmeta->meta_id) $postmeta->Update(); else $postmeta->Insert();
		
		$postmeta = $postmeta->get_by_unique($id,"sidebar-menu");
		$postmeta->post_id = $id;
		$postmeta->meta_key = "sidebar-menu";
		$postmeta->meta_value = $_POST["smenu"];
		if($postmeta->meta_id) $postmeta->Update(); else $postmeta->Insert();
		
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
		<title>Modifikim Faqe</title>
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
				<div class="col-md-9">
					<div class="form-group col-md-6">
						<label for="titleAL">Tituli AL</label>
						<input type="text" class="form-control" id="titleAL" name="titleAL" placeholder="Titulli Shqip" value="<?php echo $post->title_al;?>">
					</div>
					<div class="form-group col-md-6">
						<label for="titleAL">Tituli EN</label>
						<input type="text" class="form-control" id="titleEN" name="titleEN" placeholder="Titulli Anglisht" value="<?php echo $post->title_en;?>">
					</div>
					<div class="form-group ">
						<label for="contentAL">Content AL</label>
						<textarea class="form-control ckeditor" id="contentAL" name="contentAL" rows="10"><?php echo $post->content_al;?></textarea>
					</div>
					<div class="form-group ">
						<label for="contentEN">Content EN</label>
						<textarea class="form-control ckeditor" id="contentEN" name="contentEN" rows="10"><?php echo $post->content_en;?></textarea>
					</div>
					<?php
						if($id){
						?>
						<div class="form-group well" id="metas">
							<dl>
								<?php
									
									foreach($postmetas as $postmeta)
									{
										echo "<div id='d_".$postmeta->meta_id."'>";
										echo "<dt>".$postmeta->meta_key."</dt>";
										echo "<dd><button type='button' class='btn btn-danger btn-xs' title='Delete' onclick='deletemeta(".$postmeta->meta_id.");'><span class='glyphicon glyphicon-trash'></span></button> ".$postmeta->meta_value." </dd>";
										echo "</div>";
									}
								?>
							</dl>
						</div>
						<?php
						}
					?>
				</div>
				<div class="col-md-3">
					<div class="form-group">
					<label for="img">Imazhi Kryesor</label>
					<a href="upload.php" data-toggle="modal" data-target="#galery"><img data-src="<?php echo get_image_url($post->post_image);?>" src="<?php echo get_image_url($post->post_image);?>" id="img" class="img-rounded" width="250px" alt="Featured Image"></a>
					<input type="text" class="form-control" id="post_image" name="post_image" placeholder="Path" value='<?php echo $post->post_image;?>' onchange="$('#img').attr('src',this.value);"><input type="file" name="img-upload" />
				</div>
				<div class="form-group">
					<label for="kat">Kategorite</label>
					<select multiple class="form-control" id="kat" name="kat[]" rows="5">
						<?php							
							$terms = $term->Find("term_type='category' order by term_parent");
							foreach($terms as $t){
								$selected ="";
								if(count($termrels))
									foreach($termrels as $tr)
										if($t->id_term == $tr->id_term)
											$selected = ' selected="selected"';
								echo "<option value='".$t->id_term."' ".$selected .">".$t->term_al."</option>";
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="smenu">Menu Anesore</label>
					<select class="form-control" name="smenu" id="smenu" >
						<option value='0' >Nuk ka menu</option>
						<?php
							$smenu = 0;
							if($id) {
								$pmeta = get_postmeta($id, "sidebar-menu");
								if($pmeta)
								{
									$smenu = $pmeta->meta_value;
								}
							}
							$wmenus = $wmenu->GetAll();
							foreach($wmenus as $tr){
								$selected ="";
								
								if($tr->id_menu == $smenu) 
								$selected = ' selected="selected"';
								echo "<option value='".$tr->id_menu."' ".$selected .">".$tr->title_al." (ID:".$tr->id_menu.")</option>";
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="parent">Parent</label>
					<select class="form-control" id="parent" name="parent">
						<option value="0" selected="selected">No Parent</option>
						<?php
							$posts = $post->Find("post_type='page' order by post_order");
							foreach($posts as $p){
								$selected ="";
								if($p->id_post == $post->post_parent) $selected = ' selected="selected"';
								echo "<option value='".$p->id_post."' ".$selected .">".$p->title_al."</option>";
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="rend">Renditje</label>
					<input type="number" class="form-control" id="rend" name="rend" placeholder="Renditje" value="<?php echo $post->post_order;?>">
				</div>
				<div class="form-group">
					<label for="sidebar">Sidebar Position</label>
					<select class="form-control" id="sidebar" name="sidebar">
						<?php 
							$sidebar = 1;
							$pmeta = get_postmeta($id, "sidebar");
							if($pmeta)
							{
								$sidebar = $pmeta->meta_value;
							}
						?>
						<option value="1" <?php if(1 == $sidebar) echo "selected='selected'";?>>Majtas</option>
						<option value="2"<?php if(2 == $sidebar) echo "selected='selected'";?>>Djathtas</option>
						<option value="0"<?php if(0 == $sidebar) echo "selected='selected'";?>>Fullwidth</option>
					</select>
				</div>
				<div class="form-group">
					<label for="tags">Tags</label>
					<input type="text" class="form-control" id="tags" name="tags" placeholder="Tags" value="<?php 
						$termrels = $termrel->get_by_id_post($id);
						foreach($termrels as $tr){
							$term = $term->get_by_id_term($tr->id_term); 
							if($term->term_type=="tag") 
							echo $term->term_al.",";
						} ?>">
				</div>
				<div class="form-group">
					<label for="publish-date">Data</label>
					<input type="text" class="form-control" id="publish-date" name="publish-date" placeholder="Data" value="<?php echo $post->publish_date;?>">
				</div>
				<?php if($id){?>
					<div class="form-group well">
						<label for="meta-key">Te tjera</label>
						<select name="meta-key" id="meta-key" class="form-control">
							<option value="">-Zgjidh-</option> 
							<?php 
								$metas = get_meta_list();
								foreach($metas as $meta) echo "<option value='".$meta."'>".$meta."</option>";						
							?>
						</select>
						<input type="text" class="form-control" id="meta-value" />
						<button type='button' class='btn btn-info btn-xs' title='Shto' onclick='addmeta();'><span class='glyphicon glyphicon-plus'></span> Shto</button>
					</div>
				<?php }?>
				</div>
				</form>
			</div>
			<div id="galery" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
					<div class="modal-content">
						
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title" id="myModalLabel">Zgjidh foto</h4>
						</div>
						<div class="modal-body">
							<h4>Fotografia</h4>
							<p>Lista e fotove</p>
							
							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary">Save changes</button>
						</div>
						
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div>
			<script src="js/holder.js"></script>
			<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
			<script src="ckeditor/ckeditor.js"></script>
		</body>
	</html>