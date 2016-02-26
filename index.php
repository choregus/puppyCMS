<?php include('config.php'); ?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $title ? $title : $default_title; ?></title>
<?php 
if (isset($meta_desc)) {echo $meta_desc;} // show meta description
if ($show_slider == 1 && $_SERVER['REQUEST_URI'] == $site_root) { #show if slider selected  ?><link rel="stylesheet" href="<?php echo $site_root; ?>extras/rs/responsiveslides.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="<?php echo $site_root; ?>extras/rs/responsiveslides.min.js"></script><?php } # end of slider if section ?>
</head>
<body>
<xmp theme="<?php echo $bootswatch_theme; ?>" style="display:none;">
<?php if ($show_slider == 1 && $_SERVER['REQUEST_URI'] == $site_root) { # show the slideshow if its been set in config  ?>
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
<div class="span9"<?php if (isset($columns)) { ?> style="-webkit-column-width: 300px;-moz-column-width: 300px;column-width: 300px;"<?php } ?>>

<?php echo $content; ?>

</div>
<div class="span3">
<?php
# show social buttons if set in config
if ($show_social == 1) {
?>
<div class="don-share" data-style="icons" data-bubbles="none" data-limit="3">
  <div class="don-share-facebook"></div>
  <div class="don-share-twitter"></div>
  <div class="don-share-google"></div>
  <div class="don-share-linkedin"></div>
</div>
<?php
}
# if form has been selected then show	
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

echo "<ul>\n<li><a href='".$site_root."'>Home</a></li>\n";
foreach($files as $file) {
	$page_name = ucwords(str_replace("-"," ",$file)); # take out hyphens for the page name.
        echo("<li><a href='$file'>$page_name</a></li>\n");

}
	
if ($show_edit == 1) {
	
	echo("<li><a href='".$site_root."content/'>Admin</a></li>\n");
}
	
echo "</ul>\n";
?>
</xmp>
</div>
</div>
<script src="<?php echo $strapdown_location; ?>"></script>
	<?php if ($show_slider == 1 && $_SERVER['REQUEST_URI'] == $site_root) {  #show if slider selected ?><script>
  $(function() {
    $(".rslides").responsiveSlides({
			
		
			
		});
  });
</script><?php } # end of slider if section 

# javascript for social buttons
if ($show_social == 1) {	
	?>
<script type="text/javascript"> 
  (function() {
    var dr = document.createElement('script');
    dr.type = 'text/javascript'; dr.async = true;
    dr.src = '//share.donreach.com/buttons.js';
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dr);
  })();
</script><?php } # end of showing social icons ?>
</body>
</html>