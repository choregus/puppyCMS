<?php
	$page_title = "Page Editor";
	$sidebar_page = "page-editor.php";
	session_start();
	if (!isset($_SESSION['puppycms-admin'])) {
		header("Location: login.php");
	}

	$inner_dir = "";
	if (isset($_GET['dir'])) {
		$inner_dir = $_GET['dir'];
	}

	// Open a directory, and read its contents
	$dir = "../content" . $inner_dir;
	$directories = array();
	$files_list  = array();
	$files = scandir($dir);
	foreach($files as $file){
	   	if(($file != '.') && ($file != '..')){
	      	if(is_dir($dir.'/'.$file)){
	         	$directories[]  = $file;

	      	}else{
	         	$files_list[]    = $file;

	      	}
	   	}
	}

	$inside = "";
	if ($inner_dir != "") {
		$inside = substr($inner_dir, 1) . '/';
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
						<h3 class="panel-title">Page Editor</h3>
						<p class="subtitle">Add/Remove/Edit files and folders.</p>
					</div>
					<div class="panel-body">
						<div class="text-right">
							<button class="btn btn-primary" title="Create new folder" onClick="addFolder('<?php echo $inside;?>')"><i class="fa fa-folder"></i> New Folder</button>
					    	<button class="btn btn-primary" title="Create new page" onClick="addNew('<?php echo $inside;?>')"><i class="fa fa-file-o"></i> New Page</button>
							<button class="btn btn-primary" title="Upload assets" data-toggle="modal" data-target="#upload-modal" id="uploadbtn"><i class="fa fa-upload"></i> Upload Assets</button>
						</div>
						<hr/>
						<div class="row">
							<div class="col-md-12">
								<?php if ($dh = opendir($dir)){ ?>
									<table class="table editor-files-list" cellspacing="0" width="100%">
								    	<thead>
									      	<tr class="active">
									        	<td>Name</td>
									            <td>Size</td>
									            <td width="200" align="center">Actions</td>
									        </tr>
									    </thead>
									    <tbody>
								      	<?php
									  	if ($inner_dir != "") {
									  		$up = $inner_dir;
									  		$up = substr($up, 0, strrpos($up, "/")); ?>
									  		<tr class="row_select">
									        	<td class="file_name">
													<a href='<?php  echo 'page-editor.php?dir='. $up ?>'><i class="fa fa-level-up"></i> Up</a>
									            </td>
									            
									            <td>
									            	
									            </td>

									            <td align="right">
									            </td>
									        </tr>
									    <?php
									  	}
									  	foreach($directories as $directory){ ?>
											   	<tr class="row_select">
										        	<td class="file_name">
														<a href='<?php  echo 'page-editor.php?dir='. $inner_dir .'/'.$directory; ?>'><i class="fa fa-folder-o"></i> <?php  echo $directory; ?></a>
										            </td>
										            
										            <td>
										            	
										            </td>

										            <td align="right">
										            	<button title="Rename folder" class="rename btn btn-success btn-xs" onClick="renameFolder('<?php  echo $directory; ?>', '<?php  echo $inside;?>')"><i class="fa fa-pencil"></i></button>
										            	<button title="Delete folder" class="delete btn btn-danger btn-xs" onClick="deleteFolder('<?php  echo $inside . $directory; ?>')"><i class="fa fa-trash"></i></button>
										            </td>
										        </tr>
									    	<?php
										}
									  
										foreach($files_list as $file) {
											$file2 = explode('.',$file);
										
											# dont show these types of file in list
											if((isset($file2[1])) && ($file2[1]!="") && ($file2[1]!="php") && ($file2[1]!="js") && ($file2[1]!="css") && ($file2[1]!="bak")) {
												$type=true;
											} else {
												$type=false;
											}

											if($type) { ?>
										        <tr class="row_select">
										        	<td class="file_name">
														<i class="fa fa-file-o"></i> <?php  echo $file; ?>
										            </td>
										            
										            <td>
										            	<?php
															$sizeOfFile = number_format((filesize("../content/". $inside .$file)/1024), 2);
															 
															if($sizeOfFile < 1024){
																echo $sizeOfFile." kb";
															} else if($sizeOfFile >= 1024){
																echo number_format((filesize($sizeOfFile)/1024), 2)." mb";
															}
														?>
										            </td>

										            <td align="right">
										                <?php if($file == "style.txt" || $file == "index.txt" || $file == "thankyou.txt" || $file == "404.txt"){} else {  
										                	
										                ?>
										            	<button title="Rename file" class="rename btn btn-success btn-xs" onClick="renameFile('<?php  echo $file2[0]; ?>', '<?php  echo $file; ?>', '<?php  echo $inside;?>')"><i class="fa fa-pencil"></i></button>

											            <?php }
															$extension = substr(strrchr($file,'.'),1);
															if($extension == "html" || $extension == "txt"){
														?>
											            	<a title="Edit page" class="btn btn-primary btn-xs" href="edit.php?name=<?php  echo $inside . $file; ?>"><i class="fa fa-edit"></i></a>
											            <?php }
											            
											            # don't allow deleting of index or style files for added safety
											            if($file == "style.txt" || $file == "index.txt" || $file == "thankyou.txt" || $file == "404.txt"){} else {
											            ?>
										            	<button title="Delete file or page" class="delete btn btn-danger btn-xs" onClick="deleteFile('<?php  echo $file; ?>', '<?php  echo $inside;?>')"><i class="fa fa-trash"></i></button>
										             <?php } ?>
											            
										            </td>
										        </tr>
									        <?php
										}
								      
								    } 
								?>
										</tbody>
									</table>
								<?php } 
									closedir($dh);
								?>
							</div>
						</div>

						<div class="alert alert-info margin-top-30">
							<?php
								if (class_exists('ZipArchive')) {
							?> 
								<a href="backup.php"><b>Backup files to zip</b></a> (zip archive will appear in list above)<?php } ?> | List of <a href="../content/bak">Previous File Edits</a>.
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

    <div class="modal fade" id="upload-modal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<form enctype="multipart/form-data" action="functions.php" method="post" class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Upload</h4>
				</div>
				<div class="modal-body">
					<label>Select file</label>
	      			<input class="btn btn-default btn-block" type="file" name="uploadFile" />
	      			<input type="hidden" name="path" value="<?php echo $inside;?>" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" name="asset-upload" class="btn btn-success">Upload</button>
				</div>
			</form>
		</div>
	</div>
<?php
	include "footer.php";
?>