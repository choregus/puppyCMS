<?php include('config.php');?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $title ? $title : $default_title; ?></title>
<?php if ($show_slider == 1 && $_SERVER['REQUEST_URI'] == "/") { #show if slider selected  ?><link rel="stylesheet" href="/extras/rs/responsiveslides.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="/extras/rs/responsiveslides.min.js"></script><?php } # end of slider if section ?>
</head>
<body>
<xmp theme="<?php echo $bootswatch_theme; ?>" style="display:none;">
<?php if ($show_slider == 1 && $_SERVER['REQUEST_URI'] == "/") { # show the slideshow if its been set in config  ?>
<ul class="rslides">
<?php
# loop through the slides for the slideshow
foreach ($slide as $value) {
  if ($value <> "") {
		echo "<li>$value</li>";
										}
													}
?>
</ul>
<?php } ?>

<div class="row">
<div class="span9">
<?php echo $content; ?>
</div>
<div class="span3">
<?php
#show a contact form #beta
#include('extras/form/form-input.html');
	
if ($show_form == 1) {include('extras/form/form-input.html');} # show enquiry form if selected
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
	
	echo("<li><a href='/content'>Admin</a></li>\n");
}
	
echo "</ul>\n";
?>
</xmp>
</div>
</div>
<script src="<?php echo $strapdown_location; ?>"></script>
	<?php if ($show_slider == 1 && $_SERVER['REQUEST_URI'] == "/") {  #show if slider selected ?><script>
  $(function() {
    $(".rslides").responsiveSlides({
			
		
			
		});
  });
</script><?php } # end of slider if section ?>
</body>
</html>