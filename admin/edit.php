<?php
	$page_title = "Editor";
	$sidebar_page = "page-editor.php";

	session_start();
	if (!isset($_SESSION['puppycms-admin'])) {
		header("Location: login.php");
	}

	$path="../content/". $_GET['name'];
	include("../config.php");

	$file_path = $_GET['name'];

	// $file_folder to get back to correct directory in editor
	$file_folder = substr($file_path, 0, strrpos($file_path, "/"));
	if ($file_folder != "") {
		$file_folder = '/'. $file_folder;
	}
	$file_itself = substr($file_path, strrpos($file_path, '/'));
	$file_itself = ltrim($file_itself, '/');

	# this bit added by JW to stop people editing anything other than txt files - to be ultra safe.
	$escape = ['txt', 'bak', 'html'];
	$extension = substr(strrchr($_GET['name'],'.'),1);
	if ( !in_array($extension, $escape, true ) ){
		header("location:page-editor.php");
	}

	if(isset($_POST['edit-save'])){
		$fileEdit = fopen($path, "w") or die("Unable to open file!");
		$txt = $_POST['fileEdit'];
		
		// #################################################################
		// replace the first instance of a link text name with a link to a url (as selected in config).
		// don't do this for certain pages
		// grab the first 200 characters of this file to see what the title contains.
		$in_title = substr($txt, 0, 200); // read the first 200 characters of the file (the title and desc. usually)
		// dont replace links in pages in this statement below (requires clever people)
		if (strpos($in_title, "404") !== false || strpos($in_title, "404") !== false){

		} else {
			foreach($link_text as $text => $link)
			{
				$in_title = substr($txt, 0, 200); // read the first 200 characters of the file(the title and desc.usually)

				if (strpos($in_title, $text) !== false)
				{
					// only link to words that are NOT in the title tag.e.g.a page with the title of 'Red Strawberries' will not link the word strawberries, but will mangos.
				} else {
					if (strpos($txt, '['.$text.']') == false) {
						$txt = str_replace_first(''.$text.
							'', '['.$text.
							']('.$link.
							')', $txt);
					}
				}
			};

		};

		// YouTube short code replacement code

		$txt = preg_replace('/{{(.*?)}}/', '<div class="yt-video"><iframe src="https://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe></div>', $txt);
		$txt = preg_replace('/{{<iframe/', '<iframe', $txt);



		#################################################################
		
		fwrite($fileEdit, $txt);
		fclose($fileEdit);

		if($_POST['exit'] != 0) {
			header("location:page-editor.php");
		}

	} else {
		if (!(strpos($file_itself, '.bak'))) {
			$backup_file = '../content/' . $file_folder . '/' . date('Y-m-d-His') . "_" . substr($file_itself, 0, strrpos($file_itself, ".")) . '.bak';
			copy ($path, $backup_file);
		}
	}

	$files_list = [];
	$dir = '../content/'.$file_folder;
	$files = scandir($dir);
	foreach($files as $file){
	   	if(($file != '.') && ($file != '..')){
	      	if(is_file($dir.'/'.$file)){
	      		if (strpos($file, '_') && strpos($file, '.bak')) {
	      			$n_file = str_replace('.bak', "", $file);
	      			$f_name = substr($n_file, strrpos($n_file, '_') + 1);
	      			if ($f_name == pathinfo($file_itself, PATHINFO_FILENAME)) {
	      				$files_list[] = $file;
	      			}
	      		}
	      	}
	   	}
	}

	$fileN = file_get_contents($path);

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
						<div class="row">
							<div class="col-md-12">
								<form action="" method="post" enctype="multipart/form-data" id="codeEit" class="pure-form editor-form">
									<div class="clearfix">
										<label class="pull-left">Contents</label>
										<?php 
											if (!empty($files_list)) {
										?>
											<div class="dropdown pull-right">
											  	<button class="btn btn-success btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											    	Available Backup(s)
											    	<span class="caret"></span>
											  	</button>
											  	<ul class="dropdown-menu">
											    	<?php
														foreach($files_list as $file){
															echo '<li><a href="edit.php?name='.$file_folder . '/' .$file.'">'.$file.'</a></li>';
														}
													?>
											  	</ul>
											</div>
										<?php 
											}
										?>
									</div>
										
									<textarea id="area" name="fileEdit"><?php echo $fileN; ?></textarea>

									<input type="hidden" id="makeExit" name="exit" value="0" />
									<input type="hidden" name="edit-save" value="save" />
								</form>
							</div>
						</div>

						<div class="text-right">
							<button class="btn btn-success" title="Save edit" id="save"><i class="fa fa-save"></i> Save</button>
							<a class="btn btn-primary" href="page-editor.php?dir=<?php echo $file_folder;?>" title="Back to file list" id="exit"><i class="fa fa-arrow-left"></i> Back</a>
						</div>

						<div class="alert alert-info text-right margin-top-30">
							CTRL+S = Save | CTRL+Q = Save and Back
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		new SimpleMDE({
			element: document.getElementById("area"),
			spellChecker: true,
		});


		$(document).ready(function(e) {
			$('#save').click(function(e) {
				$('#codeEit').trigger('submit');
			});

			$('#saveexit').click(function(e) {
				$('#makeExit').val("1");
				$('#codeEit').trigger('submit');
			});
		});

		$(document).bind('keydown', function(e) {
			if (e.ctrlKey && (e.which == 83)) {
				e.preventDefault();
				$('#codeEit').trigger('submit');
				return false;
			}
		});

		$(document).bind('keydown', function(e) {
			if (e.ctrlKey && (e.which == 81)) {
				e.preventDefault();
				$('#makeExit').val("1");

				$('#codeEit').trigger('submit');
				return false;
			}
		});
	</script>
<?php
	include "footer.php";
?>