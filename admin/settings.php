<?php
	$page_title = "Settings";
	$sidebar_page = "settings.php";
	session_start();
	if (!isset($_SESSION['puppycms-admin'])) {
		header("Location: login.php");
	}

	$settings_file = '../ini/settings.ini';
	$settings = file_get_contents($settings_file);
	$settings = json_decode($settings);

	if (isset($_POST["submit"])) {
		$errors = [];
		$first_run = 0;
		$site_name = $_POST['site_name'];
		$site_root = $_POST['site_root'];
		$site_template = $_POST['site_template'];
		$from_email = $_POST['from_email'];
		$password = $_POST['password'];
		$password_repeat = $_POST['password-repeat'];

		$check = false;
		include "../lib/passwordLib.php";

		if ($password != $password_repeat) {
			$errors[] = "Password did not match.";

		} else if ($password != "" && $password_repeat != "") {
			$password = password_hash($password, PASSWORD_DEFAULT);
			$settings->admin_password = $password;
			$check = true;

		} else if ($password == "") {
			$check = true;
		}

		if ($check == true) {
			$settings->first_run = $first_run;
			$settings->site_name = $site_name;
			$settings->site_root = $site_root;
			$settings->site_template = $site_template;
			$settings->from_email = $from_email;

			$file = fopen($settings_file, "w") or die("Unable to open file!");
			fwrite($file, json_encode($settings));
			fclose($file);
		}
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
						<h3 class="panel-title">Editor</h3>
						<p class="subtitle">Add/Remove/Edit files and folders.</p>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" method="post" action="">
							<div class="form-group">
								<label class="col-sm-2 control-label">Site Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="site_name" id="site_name" value="<?php echo $settings->site_name;?>" required>
									<div class="text-muted">e.g. Steve's Site</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Site Root</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="site_root" id="site_root" value="<?php echo $settings->site_root;?>" required>
									<div class="text-muted">The folder in which you install puppyCMS. If its at the root of a domain, then simply put '/'. For any other folder, please use trailing slash.</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Password</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" name="password" id="password" value="<?php echo ""?>">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Password Repeat</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" name="password-repeat" id="password-repeat" value="<?php echo ""?>">
								</div>
							</div>

							<?php
								$template_selects = "";
								foreach(glob('../themes/*', GLOB_ONLYDIR) as $dir) {
								    $dir = str_replace('../themes/', '', $dir);
								    $template_selects .= '<option value="'.$dir.'">'.ucwords(str_replace("-"," ",$dir)).'</option>';
								}
							?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Site Template/Theme</label>
								<div class="col-sm-10">
									<select class="form-control" name="site_template" id="site_template">
										<?php echo $template_selects; ?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Form Email</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" name="from_email" id="from_email" value="<?php echo $settings->from_email;?>">
									<div class="text-muted">Email for forms - this is the email your enquiries will go to.</div>
								</div>
							</div>

							<div class="form-group text-right">
								<div class="col-sm-12">
									<input type="submit" name="submit" class="btn btn-success" value="Submit"/>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


	<script type="text/javascript">
		$(document).ready(function(){
			$('#site_template').val('<?php echo $settings->site_template;?>');
			$('[name="show_edit"][value="<?php echo $settings->show_edit;?>"]').click();
			$('[name="puppy_link"][value="<?php echo $settings->puppy_link;?>"]').click();
		});
	</script>
<?php
	include "footer.php";
?>