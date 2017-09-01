<?php
	session_start();
	$html_class= "fullscreen-bg";
	$page_title = "Login";
	$password_error = "";
	include "functions.php";

	if (isset($_SESSION['puppycms-admin'])) {
		header("Location: index.php");
	}

	include "header.php";
?>
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box lockscreen clearfix">
					<div class="content">
						<div class="user text-center">
							<img src="http://puppycms.com/content/puppyCMS.png" width="80" class="" alt="Avatar">
							<h1>PuppyCMS</h1>							
						</div>
						<form action="" method="post">
							<label>Enter your password</label>
							<div class="input-group">
								<input type="password" name="password" class="form-control">
								<span class="input-group-btn">
									<button type="submit" name="admin-login" class="btn btn-primary">
										<i class="fa fa-arrow-right"></i>
									</button>
								</span>
							</div>
							<?php
								if ($password_error != "") {
									echo '<p class="text-danger">'. $password_error .'</p>';
								}
							?>
						</form>
					</div>
				</div>
			</div>
		</div>

<?php
	include "footer.php";
?>