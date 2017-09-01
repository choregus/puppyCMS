<?php
	$page_title = "Theme Editor";
	$sidebar_page = "theme-editor.php";
	session_start();
	if (!isset($_SESSION['puppycms-admin'])) {
		header("Location: login.php");
	}

	$settings_file = '../ini/settings.ini';
	$settings = file_get_contents($settings_file);
	$settings = json_decode($settings);

	$theme_dir = '../themes/' .  $settings->site_template;
	$file_to_edit = "";
	if (isset($_GET['file'])) {
		$file_to_edit = $theme_dir . $_GET['file'];
	} else {
		$file_to_edit = $theme_dir . '/style.txt';
	}


	function filesToEdit($dir, $theme_dir){
		echo '<ul class="files_to_edit">';
	    $files_to_select = scandir($dir);

	    unset($files_to_select[array_search('.', $files_to_select, true)]);
	    unset($files_to_select[array_search('..', $files_to_select, true)]);

	    if (count($files_to_select) < 1){
	        return;
	    }

	    foreach($files_to_select as $file_to_select){
	    	$support = ['txt', 'css', 'js'];

	    	if (is_file($dir.'/'.$file_to_select)) {
	    		$extension = substr(strrchr($file_to_select, "."), 1);
		    	$name = $file_to_select;
		    	$file_url = $dir.'/'.$name;
		    	$file_url = str_replace($theme_dir,"",$file_url);
		    	$file_url = 'theme-editor.php?file=' . $file_url;

	    		if ( in_array($extension, $support, true ) ){
		    		echo '<li><i class="fa fa-file-o"></i> <a href="'.$file_url.'">'. $name . '</a></li>';
		    	}
	    	} else if (is_dir($dir.'/'.$file_to_select)){
	    		echo '<li><i class="fa fa-folder-o"></i> ' . $file_to_select;
	    		filesToEdit($dir.'/'.$file_to_select, $theme_dir);
	    		echo '</li>';
	    	}
	    }
		echo '</ul>';
	}

	if (isset($_POST["submit"])) {
		$codes = $_POST['theme-file-editor'];

		$file = fopen($file_to_edit, "w") or die("Unable to open file!");
		fwrite($file, $codes);
		fclose($file);
	}

	$file = file_get_contents($file_to_edit);
	$file_name = substr($file_to_edit, strrpos($file_to_edit, '/') + 1);


	include "header.php";
?>
	<?php include "navbar.php"; ?>
	<?php include "sidebar.php"; ?>

	<div class="main">
		<div class="main-content">
			<div class="container-fluid">

				<div class="panel panel-headline">
					<div class="panel-heading">
						<h3 class="panel-title">Theme Editor</h3>
					</div>
					<div class="panel-body">
						<form class="row" method="post" action="">
							<div class="col-sm-8 col-md-9">
								<div class="form-group">
									<label class="control-label">Soruce Codes - <?php echo $file_name; ?></label>	
									<textarea id="theme-file-editor" name="theme-file-editor" class="" rows="25"><?php echo $file; ?></textarea>
								</div>
							</div>

							<div class="col-sm-4 col-md-3">
								<label class="control-label">List of Files</label>
								<div class="well well-xs">
									<?php
										echo filesToEdit($theme_dir, $theme_dir);
									?>
								</div>
							</div>

							<div class="form-group col-sm-12 text-right">
								<input type="submit" name="submit" class="btn btn-success" value="Submit"/>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			var editor = CodeMirror.fromTextArea(document.getElementById("theme-file-editor"), {
			    lineNumbers: true,
			});

			editor.on('change',function(cMirror){
			  	$('#theme-file-editor').val(editor.getValue());
			});
		});
	</script>
<?php
	include "footer.php";
?>