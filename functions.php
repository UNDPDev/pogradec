<?php 
	/* GENERAL FUNCTIONS */
	function get_option($key)
	{
		include_once("cls/cls_web_options.php");
		$opt = new web_options();
		$opt = $opt->get_by_unique($key);
		return $opt;
	}
	function get_option_value($key)
	{
		include_once("cls/cls_web_options.php");
		$opt = new web_options();
		$opt = $opt->get_by_unique($key);
		return $opt?$opt->option_value:"";
	}
	
	/* MENU FUNCTIONS */
	
	function get_menus($parent_id)
	{
		include_once("cls/cls_web_menu.php");
		$menu = new web_menu();
		$menus = $menu->Find("menu_parent='".$parent_id."' order by menu_order");
		return $menus;
	}
	
	/* SLIDER FUNCTIONS */
	
	function get_slider($slider_position) //1 - main slider
	{
		include_once("cls/cls_web_post.php");
		$slider = new web_post();
		$slider = $slider->Find("post_type='slider' and post_parent='0' and post_order='".$slider_position."' limit 1");
		if(count($slider)) return $slider[0];
		return null;
	}
	
	function get_slides($slider_id)
	{
		include_once("cls/cls_web_post.php");
		$slider = new web_post();
		$slides = $slider->Find("post_type='slide' and post_parent='".$slider_id."' order by post_order");
		return $slides;
	}
	
	/* GALLERY FUNCTIONS */
	
	function get_gallery($slider_position) //1 - main slider
	{
		include_once("cls/cls_web_post.php");
		$slider = new web_post();
		$slider = $slider->Find("post_type='gallery' and post_parent='0' and post_order='".$slider_position."' limit 1");
		if(count($slider)) return $slider[0];
		return null;
	}
	
	function get_galleryitems($slider_id)
	{
		include_once("cls/cls_web_post.php");
		$slider = new web_post();
		$slides = $slider->Find("post_type='gallery-item' and post_parent='".$slider_id."' order by post_order");
		return $slides;
	}
	
	/* TESTIMONIALS*/
	
	function get_testimonials()
	{
		include_once("cls/cls_web_post.php");
		$testimonial = new web_post();
		$testimonials = $testimonial->Find("post_type='testimonial' order by post_order limit 5");
		return $testimonials;
	}	
	/* FAQ */
	function get_faqs()
	{
		include_once("cls/cls_web_post.php");
		$faq = new web_post();
		$faq = $faq->Find("post_type='faq' order by post_order");
		return $faq;
	}
	
	/* LEKSIONE / DOC */
	function get_lect($post_type, $parent)
	{
		include_once("cls/cls_web_post.php");
		$posts = new web_post();
		$posts = $posts->Find("post_type='".$post_type."' and post_parent='".$parent."' order by post_order");
		return $posts;
	}
	
	/* PAGES FUNCTIONS */
	
	function get_post($post_id) //1 - main slider
	{
		include_once("cls/cls_web_post.php");
		$post = new web_post();
		$post = $post->get_by_id_post($post_id);
		return $post;
	}
	
	function get_postmeta($post_id, $meta_key)
	{
		include_once("cls/cls_web_postmeta.php");
		$meta = new web_postmeta();
		$meta = $meta->get_by_unique($post_id, $meta_key);
		if($meta->meta_id)	return $meta;
		return null;
	}
	
	function get_post_category($post_id)
	{
		include_once("cls/cls_web_term.php");
		$term = new web_term();
		
		$res = mysql_query("select t.id_term from web_term t inner join web_termrel tr on t.id_term=tr.id_term where id_post='".$post_id."' and t.term_type='category' limit 1");
		if($r = mysql_fetch_array($res)) return $term = $term->get_by_id_term($r[0]);
		return null;
	}
	
	function get_recentposts($limit_nr, $category = '0', $posttype="post",$limit_start = '0') 
	{
		global $lang;
		global $id;
		include_once("cls/cls_web_post.php");
		$post = new web_post();
		$posts = $post->Find("post_type in ('".$posttype."') and ('".$category."'='0' or id_post in (select id_post from web_termrel wtr inner join web_term t on wtr.id_term=t.id_term where t.term_type='category' and t.id_term='".$category."')) and id_post <> '".$id."' order by post_order, publish_date desc limit ".($limit_start*$limit_nr).",".$limit_nr);
		return $posts;
	}
	
	function get_bc($id_post,$i=0)
	{
		global $lang;
		global $root_path;
		if(!$id_post || $i > 5){ echo '<a href="'.$root_path.'" class="btn btn-primary"><i class="glyphicon glyphicon-home"></i></a>';}
		else {
			$post = get_post($id_post);$i++;
			if($post && $post->id_post) get_bc($post->post_parent,$i);
			echo '<a href="p.php?id='.$id_post.'" class="btn btn-default">'.$post->{"title_$lang"}.'</a>';
		}
		return;
	}
	function get_term($term_id)
	{
		include_once("cls/cls_web_term.php");
		$term = new web_term();
		$term = $term->get_by_id_term($term_id);
		return $term;
	}
	
	function get_poll()
	{
		include_once("cls/cls_web_post.php");
		$poll = new web_post();
		$poll = $poll->Find("post_type='poll' and post_parent='0' and post_order='0' limit 1");
		if(count($poll)) return $poll[0];
		return null;
	
	}
	
	function get_excerpt($content, $length = 100)
	{
		
		$text = preg_replace('/<[^>]*>/', '', $content); 
		$text = str_replace("\r", '', $text);    // --- replace with empty space
		$text = str_replace("\n", ' ', $text);   // --- replace with space
		$text = str_replace("\t", ' ', $text);   // --- replace with space
		
		// ----- remove multiple spaces ----- 
		$text = trim(preg_replace('/ {2,}/', ' ', $text));
		$text = substr($text,0,$length);
		return $text."..."; 
		
		
	}
	function get_meta_list()
	{
		return array("post-class", "sidebar", "slider-link", "testimonial-position", "event-startdate", "event-enddate", "event-location", "background", "sidebar-menu", "");
	}
	function get_image_url($url)
	{
		global $root_path;
		if(strpos($url, "http") === false)
			return $root_path.$url;
		else
			return $url;
	}
	$root_path = get_option_value("site_url");
	
	/*GET SITE LANGUAGE*/
	global $lang;
	$lang = "al";
	if(isset($_REQUEST["lang"])) $_SESSION["lang"] = $_REQUEST["lang"];
	if(isset($_SESSION["lang"]) && ($_SESSION["lang"]=="al" || $_SESSION["lang"]=="en")) $lang=$_SESSION["lang"];
	/*******************/
?>