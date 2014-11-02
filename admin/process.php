<?php	
	require_once("../start.php");
	require_once("../config.php");
	require_once("db.php");
	require_once("../functions.php");
	require_once("../cls/cls_web_service.php");
	require_once("../cls/cls_web_service_gallery.php");
	
	if(isset($_REQUEST["id"])&&$_REQUEST["id"]!=0)
	{
		// Generate filename
		$filename = md5(mt_rand()).'.jpg';
		$data = file_get_contents('php://input');
		$image = file_get_contents('data://'.substr($data, 5));
		
		// Save to disk
		if ( ! file_put_contents("../images/".$filename, $image))
		{
			header('HTTP/1.1 503 Service Unavailable');
			exit();
		}
		else
		{
            $service_gallery = new web_service_gallery();
            $service_gallery->id_service=$_REQUEST["id"];
            $service_gallery->img_path = get_image_url("images/".$filename);
			if( $service_gallery->Insert()!=null)
			{
				echo $service_gallery->img_path;
			}
			
		}
	}
	
	
	// Clean up memory
	unset($data);
	unset($image);
	
?>
