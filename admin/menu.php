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
				<?php } if(checkAccess("POSTIM")){?>
					<li class="dropdown">
						<a href="postlist.php" class="dropdown-toggle" data-toggle="dropdown">Postim <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php if(checkAccess("Lexim-Faqe")){?><li><a href="pagelist.php">Lista e faqeve</a></li><?php }?>
							<?php if(checkAccess("Edit-Faqe")){?><li><a href="pageedit.php">Faqe e re</a></li><?php }?>
							<li class="divider"></li>
							<?php if(checkAccess("Lexim-Sherbim")){?><li><a href="../service.php">Lista e sherbimeve</a></li><?php }?>
							<?php if(checkAccess("Edit-Sherbim")){?><li><a href="../service.php">Sherbim i ri</a></li><?php }?>
							<li class="divider"></li>
							<?php if(checkAccess("Lexim-Kategori")){?><li><a href="terms.php?t=category">Lista e kategorive</a></li><?php }?>
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
				<?php } if(checkAccess("STAFF")){?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Stafi <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php if(checkAccess("Lexim-Staff")){?><li><a href="customlist.php?t=staff">Lista e stafit</a></li><?php }?>
							<?php if(checkAccess("Edit-Staff")){?><li><a href="customedit.php?t=staff">Staf i ri </a></li><?php }?>
							<li class="divider"></li>
							<?php if(checkAccess("Lexim-Lende")){?><li><a href="lectlist.php?t=lende">Lista e lendeve</a></li><?php }?>
							<?php if(checkAccess("Lexim-Dokumenta")){?><li><a href="lectlist.php?t=doc">Lista e dokumentave</a></li><?php }?>
						</ul>
					</li>				
				<?php } if(checkAccess("ANKETE")){?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Ankete <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php if(checkAccess("Lexim-Ankete")){?><li><a href="poll-list.php?t=poll">Lista e anketave</a></li><?php }?>
							<?php if(checkAccess("Edit-Ankete")){?><li><a href="poll-edit.php?t=poll">Ankete e re </a></li><?php }?>
							<li class="divider"></li>
							<?php if(checkAccess("Lexim-Pyetesore")){?><li><a href="lectlist.php?t=lende">Lista e lendeve</a></li><?php }?>
							<?php if(checkAccess("Lexim-Pyetesore")){?><li><a href="lectlist.php?t=doc">Lista e dokumentave</a></li><?php }?>
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