<?php

### Config file for puppyCMS by James Welch, 2016.
#
### change the variables here to ensure your content is secure.

$site_name = "your site"; # e.g. Steve's Site
$editor_file = "editor.php"; # name of your editor file - REMEMBER to change the actual file name in the 'content' folder

# Needed to add/edit/delete pages
$username = "admin";
$password = "password"; # PLEASE change this!

# Change theme
$theme = "journal"; # choose from spruce, simplex, amelia, cerulean, cyborg, journal, readable, slate, spacelab, superhero and united. See what they look like at strapdownjs.com

$show_edit = 0; # if set to 1, then show Admin link in side bar.

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