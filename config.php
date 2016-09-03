<?php

### Config file for puppyCMS by James Welch, 2016.
#
### change the variables here to ensure your content is secure.

$site_name = "My Site"; # e.g. Steve's Site

$site_root = "/"; # the folder in which you install puppyCMS. If its at the root of a domain, then simply put '/'. For any other folder, please use trailing slash.

# Change theme
$theme = "puppy"; # default theme is puppy. You can choose from puppy, puppy-black, campfire, teye, sunglasses (more to come).

# email for forms - this is the email your enquiries will go to.
$form_email = "your@email.com";

$show_social = 0; # if set to 1, then show social share buttons in side bar (at the bottom if using hamburger menu).
$show_edit = 0; # if set to 1, then show Admin link in side bar.
$show_form = 0; # if set to 1, then show an enquiry form in side bar.
$better_fonts = 1; # if set to 1, then better-sized fonts will be used depending on the display the site is seen on. makes things more readable. WORTH TRYING :)
$web_stats = 1; # if set to 1, then web visitors will be recorded. You can view stats in yoursite.com/extras/stats

# parallax scrolling?
$parallax = 0; #if set to 1, then you can add code into documents that will create parallax scrolling effects.
# example <p class="parallax-container" data-parallax="scroll" data-bleed="10" data-image-src="path/to/image.jpg" style="min-height:200px;" >Some content here if you like.</p>
# see more at: http://pixelcog.github.io/parallax.js/

$show_slider = 0; # if set to 1, then show content slider on home page.
# if you do want to show a slider on the home page, put content (such as an image url, or a paragraph of text) in each $slide(x) variable. Max 5. Images must all be the same size.
	$slide[0] = "";
	$slide[1] = "";
	$slide[2] = "";
	$slide[3] = "";
	$slide[4] = "";
	$slide[5] = "";


# if you would like to make quicker changes to the css, rather than editing one of the css files you can put it here, which will add a <style> tag to the end of the page
$style_tweaks = '<style></style>';

#####################################################################################
### the stuff below is more geeky stuff, so only play with it if you know what you're doing!

define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');

define('CONTENT_DIR', ROOT_DIR. '/content/'); // change this to change which folder you want your content to be stored in. too many things rely on this, so leave.

# if no title has been added, then use site name.
$default_title = $site_name;

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

# make the title tag human-readable
$title = ucwords(str_replace("-"," ",$url));

############################################## all below is instructions at the top of each page (title, desc etc) ###################################

# grab the first line of the file, to see if it has any instructions in it.
$first_line = fgets(fopen($file, 'r'));

	//if the file has the optional instructions heading line, then do stuff, else show the page as normal
if ( strpos($first_line, '|') !== false)
	
				{
	
//extract the instructions between the pipes
$display = explode('|', $first_line);

//create a title tag if its there
if ($display[1] != "") { $title = $display[1]; }

//create a meta description tag if its there
if ($display[2] != "") { $meta_desc = '<meta name="description" content="'.$display[2].'">'; }

// if 2 columns are requested, then show them
if ($display[3] != "") { $columns = $display[3]; }

	
// get the contents of the file
if(file_exists($file)) $content = file_get_contents($file);

// Show 404 if file cannot be found
else $content = file_get_contents(CONTENT_DIR .'404' . $file_format);

$content = preg_replace("/[|](.*)[\n\r]/","",$content,1);
	
				} else  { //if there were no instructions
	
if(file_exists($file)) $content = file_get_contents($file);

// Show 404 if file cannot be found
else $content = file_get_contents(CONTENT_DIR .'404' . $file_format);
	
}


# this is where I'm hiding :-)
$puppy_link = 1; # if set to 1 then show link to puppy site. 
?>