<?php
	require_once("../start.php");
	require_once("../config.php");
	require_once("db.php");
	/* BESMIR ALIA
	 * 02-11-2014
	 * CHECK IF THE USER HAS ACCESS
	 */
	if(!checkAccess("Lexim-Kategori")){ header("Location:index.php");die(); }
	
	require_once("../cls/cls_web_category.php");
	require_once("../cls/cls_web_status.php");
	
	$category = new web_category();
	$status = new web_status();
	
	$q="";if(isset($_REQUEST["q"])) $q = addslashes($_REQUEST["q"]);
	$s="0";if(isset($_REQUEST["s"])) $s = addslashes($_REQUEST["s"]);
	$c="0";if(isset($_REQUEST["c"])) $c = addslashes($_REQUEST["c"]);
	$cl="";if(isset($_REQUEST["cl"])) $cl = addslashes($_REQUEST["cl"]);
	$t="category";if(isset($_REQUEST["t"])) $t = addslashes($_REQUEST["t"]);
	$a="";if(isset($_REQUEST["a"])) $a = addslashes($_REQUEST["a"]);
	$id=0;
	if(isset($_REQUEST["id"])) $id = addslashes($_REQUEST["id"]);
	
	if($id){
		$category = $category->get_by_id_category($id);
		if(!$c) $c = $category->id_parent;
	}
	
	if($a=="delete"){
		$category->Delete();
		header("Location:category.php");die();
	}
	if($_POST){
		$category->category_name=$_POST["category_name"];
		$category->category_desc=$_POST["category_desc"];
		$category->id_parent=$c;
		$category->category_class=$cl;
		$category->category_order=$_POST["category_order"];
		$category->category_img=$_POST["category_img"];
		$category->id_status=$_POST["id_status"];
		
		if($id==0){ //insert
			$category = $category->Insert();
			$id = $category->id_category;
			}else{ //update
			$category = $category->Update();
		}
		header("Location:category.php");die();	
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
		<meta name="description" content="Terms Edit" />
		<meta name="Publisher" content="www.dyqaniim.com" />
		<meta name="Author" content="Besmir Alia" />
		<meta name="copyright" content="www.dyqaniim.com 2013-2015" />
		<meta name="keywords" content="" />
		<meta name="robots" content="index, follow" />
		<meta name="abstract" content="Best Company for Web Design" />
		
		<link rel="shortcut icon" href="favicon.ico" />
		<title>Lista e kategorive</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css"/>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		
	</head>
	<body>
		<?php include_once("menu.php");?>
		<div id="main" class="container">
			<ol class="breadcrumb">
				<li><a href="./">Home</a></li>
				<li><a href="category.php?"><?php echo ucwords($t);?></a></li>
			</ol>
			<div class="row">
				<div class="col-md-3">
					<form role="form" method="post">
						<div class="form-group">
							<label for="category_name">Category Name</label>
							<input type="text" class="form-control" id="category_name" name="category_name" placeholder="Emri" value="<?php echo $category->category_name;?>">
						</div>
						<div class="form-group">
							<label for="category_desc">Description</label>
							<input type="text" class="form-control" id="category_desc" name="category_desc" placeholder="Pershkrimi" value="<?php echo $category->category_desc;?>">
						</div>
						<div class="form-group">
							<label for="category_img">Category Def. Image</label>
							<input type="text" class="form-control" id="category_img" name="category_img" placeholder="url(http://...)" value="<?php echo $category->category_img;?>">
						</div>
						<div class="form-group">
							<label for="cl">CSS Class</label>
							<input type="text" class="form-control" id="cl" name="cl" placeholder="Class" value="<?php echo $category->category_class;?>">
						</div>
						<div class="form-group">
							<label for="id_status">Category Status</label>
							<select class="form-control" name="id_status" id="id_status" >
								<?php							
									$stats = $status->GetAll();
									foreach($stats as $st){
										$selected ="";
										
										if($st->id_status == $category->id_status) 
										$selected = ' selected="selected"';
										echo "<option value='".$st->id_status."' ".$selected .">".$st->status_name."</option>";
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="parent">Parent Category</label>
							<select class="form-control" name="c" id="parent" >
								<option value='0' >No Parent</option>
								<?php							
									$cats = $category->Find("id_parent=0 OR id_parent is null order by 2");
									foreach($cats as $tr){
										$selected ="";
										
										if($tr->id_category == $c) 
										$selected = ' selected="selected"';
										echo "<option value='".$tr->id_category."' ".$selected .">".$tr->category_name."</option>";
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="category_order">Category Order</label>
							<input type="text" class="form-control" id="category_order" name="category_order" placeholder="Class" value="<?php echo $category->category_order;?>">
						</div>
						<button type="submit" class="btn btn-success">Save</button>
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
									<input type='hidden' name='t' value='<?php echo $t;?>' />
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
							function display_terms($id,$j){
								global $category;
								global $t;
								global $q;
								global $s;
								
								$sql=" id_parent='".$id."'";
								if($q) {$sql="term_type='".$t."' and (category_name like '%".$q."%' or category_desc like '%".$q."%' ) ";$q="";}
								
								$terms = $category->Find($sql." limit $s,50");
								foreach($terms as $category){
									$id = $category->id_category;
								?>
								<tr>
									<td class="col-md-5">
									<label><input type="checkbox" id='chk_<?php echo $id;?>'></label>
									<?php for($i=0;$i<$j;$i++) echo "- ";?><?php echo $category->category_name;?> 
									</td>
									<td class="col-md-4"><?php echo $category->category_desc;?></td>
									<td class="col-md-1"><?php echo $category->category_class;?></td>
									<td class="col-md-2"><a href="category.php?id=<?php echo $id;?>" class="">Modifiko</a>&nbsp;|&nbsp;<a href="category.php?a=delete&id=<?php echo $id;?>" class="text-danger">Fshi</a></td>
								</tr>
								<?php	
								
								display_terms($id,$j+1);
								}
							}
							display_terms(null,0);
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