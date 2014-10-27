		<!-- HEADER -->
		<nav class="navbar navbar-default navbar-static-top" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo $root_path;?>">Home</a>
			</div>
			
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
				<?php if(checkAccess("SETTINGS")){?>
					<li class="dropdown">
						<a href="settings.php" class="">Settings</a>
					</li>
				<?php } if(checkAccess("MENU")){?>
				
					<li class="dropdown">
						<a href="menuedit.php" class="">Menu</a>
					</li>
				<?php } if(checkAccess("SHERBIM")){?>
					<li class="dropdown">
						<a href="service-list.php" class="dropdown-toggle" data-toggle="dropdown">Sherbimet <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php if(checkAccess("Lexim-Sherbim")){?><li><a href="service-list.php">Lista e sherbimeve</a></li><?php }?>
							<?php if(checkAccess("Edit-Sherbim")){?><li><a href="service-edit.php">Sherbim i ri</a></li><?php }?>
							<li class="divider"></li>
						</ul>
					</li>
				<?php } if(checkAccess("POSTIM")){?>
					<li class="dropdown">
						<a href="postlist.php" class="dropdown-toggle" data-toggle="dropdown">Postim <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php if(checkAccess("Lexim-Faqe")){?><li><a href="pagelist.php">Lista e faqeve</a></li><?php }?>
							<?php if(checkAccess("Edit-Faqe")){?><li><a href="pageedit.php">Faqe e re</a></li><?php }?>
							<li class="divider"></li>
							<?php if(checkAccess("Lexim-Kategori")){?><li><a href="category.php">Lista e kategorive</a></li><?php }?>
							<li class="divider"></li>
							<?php if(checkAccess("Lexim-Tag")){?><li><a href="terms.php?t=tag">Lista e tag-eve</a></li><?php }?>
							<li class="divider"></li>
							<?php if(checkAccess("Lexim-Testimonials")){?><li><a href="customlist.php?t=testimonial">Lista e Testimonials</a></li><?php }?>
						</ul>
					</li>
				<?php } if(checkAccess("FAQ")){?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Pyetjet e shpeshta <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="customlist.php?t=faq">Lista e FAQ</a></li>
							<li><a href="customedit.php?t=faq">Pyetje e re </a></li>
						</ul>
					</li>
				<?php } if(checkAccess("MEDIA")){?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Media <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php if(checkAccess("Lexim-Galeri")){?><li><a href="customlist.php?t=gallery">Lista e galerive</a></li>
							<li><a href="customlist.php?t=gallery-item">Lista e fotove</a></li><?php }?>
							<?php if(checkAccess("Edit-Galeri")){?><li><a href="customedit.php?t=gallery-item">Shto nje foto</a></li><?php }?>
							<li class="divider"></li>
							<?php if(checkAccess("Lexim-Slider")){?><li><a href="customlist.php?t=slider">Lista e sliders</a></li>
							<li><a href="customlist.php?t=slide">Lista e slideve</a></li><?php }?>
							<?php if(checkAccess("Edit-Slider")){?><li><a href="customedit.php?t=slide">Shto nje slide</a></li><?php }?>
							<li class="divider"></li>
							<?php if(checkAccess("Lexim-Galeri")){?><li><a href="customlist.php?t=video">Lista e videove</a></li><?php }?>
						</ul>
					</li>
				<?php } ?>
				</ul>
				
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION["user_name"];?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#">Profili im</a></li>
							<li class="divider"></li>
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</li>
				</ul>
				<?php if(checkAccess("USERS")){?>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Security <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="users.php">Perdoruesit</a></li>
							<li class="divider"></li>
							<li><a href="roles.php">Konfigurimi i Roleve</a></li>
							<li><a href="actions.php">Te drejtat</a></li
						</ul>
					</li>
				</ul>
				<?php } ?>
			</div><!-- /.navbar-collapse -->
		</nav>
		<!-- END OF HEADER -->