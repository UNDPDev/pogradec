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
	$term = new web_term();
	$termrel = new web_termrel();
	$id=0;
	$post_type="";if(isset($_REQUEST["t"])) $post_type = addslashes($_REQUEST["t"]); else die("Tipi i postimit");
	if(isset($_REQUEST["id"])) $id = addslashes($_REQUEST["id"]);
	$msg="";
	if(isset($_REQUEST["msg"])) $msg = addslashes($_REQUEST["msg"]);
	
	
	if($id){
		$post = $post->get_by_id_post($id);
		$postmetas = $postmeta->get_by_post_id($id);
		$termrels = $termrel->get_by_id_post($id);
	}
	if($_POST){
		$post->title_al=$_POST["titleAL"];
		$post->title_en=$_POST["titleEN"];
		$post->content_al=$_POST["contentAL"];
		$post->content_en=$_POST["contentEN"];
		$post->post_image=$_POST["post_image"];
		$photo = $_FILES['img-upload']['name'];
		if($photo){
			$photo = "../docs/".time().substr($photo ,strrpos($photo,"."));
			$filename = time().substr($photo ,strrpos($photo,"."));
			//die($photo);
			if (is_uploaded_file($_FILES['img-upload']['tmp_name'])) {
				move_uploaded_file($_FILES['img-upload']['tmp_name'], $photo);
				} else {
				echo "Possible file upload attack. Filename: " . $_FILES['img-upload']['name'];
			}
			$post->post_image = $root_path."/docs/".$filename;
		}
		$post->publish_date = date("Y-m-d H:i:s");
		if(isset($_POST["publish-date"]) && $_POST["publish-date"]) $post->publish_date = addslashes($_POST["publish-date"]);
		$post->post_type = $post_type;
		$post->post_parent = $_POST["parent"];
		$post->post_order = $_POST["rend"];
		
		if($id==0){ //insert
			$post = $post->Insert();
			$id = $post->id_post;
			}else{ //update
			$post = $post->Update();
		}
		
		/*
		//post terms
		$termrels = $_POST["kat"];
		//delete previous
		$res = mysql_query("DELETE FROM web_termrel where id_post='".$id."'");
		
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
		*/
		header("Location:lectedit.php?t=".$post_type."&id=".$post->id_post);die();
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
		<meta name="description" content="Lecture Edit" />
		<meta name="Publisher" content="www.dyqaniim.com" />
		<meta name="Author" content="Besmir Alia" />
		<meta name="copyright" content="www.dyqaniim.com 2013-2015" />
		<meta name="keywords" content="" />
		<meta name="robots" content="index, follow" />
		<meta name="abstract" content="Best Company for Web Design" />
		
		<link rel="shortcut icon" href="favicon.ico" />
		<title>Modifikim Leksioni</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
		<link rel="stylesheet" href="css/bootstrap-theme.min.css" type="text/css" />
		<script src="../js/jquery-1.9.1.min.js"></script>
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
				<input type="hidden" class="form-control" id="t" name="t" value="<?php echo $post_type;?>">
				<?php if($msg){echo '<div class="alert alert-success alert-dismissable ">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$msg.'</div>';}?>
				<div class="form-group col-md-12">
					<button type="submit" class="btn btn-success">Ruaj</button>
					<a href="lectedit.php?t=<?php echo $post_type;?>" class="btn btn-info">Krijo tjeter (<?php echo $post_type;?>)</a>
					<a href="lectlist.php?t=<?php echo $post_type;?>" class="btn btn-info">Kthehu te lista (<?php echo $post_type;?>)</a>
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
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="img">Dokumenti</label>
						<a href="<?php echo get_image_url($post->post_image);?>" data-toggle="modal" data-target="#galery"><?php echo $post->title_al;?></a>
						<input type="text" class="form-control" id="post_image" name="post_image" placeholder="Path" value='<?php echo $post->post_image;?>' ><input type="file" name="img-upload" />
					</div><!--
					<div class="form-group">
						<label for="tags">Tags</label>
						<input type="text" class="form-control" id="tags" name="tags" placeholder="Tags">
					</div>
					<div class="form-group">
						<label for="kat">Kategorite</label>
						<select multiple class="form-control" id="kat" name="kat[]">
							<?php		/*					
								$terms = $term->Find("term_type='category' order by term_parent");
								foreach($terms as $t){
									$selected ="";
									foreach($termrels as $tr)
									if($t->id_term == $tr->id_term) 
									$selected = ' selected="selected"';
									echo "<option value='".$t->id_term."' ".$selected .">".$t->term_al."</option>";
								}
								*/
							?>
						</select>
					</div>-->
					<div class="form-group">
						<label for="parent">Pedagogu / Lenda</label>
						<select class="form-control" id="parent" name="parent">
							<option value="0" selected="selected">No Parent</option>
							<?php
								if($post_type=="lende") $pt = "staff";
								if($post_type=="doc") $pt = "lende";
								$posts = $post->Find("(post_type='".$pt."' ) order by title_al");
								foreach($posts as $p){
									$selected ="";
									$pedag = '';
									if($p->post_parent){
										$par = $post->get_by_id_post($p->post_parent);
										$pedag = $par->title_al;
									}
									if($p->id_post == $post->post_parent) $selected = ' selected="selected"';
									echo "<option value='".$p->id_post."' ".$selected .">".$p->title_al." (".$pedag.")</option>";
								}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="rend">Renditje</label>
						<input type="number" class="form-control" id="rend" name="rend" placeholder="Renditje" value="<?php echo $post->post_order;?>">
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
				
			</form>
		</div>
		<script src="js/holder.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="ckeditor/ckeditor.js"></script>
	</body>
</html>