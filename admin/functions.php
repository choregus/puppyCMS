<?php
	$settings_file = '../ini/settings.ini';
	$settings = file_get_contents($settings_file);
	$settings = json_decode($settings);

	if (isset($_POST['admin-login'])) {
		$password = $_POST["password"];
		include "../lib/passwordLib.php";
		
		if (password_verify($password, $settings->admin_password)) {
		    $_SESSION['puppycms-admin'] = 1;
		} else {
		    $password_error = "Invalid password. Please try again.";
		}
	}

	/// Assets Upload function 
	if(isset($_POST['asset-upload'])){
		$uploadFile = $_FILES['uploadFile'];
		$dir_path = $_POST['path'];

		if($uploadFile['size'] > 1) {
			$exten = explode(".", strrev($uploadFile['name']));
			$run = false;
			if($exten[0] == "txt") {
				$run = true;
			}else if($exten[0] == "gpj"){
				$run = true;
			}else if($exten[0] == "fig"){
				$run = true;
			}else if($exten[0] == "gnp"){
				$run = true;
			}else if($exten[0] == "fdp"){
				$run = true;
			}

			if($run)
			{
				$path_file = "../content/" . $dir_path .$uploadFile['name'];
				move_uploaded_file($uploadFile['tmp_name'], $path_file);
				
			}else{
				
			}
		}

		$dir_path = substr($dir_path, 0, strrpos($dir_path, "/"));
		if ($dir_path != "") {
			$dir_path = '/' . $dir_path;
		}

		header("Location: page-editor.php?dir=".$dir_path);
   		exit;
	}

	/// File rename function
	if (isset($_POST['fileRename'])) {
		$oldName = $_POST['oldName'];
		$rename = $_POST['fileRename'];
		$dir_path = $_POST['path'];

		$rename = str_replace(" ", "-", $rename);
		$rename = pathinfo($rename, PATHINFO_FILENAME);

		$type=explode('.',$oldName);

		$path= "../content/" . $dir_path . $oldName;
		$newPath= "../content/" . $dir_path . $rename.".".$type[1];
		rename($path,$newPath);

		echo "Re-named file ".$path." to ".$newPath;
	}

	/// File rename function
	if (isset($_POST['renameFolder'])) {
		$oldName = $_POST['oldFolder'];
		$rename = $_POST['renameFolder'];
		$dir_path = $_POST['path'];

		$rename = str_replace(" ", "-", $rename);
		$rename = pathinfo($rename, PATHINFO_FILENAME);

		$path= "../content/" . $dir_path . $oldName;
		$newPath= "../content/" . $dir_path . $rename;
		rename($path,$newPath);

		echo "Re-named file ".$path." to ".$newPath;
	}

	/// File delete function
	if (isset($_POST['deleteFile'])) {
		$dir_path = $_POST['path'];
		$file = "../content/" . $dir_path . $_POST['deleteFile'];

		if (!unlink($file)){
		  	echo ("Error deleting $file");
		} else {
		  	echo ("Deleted $file");
		}
	}

	/// Folder delete function
	if (isset($_POST['deleteFolder'])) {
		$folder = "../content/" . $_POST['deleteFolder'];

		function remove_directory($dir) {
		  	if (is_dir($dir)) {
			    $objects = scandir($dir);
			    foreach ($objects as $object) {
			      	if ($object != "." && $object != "..") {
			        	if (filetype($dir."/".$object) == "dir") {
			           		remove_directory($dir."/".$object); 
			        	} else {
			        		unlink   ($dir."/".$object);
			        	}
			      	}
			    }
		    	reset($objects);
		    	rmdir($dir);
		  	}
		}
		remove_directory($folder);
	}

	/// File create function
	if (isset($_POST['addNew'])) {
		$name = $_POST['addNew'];
		$dir_path = $_POST['path'];

		$name = str_replace(" ", "-", $name);
		$name = pathinfo($name, PATHINFO_FILENAME);

		$path = '../content/' . $dir_path . $name.'.txt';

		$myfile = fopen($path, "w");
		
		$toreturn = $dir_path . $name.'.txt';

		echo $toreturn;
	}

	/// Folder create function
	if (isset($_POST['addFolder'])) {
		$name = $_POST['addFolder'];
		$dir_path = $_POST['path'];

		$name = str_replace(" ", "-", $name);
		$name = pathinfo($name, PATHINFO_FILENAME);

		$path = '../content/' . $dir_path . $name;

		mkdir($path);

		echo $path;
	}
?>