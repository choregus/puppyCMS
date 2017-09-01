		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li>
							<a href="index.php">
								<i class="fa fa-dashboard"></i>
								<span>Dashboard</span>
							</a>
						</li>
						<li>
							<a href="page-editor.php">
								<i class="fa fa-file"></i>
								<span>Page Editor</span>
							</a>
						</li>
						<li>
							<a href="theme-editor.php">
								<i class="fa fa-edit"></i>
								<span>Theme Editor</span>
							</a>
						</li>
						<li>
							<a href="menu.php">
								<i class="fa fa-bars"></i>
								<span>Menu</span>
							</a>
						</li>
						<li>
							<a href="settings.php">
								<i class="fa fa-cogs"></i>
								<span>Settings</span>
							</a>
						</li>
						<li style="display:none;">
							<a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Pages</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages" class="collapse ">
								<ul class="nav">
									<li><a href="page-profile.html" class="">Profile</a></li>
									<li><a href="page-login.html" class="">Login</a></li>
									<li><a href="page-lockscreen.html" class="">Lockscreen</a></li>
								</ul>
							</div>
						</li>
					</ul>
				</nav>
			</div>
		</div>

		<script type="text/javascript">
			$(document).ready(function(){
				<?php
					if(isset($sidebar_page)){
				?>
					$('[href="<?php echo $sidebar_page;?>"]').addClass('active');
				<?php
					}
				?>
			});
		</script>