<div id="categories" class="categories">
	<ul>
		<li><a class="home" href="index.php"><i class="icon-cat-home"></i>Home</a></li>
		<?php
			include_once("cls/cls_web_menu.php");
			$menu = new web_menu();
			$menus = $menu->Find("id_parent=1");
			foreach($menus as $menu){
			?>
			<li><a href="<?php echo $menu->menu_link;?>"><i class="<?php echo $menu->menu_class;?>"></i><?php echo $menu->menu_title;?></a></li>
			<?php
			}
		?>
		<!--
			<li><a href="index.php"><i class="icon-cat-rest"></i>Restaurant</a></li>
			<li><a href="index.php"><i class="icon-cat-boat-service"></i>Boat Service</a></li>
			<li><a href="index.php"><i class="icon-cat-hiking"></i>Hiking</a></li>
			<li><a href="index.php"><i class="icon-cat-inhouse"></i>In House Services</a></li>
			<li><a href="index.php"><i class="icon-cat-handmade"></i>Handmade Products</a></li>
			<li><a href="index.php"><i class="icon-cat-take-away"></i>Take-way Food & Drinks</a></li>
			<li><a href="index.php"><i class="icon-cat-tour-travel"></i>Tours & Traveling</a></li>
			<li><a href="index.php"><i class="icon-cat-transport"></i>Transportation</a></li>
			<li><a href="index.php"><i class="icon-cat-water-sport"></i>Water Sports</a></li>
			<li><a href="index.php"><i class="icon-cat-events"></i>Events and Activities</a></li>
			<li><a href="index.php"><i class="icon-cat-institution"></i>Institutions & State Services</a></li>
			<li><a href="index.php"><i class="icon-cat-guide"></i>Guides and Translators</a></li>
			<li><a href="index.php"><i class="icon-cat-art"></i>Art and Culture</a></li>
			<li><a href="index.php"><i class="icon-cat-street-art"></i>Street Artists</a></li>
			<li><a href="index.php"><i class="icon-cat-nature"></i>Nature</a></li>
		-->
	</ul>
</div>
