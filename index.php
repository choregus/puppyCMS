<?php include('config.php');?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $title ? $title : $default_title; ?></title>
</head>
<body>
<xmp theme="<?php echo $bootswatch_theme; ?>" style="display:none;">
<div class="row">
<div class="span9">
<?php echo $content; ?>
</div>
<div class="span3">
<?php
//show the list of files in the content directory
$files = array();
$dir = opendir(CONTENT_DIR);
while(false != ($file = readdir($dir))) {
        if(($file != ".") and ($file != "..") and ($file != "404.txt") and ($file != "index.txt") and (strpos($file, 'txt') !== false)) {
						$files[] = str_replace(".txt","",$file); // put in array.
        }
}

natsort($files); // sort the files into name order.

echo "<ul>\n<li><a href='/'>Home</a></li>\n";
foreach($files as $file) {
	$page_name = ucwords(str_replace("-"," ",$file)); # make the link text <> the page url.
        echo("<li><a href='$file'>$page_name</a></li>\n");
}
	
if ($show_edit == 1) {
	
	echo("<li><a href='edit.php'>Admin</a></li>\n");
}
	
echo "</ul>\n";
?>
</xmp>
</div>
</div>
<script src="<?php echo $strapdown_location; ?>"></script>
</body>
</html>