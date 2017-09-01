<?php
	$page_title = "Dashboard";
	$sidebar_page = "index.php";
	session_start();
	if (!isset($_SESSION['puppycms-admin'])) {
		header("Location: login.php");
	}

	include "header.php";
?>
	<?php include "navbar.php"; ?>
	<?php include "sidebar.php"; ?>

	<div class="main">
		<div class="main-content">
			<div class="container-fluid">

				<div class="panel panel-headline">
					<div class="panel-heading">
						<h3 class="panel-title">Dashboard</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 text-center">
								<img src="http://puppycms.com/content/puppyCMS.png" class="center-block" width="100">
								<h1 style="line-height:normal;">
									Welcome to
									<br/>
									<u><i><b>PuppyCMS</b></i></u>
									<br/>
									Admin Dashboard.
								</h1>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	include "footer.php";
?>