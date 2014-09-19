<?php
	require_once("start.php");
	require_once("../config.php");
	require_once("db.php");	
	//include_once('../functions.php');
	
	global $root_path;
	
	$folder = '../images/';
	$files = glob($folder."{*.jpg,*.gif,*.png}", GLOB_BRACE);
?>
<style>
	.gallery
	{
    display: inline-block;
    margin-top: 20px;
	}
</style>
<script>
	function get_img(url){
		$("#img").attr("src",url);
		$("#post_image").val(url);
		$('#galery').modal('hide')
	}
	
</script>
<div class="container">
	<div class="row">
		<div class='list-group gallery'>
			<?php
				for ($i=0; $i<count($files); $i++) {
					
					$filename = substr($files[$i],strlen($folder),strrpos($files[$i], '.')-strlen($folder));
					$url = $files[$i];
				?>
				<div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
					<a class="thumbnail " onclick='get_img("<?php echo ($url);?>");' href="#">
						<img class="img-responsive" alt="<?php echo $filename;?>" src="<?php echo get_image_url("/".$url);?>" />
						<div class='text-right'>
							<small class='text-muted'><?php echo $filename."(".$url.")";?></small>
						</div> <!-- text-right / end -->
					</a>
				</div> <!-- col-6 / end -->
				<?php    
					
				}
				
			?>
		</div>
	</div>
</div>
