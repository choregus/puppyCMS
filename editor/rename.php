<?php
$oldName=$_POST['oldName'];
$rename = $_POST['rename'];

$type=explode('.',$oldName);

$path= "../content/".$oldName;
$newPath= "../content/".$rename.".".$type[1];
rename($path,$newPath);

echo "Re-named file ".$path." to ".$newPath;
?> 