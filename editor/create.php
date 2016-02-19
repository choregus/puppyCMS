<?php

	$path = $_POST['pathx'];

	$myfile = fopen($path, "w");
	
	echo "File ".$path." created";
?>