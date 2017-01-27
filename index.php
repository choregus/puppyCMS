<?php
#basically this takes all the variables and settings from the config.php file, includes files needed and then manipulates the variables for use in the template (.tpl) file selected. No HTML is done in this file - please do this in a .tpl file.

	include('config.php');
	include('extras/parsedown.php'); #convert markdown to pure HTML
	include('extras/parsedownextra.php'); #extra functions for parsedown
	include('extras/puppystats.php'); #PuppyStats
	require 'extras/pass.php'; #css preprocessor
	$pass = new pass('content/style.txt'); #stylesheet that creates the css
    require_once('extras/template.class.php'); #templating engine

// Select the page template (******* will be done by choosing 3rd item in first line of any page - |x|x|this| )
$tpl = new Template('extras/tpl/'.$site_template);

#general variables to be used in template files
$tpl->assign('site_root', $site_root);
$tpl->assign('site_brand', $site_brand);
$tpl->assign('show_edit', $show_edit);
$tpl->assign('show_social', $show_social);
$tpl->assign('puppy_link', $puppy_link);
$tpl->assign('puppy_version', $puppy_version);

// title and desc
$tpl->assign('title', $title ? $title : $default_title);
$tpl->assign('description', $meta_desc ? $meta_desc.'' : '');

#add purecss.io CDN
$tpl->assign('head_purecss', '
        <link rel="stylesheet" href="https://unpkg.com/purecss@0.6.2/build/pure-min.css">
        <link rel="stylesheet" href="https://unpkg.com/purecss@0.6.2/build/grids-responsive-min.css">
');

#add style sheet
$stylesheet = "<link rel=\"stylesheet\" href=\"".$pass->name."\">
";
$tpl->assign('head_style', $stylesheet);

#add jQuery CDN
$tpl->assign('head_jquery', '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
');

#add evil_icons CDN if it's set in config
if ($evil_icons == 1) {
$tpl->assign('head_evil', '<link rel="stylesheet" href="https://cdn.jsdelivr.net/evil-icons/1.9.0/evil-icons.min.css">
<script src="https://cdn.jsdelivr.net/evil-icons/1.9.0/evil-icons.min.js"></script>
');
                    } else $tpl->assign('head_evil', '');

#add animated scroll css CDN
if ($scroll_anim == 1) {
$tpl->assign('head_scroll_anim', '<link href="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.css" rel="stylesheet">
');
		                } else $tpl->assign('head_scroll_anim', '');

# show responsive slides css and js if it has been selected in config
if ($show_slider == 1 && $_SERVER['REQUEST_URI'] == $site_root) {
$tpl->assign('head_slider', '<link rel="stylesheet" href="'. $site_root . 'extras/rs/responsiveslides.css">
<script src="'. $site_root . 'extras/rs/responsiveslides.min.js"></script>
');
                        } else $tpl->assign('head_slider', '');

#menu type for use in body tag
$menu_type = $menu."";
$tpl->assign('menu_type', $menu_type);

###### show the slider if its been set in config #######
				if ($show_slider == 1 && $_SERVER['REQUEST_URI'] == $site_root) {
# declare the slides var for template engine use
    $slides = array();
					# loop through the slides for the slideshow
	$slides_i = 0;
					foreach ($slide as $value) {
					  	if ($value <> "") {
    $slides[$slides_i] = array('slide' => $value);
    $slides_i++;
						                        }
					}
# assign variables for use in template - show_slides is used for if statement in template
$tpl->assign('slides', $slides);
$tpl->assign('show_slides', 1);
                        } else $tpl->assign('show_slides', NULL);
####### end showing slider #######

#turn the markdown into html
#$Parsedown = new Parsedown(); #revert to this if you have issues with blank screen
$Parsedown = new ParsedownExtra();
$tpl->assign('parsedown', $Parsedown->text($content));

# list pages in the site (and display differently if puppy is in blog mode)
	$dir = CONTENT_DIR;
	chdir($dir);
    array_multisort(array_map('filemtime', ($files = glob("*.txt"))), SORT_DESC, $files); #sort in reverse time order (for blog mode)
    if ($blog_mode == 0) {natsort($files); }  # sort the files into name order if it's not the blog mode.
	
	$pages_i = 0; #use to create array items for use in template
	foreach($files as $file) {
		if(($file != ".") and ($file != "..") and ($file != "404.txt") and ($file != "style.txt") and ($file != "index.txt") and ($file != "thankyou.txt") and (strpos($file, 'txt') !== false)) {
    			$file = str_replace(".txt","",$file); # take off the extension
    			$page_name = ucwords(str_replace("-"," ",$file)); # take out hyphens for the page name and make first letter of each word uppercase.
    
    #put the menu item html into an array for use in template loop
    $menu_pages[$pages_i] = array('menu_pages' => '<a href="'.$file.'" class="pure-menu-link">'.mb_substr($page_name,0,30).'</a>');
    $pages_i++;
		                                        }
                        	}
$tpl->assign('menu_pages', $menu_pages); # create the menu_pages template variable
chdir('../'); #go back a directory to get out of content directory

#code for remaining menu items
$show_edit_text = '<li class="pure-menu-item"><a href="'.$site_root.'editor/" class="pure-menu-link">Admin</a></li>';
$tpl->assign('show_edit_text', $show_edit_text);
$show_puppy_link = '<li class="pure-menu-item"><a href="http://puppycms.com" class="pure-menu-link">Built with puppyCMS</a></li>';
$tpl->assign('show_puppy_link', $show_puppy_link);

$show_social_icons = NULL; #register the variable
$show_social_js_code = NULL; #register the variable
				# show social buttons if set in config
				if ($show_social == 1) {

$show_social_icons = '<div class="don-share" data-style="icons" data-bubbles="none" data-limit="3">
<div class="don-share-facebook"></div>
<div class="don-share-twitter"></div>
<div class="don-share-google"></div>
<div class="don-share-linkedin"></div>
</div>
';
				    
$show_social_js_code = '(function() {
var dr = document.createElement(\'script\');
dr.type = \'text/javascript\'; dr.async = true;
dr.src = \'//share.donreach.com/buttons.js\';

(document.getElementsByTagName(\'head\')[0] || document.getElementsByTagName(\'body\')[0]).appendChild(dr);
})();';
				}
$tpl->assign('show_social_icons', $show_social_icons);#assign it for use in template
$tpl->assign('show_social_js_code', $show_social_js_code);#assign it for use in template

#regarding the top menu option for pure-css menus
    $top_menu_js = " "; # register variable
        if($menu == 'top-menu') {
        	$top_menu_js = '
        	$nav_height = $(\'#menu\').outerHeight();
        	$(\'body\').css(\'padding-top\', $nav_height);
        
        	$(window).resize(function(){
        		$nav_height = $(\'#menu\').outerHeight();
        		$(\'body\').css(\'padding-top\', $nav_height);
        	});';
    			                    }
$tpl->assign('top_menu_js', $top_menu_js);#assign it for use in template

#better fonts
    $better_fonts_js = " "; # register variable
if ($better_fonts == 1) {
		$better_fonts_js = '
				$(\'.pure-g\').flowtype({
					minimum   : 299,
					maximum   : 1500,
					minFont   : 16,
					maxFont   : 20,
					fontRatio : 30
				});
				$(\'ul\').flowtype({
					minFont   : 16,
					maxFont   : 18,
					fontRatio : 30
				});';
			}
$tpl->assign('better_fonts_js', $better_fonts_js);#assign it for use in template
		
			
// Display the page
$tpl->display();
?>