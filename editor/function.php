<?php
	if (isset($_POST['rename'])) {
		$oldName=$_POST['oldName'];
		$rename = $_POST['rename'];

		$rename = str_replace(" ", "-", $rename);
		$rename = pathinfo($rename, PATHINFO_FILENAME);

		$type=explode('.',$oldName);

		$path= "../content/".$oldName;
		$newPath= "../content/".$rename.".".$type[1];
		rename($path,$newPath);

		echo "Re-named file ".$path." to ".$newPath;
	}

	if (isset($_POST['oldName'])) {
		$file = "../content/".$_POST['oldName'];
		if (!unlink($file)){
		  	echo ("Error deleting $file");
		} else {
		  	echo ("Deleted $file");
		}
	}

	if (isset($_POST['pathx'])) {
		$name = $_POST['pathx'];

		$name = str_replace(" ", "-", $name);
		$name = pathinfo($name, PATHINFO_FILENAME);

		$path = '../content/'.$name.'.txt';

		$myfile = fopen($path, "w");
		
		$toreturn = $name.'.txt';

		echo $toreturn;
	}

?>