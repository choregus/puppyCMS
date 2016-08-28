<?php include('config.php'); $columns =""; ?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $title ? $title : $default_title; ?></title>
<?php
if (isset($meta_desc)) {echo $meta_desc."\r\n";} // show meta description ?>
<script src="//cdn.jsdelivr.net/jquery/2.2.0/jquery.min.js"></script>
<?php
if ($show_slider == 1 && $_SERVER['REQUEST_URI'] == $site_root) { #show if slider selected  ?><link rel="stylesheet" href="<?php echo $site_root; ?>extras/rs/responsiveslides.css">
<script src="<?php echo $site_root; ?>extras/rs/responsiveslides.min.js"></script><?php } # end of slider if section ?>
<?php if ($menu_choice == 1) { ?><link rel="stylesheet" href="//cdn.jsdelivr.net/jquery.sidr/2.2.1/stylesheets/jquery.sidr.light.min.css"><?php } # end menu choice ?>

<meta name="viewport" content="width=device-width,minimum-scale=1">
<?php if ($better_fonts == 1) { ?><script src="extras/text.js"></script><?php } ?>

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

<?php }
//show old or new style menus
$span = ( $menu_choice == 1) ? 'span12' : 'span9';
?>
<?php if ($menu_choice == 1) { ?><a id="simple-menu" href="#sidr" style="font-size:2em;margin:10px;float:right;">&#9776;</a><?php } # end menu choice ?>

<div class="row">
<div class="<?php echo $span; ?>"<?php if ($columns == 2) { ?> style="-webkit-column-width: 500px;-moz-column-width: 500px;column-width: 500px;"<?php } elseif ($columns == 3) { ?> style="-webkit-column-width: 300px;-moz-column-width: 300px;column-width: 300px;"<?php }?>>
<?php echo $content;

if ($menu_choice == 0) {
?>
</div>
<div class="span3">
<?php
} # end menu choice

# show social buttons if set in config
if ($show_social == 1) {
?>

<div class="don-share" data-style="icons" data-bubbles="none" data-limit="3">
  <div class="don-share-facebook"></div>
  <div class="don-share-twitter"></div>
  <div class="don-share-google"></div>
  <div class="don-share-linkedin"></div>
</div>
<?php } # end of showing social icons
?>
<?php if ($menu_choice == 1) { ?>
</div><?php } # end menu choice ?>
<?php if ($menu_choice == 1) { ?><div id="sidr"><?php } # end menu choice ?>
<?php

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
?>
<?php
echo "<ul>\n<li><a href='$site_root'>Home</a></li>\n";
foreach($files as $file) {
	$page_name = ucwords(str_replace("-"," ",$file)); # take out hyphens for the page name.
        echo("<li><a href='$file'>$page_name</a></li>\n");

}
	
if ($show_edit == 1) {
	
	echo("<li><a href='".$site_root."editor/'>Admin</a></li>\n");
}

 	if ($puppy_link == 1) {
	
	echo("<li><a href='http://puppycms.com'>Built with puppyCMS</a></li>\n");
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
<?php if ($menu_choice == 1) { ?><script src="//cdn.jsdelivr.net/jquery.sidr/2.2.1/jquery.sidr.min.js"></script>
<script>
$(document).ready(function() {
  $('#simple-menu').sidr({side: 'right' });
<?php if ($better_fonts == 1) { ?>
	$('.span12').flowtype({minimum   : 299, maximum   : 1500, minFont   : 16, maxFont   : 20, fontRatio : 30 });
	$('ul').flowtype({minFont   : 16,maxFont   : 18, fontRatio : 30});
<?php } ?>
});
</script><?php } # end of menu choice ?>
	
<?php 
# include custom styles if they have been used
	if ($style_tweaks <> "") { echo $style_tweaks;	} ?>
<?php 
# record web stats if it has been selected in config file.	
	if ($web_stats = 1) { include('extras/stats/stl.php'); } ?>
<!-- built with puppyCMS version 2.0 -->
</body>
</html>