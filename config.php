<?php

### Config file for puppyCMS by James Welch, 2016.
#
### change the variables here to ensure your content is secure.

$site_name = "My site"; # e.g. Steve's Site

# Change theme
$theme = "united"; # choose from spruce, simplex, amelia, cerulean, cyborg, journal, readable, slate, spacelab, superhero and united. See what they look like at strapdownjs.com

# email for forms - this is the email your enquiries will go to.
$form_email = "your@email.com";

$show_social = 0; # if set to 1, then show social share buttons in side bar.
$show_edit = 1; # if set to 1, then show Admin link in side bar.
$show_form = 0; # if set to 1, then show an enquiry form in side bar.
$show_slider = 0; # if set to 1, then show content slider on home page.

	# if you do want to show a slider on the home page, put content (such as an image url, or a paragraph of text) in each $slide(x) variable. Max 5. Images must all be the same size.
	$slide[0] = "";
	$slide[1] = "";
	$slide[2] = "";
	$slide[3] = "";
	$slide[4] = "";


#####################################################################################
### the stuff below is more geeky stuff, so only play with it if you know what you're doing!

$strapdown_location = "/strapdown/strapdown.js";
# alternative is: "http://strapdownjs.com/v/0.2/strapdown.js"

define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');
//define('CONTENT_DIR', ROOT_DIR .$content_folder); // change this to change which folder you want your content to be stored in
define('CONTENT_DIR', ROOT_DIR. '/content/'); // change this to change which folder you want your content to be stored in

$default_title = $site_name;
$bootswatch_theme = $theme; // choose any bootstrap theme included in strapdown.js!

$file_format = ".txt"; // do not change this whatsoever

// Get request url and script url
$url = '';
$request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
$script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';
	
// Get our url path and trim the / of the left and the right
if($request_url != $script_url) $url = trim(preg_replace('/'. str_replace('/', '\/', str_replace('index.php', '', $script_url)) .'/', '', $request_url, 1), '/');

// Get the file path
if($url) $file = strtolower(CONTENT_DIR . $url);
else $file = CONTENT_DIR .'index';

// Load the file
if(is_dir($file)) $file = CONTENT_DIR . $url .'/index' . $file_format;
else $file .=  $file_format;

// Show 404 if file cannot be found
if(file_exists($file)) $content = file_get_contents($file);
else $content = file_get_contents(CONTENT_DIR .'404' . $file_format);

# make the title tag human-readable
$title = ucwords(str_replace("-"," ",$url));

?>