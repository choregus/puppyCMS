<?php include('config.php'); include('extras/parsedown.php'); include('extras/parsedownextra.php'); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $title ? $title : $default_title; ?></title>
<?php
if (isset($meta_desc)) {echo $meta_desc."\r\n";} // show meta description
# note below that grids-responsive-min.css is included inside the pure-min.css file for speed test reasons
if ($evil_icons == 1) { echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/evil-icons/1.9.0/evil-icons.min.css"><script src="https://cdn.jsdelivr.net/evil-icons/1.9.0/evil-icons.min.js"></script>';}
?>
<link rel="stylesheet" href="style/pure-min.css">
<link rel="stylesheet" href="style/themes/<?php echo $theme ?>.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<?php if ($scroll_anim == 1) { echo '<link href="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.css" rel="stylesheet">';} ?>
<?php
if ($show_slider == 1 && $_SERVER['REQUEST_URI'] == $site_root) { #show if slider selected  ?><link rel="stylesheet" href="<?php echo $site_root; ?>extras/rs/responsiveslides.css">
<script src="<?php echo $site_root; ?>extras/rs/responsiveslides.min.js"></script><?php } # end of slider if section
?>
</head>
<body>
<div class="pure-g" id="layout">
<div class="<?php echo "pure-u-1 pure-u-md-1-1"; ?>"<?php if ($columns == 2) { ?> style="-webkit-column-width: 500px;-moz-column-width: 500px;column-width: 500px;"<?php } elseif ($columns == 3) { ?> style="-webkit-column-width: 300px;-moz-column-width: 300px;column-width: 300px;"<?php }?>>
<?php if ($show_slider == 1 && $_SERVER['REQUEST_URI'] == $site_root) { # show the slideshow if its been set in config  ?>
<ul class="rslides">
<?php
# loop through the slides for the slideshow
foreach ($slide as $value) {
  if ($value <> "") {
		echo "<li>$value</li>\n";
										}
													}
} //end of the show slider loop
?>
</ul>
<?php
#turn the markdown into html
$Parsedown = new ParsedownExtra();
echo $Parsedown->text($content);

?>

<!-- Menu toggle -->
   <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>
<div id="menu">
<div class="pure-menu">
<a class="pure-menu-heading" href="#"><?php echo "Menu"; ?></a>
<?php # if form has been selected then show
if ($show_form == 1) {include('extras/form/form-input.html');} # show enquiry form if selected	?>
<ul class="pure-menu-list">
<?php
echo "<li class=\"pure-menu-item\"><a href='$site_root' class='pure-menu-link'>Home</a></li>\n";
	
######## site or blog mode - the following code block either lists the pages of the site in reverse time order (blog), or lists pages alphabetically (website)
if($blog_mode == 1) {
# the stuff here is listing files in reverse order of time created - effectively a blog
$dir = CONTENT_DIR;
chdir($dir);
array_multisort(array_map('filemtime', ($files = glob("*.txt"))), SORT_DESC, $files);
foreach($files as $file)
{
			if(($file != ".") and ($file != "..") and ($file != "404.txt") and ($file != "index.txt") and ($file != "thankyou.txt") and (strpos($file, 'txt') !== false)) {
				$file = str_replace(".txt","",$file); // take off the extension
		$page_name = ucwords(str_replace("-"," ",$file)); # take out hyphens for the page name.
        echo("<li class=\"pure-menu-item\"><a href='$file' class='pure-menu-link'>".mb_substr($page_name,0,30)."</a></li>\n");
										}
			}
									} # end of blog mode
							else { # show files of site in website mode (alphabetical)
		
		
		#show the list of files in the content directory
$files = array();
$dir = opendir(CONTENT_DIR);
while(false != ($file = readdir($dir))) {
			if(($file != ".") and ($file != "..") and ($file != "404.txt") and ($file != "index.txt") and ($file != "thankyou.txt") and (strpos($file, 'txt') !== false)) {
						$files[] = str_replace(".txt","",$file); // put in array.

        }
}
natsort($files); // sort the files into name order.
	
foreach($files as $file) {
	$page_name = ucwords(str_replace("-"," ",$file)); # take out hyphens for the page name.
	        echo("<li class=\"pure-menu-item\"><a href='$file' class='pure-menu-link'>".mb_substr($page_name,0,30)."</a></li>\n");
													}
		}
	
if ($show_edit == 1) {
	
	echo("<li class=\"pure-menu-item\"><a href='".$site_root."editor/' class='pure-menu-link'>Admin</a></li>\n");
}

 	if ($puppy_link == 1) {
	
	echo("<li class=\"pure-menu-item\"><a href='http://puppycms.com' class='pure-menu-link'>Built with puppyCMS</a></li>\n");
}
echo "</ul></div></div>\n";

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
</div>

</div>
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
<script src="style/ui.js"></script>
<script>
$(document).ready(function() {
<?php if ($better_fonts == 1) { # this uses /extras/text.js to produce fonts that fit the page much better. recommended to turn it on in config.php ?>
$('.pure-g').flowtype({minimum   : 299, maximum   : 1500, minFont   : 16, maxFont   : 20, fontRatio : 30 });
$('ul').flowtype({minFont   : 16,maxFont   : 18, fontRatio : 30});
<?php } ?>

AOS.init();

});
</script><?php # the line below is required for the menu system, parallax and better fonts - all other js code should be loaded into this file. ?>
<?php
# include custom styles if they have been used
	if ($style_tweaks <> "") { echo $style_tweaks;	} ?>
<?php
# record web stats if it has been selected in config file.
	if ($web_stats = 1) { include('extras/stats/stl.php'); } ?>
<!-- built with puppyCMS version 4.0 -->
</body>
</html>
