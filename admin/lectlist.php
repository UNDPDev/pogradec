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
	
	$q="";if(isset($_REQUEST["q"])) $q = addslashes($_REQUEST["q"]);
	$p="";if(isset($_REQUEST["p"])) $p = addslashes($_REQUEST["p"]);
	$c="0";if(isset($_REQUEST["c"])) $c = addslashes($_REQUEST["c"]);
	$s="0";if(isset($_REQUEST["s"])) $s = addslashes($_REQUEST["s"]);
	$post_type="";if(isset($_REQUEST["t"])) $post_type = addslashes($_REQUEST["t"]); else die("Tipi i postimit");
	
	
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
		<title>Lista e <?php echo $post_type;?></title>
		<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
		<script src="../js/jquery-1.9.1.min.js"></script>
		
	</head>
	<body>
		<?php include_once("menu.php");?>
		<div id="main" class="container">
			<div class="row">
				<div class="col-md-12"><a href="lectedit.php?t=<?php echo $post_type;?>" class="btn btn-primary btn-success" role="button">Shto nje <?php echo $post_type;?></a></div>
			</div>
			<div class="panel panel-default">
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
						<div class="col-md-3"><!--
							<select class="form-control" name="c" onchange="window.location='lectlist.php?t=<?php echo $post_type;?>&c='+this.value">
								<option value='0' >Kategoria</option>
								<?php							
									$terms = $term->Find("term_type='category' and id_term in (select distinct id_term from web_termrel wtr inner join web_post p on wtr.id_post=p.id_post where p.post_type='".$post_type."') order by term_parent");
									foreach($terms as $t){
										$selected ="";
										
										if($t->id_term == $c) 
										$selected = ' selected="selected"';
										echo "<option value='".$t->id_term."' ".$selected .">".$t->term_al."</option>";
									}
								?>
							</select>-->
							<select class="form-control" name="c" onchange="window.location='lectlist.php?t=<?php echo $post_type;?>&p='+this.value">
								<option value='0' >Pedagogu</option>
								<?php							
									$posts = $post->Find("post_type='staff' and id_post in (select distinct post_parent from web_post p where p.post_type='lende') order by title_al");
									foreach($posts as $t){
										$selected ="";
										
										if($t->id_post == $p) 
										$selected = ' selected="selected"';
										echo "<option value='".$t->id_post."' ".$selected .">".$t->title_al."</option>";
									}
								?>
							</select>
						</div>
						<div class="col-md-4">
							<form class="form-inline pull-right" role="form">
								<div class="form-group">									
									<input type="hidden" class="form-control" id="t" name="t" value="<?php echo $post_type;?>">
									<input type="search" class="form-control" id="q" name="q" placeholder="Kerko" value="<?php echo $q;?>">
								</div>
								<button type="submit" class="btn btn-default">Kerko</button>
							</form>
						</div>
						<div class="col-md-2">
							<div class="btn-toolbar pull-right" role="toolbar">
								<div class="btn-group">
									<?php if($s>0) {?><a href="<?php echo '?q='.$q.'&t='.$post_type.'&s='.($s-1).'&c='.$c;?>" type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-backward"></span></a>
									<?}?>
									<button type="button" class="btn btn-default"><?php echo ($s+1);?></button>
									<a href="<?php echo '?q='.$q.'&t='.$post_type.'&s='.($s+1).'&c='.$c;?>" type="button" class="btn btn-default"><span class="glyphicon glyphicon-step-forward"></span></a>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				
				<!-- Table -->
				<table class="table table-hover">
					<?php
						$posts = $post->Find(" post_type='".$post_type."' and (title_al like '%".$q."%' or title_en like '%".$q."%') and (post_parent='".$p."' or '".$p."'='0') order by id_post desc limit ".($s*20).",20");
						foreach($posts as $post){
							$id = $post->id_post;
							//$img = $post->post_image;
							if($img=="") $img = "holder.js/50x50";
						?>
						<tr>
							<td class="col-xs-1"><label><input type="checkbox" id='chk_<?php echo $id;?>'></label></td>
							<td class="col-xs-1"><img data-src="<?php echo get_image_url($img);?>" src="<?php echo get_image_url($img);?>" class="img-rounded" alt="50x50" border="0" width="50px" height="50px" /></td>
							<td class="col-xs-6"><strong><?php echo $post->title_al;?></strong> | <?php echo $post->title_en;?><br/><span class="small"><?php echo $post->publish_date;?></span>
								<br/><span class="small"><a href="lectedit.php?t=<?php echo $post_type;?>&id=<?php echo $id;?>" class="">Modifiko</a></span>&nbsp;|&nbsp;<span class="small"><a href="#" class="text-danger">Fshi</a></span></td>
							<td class="col-xs-4">
								<span class="small">Pedagogu: </small><?php $pp = new web_post(); $pp = $pp->get_by_id_post($post->post_parent); 
									if($pp && $pp->id_post) echo "<a href='customedit.php?t=staff&id=".$pp->id_post."'>".$pp->title_al."</a>"; ?>
							</td>
						</tr>
						<?php
						}
					?>	
				</table>
			</div>
		</div>
		
		<script src="js/bootstrap.min.js"></script>
		<script src="js/holder.js"></script>
	</body>
<html>