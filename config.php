<?php
$settings_file = 'ini/settings.ini';
$settings = file_get_contents($settings_file);
$settings = json_decode($settings);

$menu_file = 'ini/menu.ini';
$navigation = file_get_contents($menu_file);
$navigation = json_decode($navigation);


### Config file for puppyCMS by James Welch, 2017.

### Change the variables below to personalise your site

$site_name = $settings->site_name; # e.g. Steve's Site
$site_root = $settings->site_root; # the folder in which you install puppyCMS. If its at the root of a domain, then simply put '/'. For any other folder, please use trailing slash.

// Get site's url
$site_url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . '/' . $site_root; // Takes URL but add 'localhost' as subpage

$site_template = 'themes/' . $settings->site_template; #option of puppy.tpl or bootstrap.tpl - in future versions, it can be changed per page

# email for forms - this is the email your enquiries will go to.
$form_email = $settings->from_email;

$link_text = [
	'PuppyCMS' => 'http://puppycms.com',
];


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
if($url) {
	$file = strtolower(CONTENT_DIR . $url);
} else {
	$file = CONTENT_DIR .'index';
}

// Load the file
if(is_dir($file)) {
	$file = CONTENT_DIR . $url .'/index' . $file_format;
} else {
	$file .=  $file_format;
}

# make the title tag human-readable
$title = ucwords(str_replace("-"," ",$url));

############################################## all below is instructions at the top of each page (title, desc etc) ###################################

# grab the first line of the file, to see if it has any instructions in it.

$first_line = "";
if(file_exists($file)) {
	$first_line = fgets(fopen($file, 'r'));
}

$meta_desc = NULL; #register the variable

//if the file has the optional instructions heading line, then do stuff, else show the page as normal
if ( strpos($first_line, '|') !== false) {
	
	//extract the instructions between the pipes
	$display = explode('|', $first_line);

	//create a title tag if its there
	if ($display[1] != "") {
		$title = $display[1];
	}

	//create a meta description tag if its there
	if ($display[2] != "") {
		$meta_desc = '<meta name="description" content="'.$display[2].'">';
		
	} else {$meta_desc = " ";}


	// get the contents of the file
	if(file_exists($file)) {
		$content = file_get_contents($file);
	    $content = preg_replace("/[|](.*)[\n\r]/","",$content,1);
	}else {
		// Show 404 if file cannot be found
		$content = file_get_contents(CONTENT_DIR .'404' . $file_format);
		$content = preg_replace("/[|](.*)[\n\r]/","",$content,1);
	}
	
} else  {
	//if there were no instructions
	
	if(file_exists($file))  {
		$content = file_get_contents($file);
	} else {
		// Show 404 if file cannot be found
		$content = file_get_contents(CONTENT_DIR .'404' . $file_format);
	}
	
}

# function to change text to links
	
function str_replace_first($from, $to, $subject) {
	$from = '/'.preg_quote($from, '/').'/';
	return preg_replace($from, $to, $subject, 1);
}

# this is where I'm hiding :-)
$puppy_link = $settings->puppy_link; # if set to 1 then show link to puppy site.
$puppy_version = $settings->puppy_version;


// Function to generate Navigation UL
$get_navigation = function($ul="", $nested_ul="", $li="", $a="", $caret="", $fullurl = true) use ($navigation, $site_url){
	function create_class($class){
		if ($class != "") {
			return 'class="'.$class.'"';
		}
	}
	
	$p_nav = '<ul '. create_class($ul) .'>';
	function createdMenu($nav, $n_ul, $n_li, $n_a, $n_caret, $fullurl, $site_url){
	    $html = '';
	    foreach($nav as $value){
	    	$url = $value->menu_url;
	    	if ($fullurl == true) {
	    		$url = rtrim( $site_url, "/" ) . '/' . trim( $url, "/" );
	    	}
	      	$html .= '<li '.create_class($n_li).'><a '.create_class($n_a).' href="'.$url.'">'.$value->menu_title;
	      	if(array_key_exists("children",$value)){
	      		$html .= $n_caret;
	        	$html .= '</a><ul '.create_class($n_ul).'>';
	          		$html .= createdMenu($value->children, $n_ul, $n_li, $n_a, $n_caret, $fullurl, $site_url);
	        	$html .= '</ul>';
	      	}
	      	$html .= '</a></li>';
	    }
	    return $html;
	}
	$p_nav .= createdMenu($navigation, $nested_ul, $li, $a, $caret, $fullurl, $site_url);
	$p_nav .= '</ul>';

	return $p_nav;
}

// Function to generate menu by providing $navigation array [BACKUP FUNCTION]
// function createdMenu(array $array){
//     $html = '';
//     foreach($array as $value){
//       	$html .= '<li><a href="'.$value->menu_url.'">'.$value->menu_title.'</a>';
//       	if(array_key_exists("children",$value)){
//         	$html .= '<ul class="navbar-nav-sub">';
//           		$html .= createdMenu($value->children);
//         	$html .= '</ul>';
//       	}
//       	$html .= '</li>';
//     }
//     return $html;
// }
// echo '<ul>';
// echo createdMenu($navigation);
// echo '</ul>';
?>