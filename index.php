<?php
	include('config.php');
	include('extras/parsedown.php'); #convert markdown to pure HTML
	include('extras/parsedownextra.php'); #extra functions for parsedown
	include('extras/puppystats.php'); #PuppyStats
	require 'extras/pass.php'; #
	$pass = new pass('content/style.txt');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $title ? $title : $default_title; ?></title>
	<?php
		// show meta description
		if (isset($meta_desc)) {
			echo $meta_desc."\r\n";
		}

		if ($evil_icons == 1) {
			echo 	'<link rel="stylesheet" href="https://cdn.jsdelivr.net/evil-icons/1.9.0/evil-icons.min.css">'.
					'<script src="https://cdn.jsdelivr.net/evil-icons/1.9.0/evil-icons.min.js"></script>';
		}
	?>
	<link rel="stylesheet" href="https://unpkg.com/purecss@0.6.1/build/pure-min.css">
	<link rel="stylesheet" href="https://unpkg.com/purecss@0.6.1/build/grids-responsive-min.css">
	<link rel="stylesheet" href="<?=$pass->name;?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<?php
		if($scroll_anim == 1) {
			echo 	'<link href="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.css" rel="stylesheet">';
		}

		// show if slider selected
		if ($show_slider == 1 && $_SERVER['REQUEST_URI'] == $site_root) {
			echo 	'<link rel="stylesheet" href="'. $site_root . 'extras/rs/responsiveslides.css">' .
					'<script src="'. $site_root . 'extras/rs/responsiveslides.min.js"></script>';
		}
		// end of slider if section
	?>
</head>
<body class="<?php echo $menu; ?>">
	<div class="pure-g" id="layout">
		<?php
			if ($columns == 2) {
				$col_style = "-webkit-column-width: 500px;-moz-column-width: 500px;column-width: 500px;";
			} elseif ($columns == 3) {
				$col_style = "-webkit-column-width: 300px;-moz-column-width: 300px;column-width: 300px;";
			} else {
				$col_style = "";
			}
		?>
		<div class="<?php echo "pure-u-1 pure-u-md-1-1"; ?>" style="<?php echo $col_style; ?>" >
			<?php
				# show the slideshow if its been set in config
				if ($show_slider == 1 && $_SERVER['REQUEST_URI'] == $site_root) {
					echo '<ul class="rslides">';
					# loop through the slides for the slideshow
					foreach ($slide as $value) {
					  	if ($value <> "") {
							echo "<li>$value</li>\n";
						}
					}
					//end of the show slider loop
					echo '</ul>';
				}

				#turn the markdown into html
				#$Parsedown = new Parsedown(); #revert to this if you have issues with blank screen
				$Parsedown = new ParsedownExtra();
				echo $Parsedown->text($content);

			?>

			<!-- Menu toggle -->
		   	<a href="#menu" id="menuLink" class="menu-link">
		        <span></span>  <!-- Hamburger icon -->
		    </a>

			<div id="menu">
				<div class="pure-menu">
					<a class="pure-menu-heading" href="#"><?php echo $site_brand; ?></a>
					<ul class="pure-menu-list">
						<li class="pure-menu-item">
							<a href="<?php echo $site_root; ?>" class='pure-menu-link'>Home</a>
						</li>
						<?php
							######## site or blog mode - the following code block either lists the pages of the site in reverse time order (blog), or lists pages alphabetically (website)
							if($blog_mode == 1) {
								# the stuff here is listing files in reverse order of time created - effectively a blog
								$dir = CONTENT_DIR;
								chdir($dir);
								array_multisort(array_map('filemtime', ($files = glob("*.txt"))), SORT_DESC, $files);

								foreach($files as $file) {
									if(($file != ".") and ($file != "..") and ($file != "404.txt") and ($file != "style.txt") and ($file != "index.txt") and ($file != "thankyou.txt") and (strpos($file, 'txt') !== false)) {
										$file = str_replace(".txt","",$file); // take off the extension
										$page_name = ucwords(str_replace("-"," ",$file)); # take out hyphens for the page name.
			    						echo '<li class="pure-menu-item"><a href="'.$file.'" class="pure-menu-link">'.mb_substr($page_name,0,30).'</a></li>';
									}
								}
							}
							# end of blog mode

							else {
								# show files of site in website mode (alphabetical)
								#show the list of files in the content directory
								$files = array();
								$dir = opendir(CONTENT_DIR);
								while(false != ($file = readdir($dir))) {
									if(($file != ".") and ($file != "..") and ($file != "404.txt") and ($file != "style.txt") and ($file != "index.txt") and ($file != "thankyou.txt") and (strpos($file, 'txt') !== false)) {
										$files[] = str_replace(".txt","",$file); // put in array.
			    					}
								}
								natsort($files); // sort the files into name order.

								foreach($files as $file) {
									$page_name = ucwords(str_replace("-"," ",$file)); # take out hyphens for the page name.
			        				echo '<li class="pure-menu-item"><a href="'.$file.'" class="pure-menu-link">'.mb_substr($page_name,0,30).'</a></li>';
								}
							}

							if ($show_edit == 1) {
								echo '<li class="pure-menu-item"><a href="'.$site_root.'editor/" class="pure-menu-link">Admin</a></li>';
							}

							if ($puppy_link == 1) {
								echo '<li class="pure-menu-item"><a href="http://puppycms.com" class="pure-menu-link">Built with puppyCMS</a></li>';
							}
						?>
					</ul>
				</div>
			</div>
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
				# end of showing social icons
			?>
		</div>
	</div>

	
	<script type="text/javascript">
	<?php
		if ($show_slider == 1 && $_SERVER['REQUEST_URI'] == $site_root) {  #show if slider selected
	?>
  		$(function() {
    		$(".rslides").responsiveSlides({

	    	});
  		});
	<?php
		}
		# end of slider if section

		# javascript for social buttons

		if ($show_social == 1) {
	?>
		(function() {
    		var dr = document.createElement('script');
    		dr.type = 'text/javascript'; dr.async = true;
    		dr.src = '//share.donreach.com/buttons.js';

    		(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dr);
  		})();

	<?php } # end of showing social icons ?>

	</script>
	<script src="extras/ui.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		<?php
			if($menu == 'top-menu') { ?>
				$nav_height = $('#menu').outerHeight();
				$('body').css('padding-top', $nav_height);

				$(window).resize(function(){
					$nav_height = $('#menu').outerHeight();
					$('body').css('padding-top', $nav_height);
				});
		<?php
			}

			if ($better_fonts == 1) {
		?>
				$('.pure-g').flowtype({
					minimum   : 299,
					maximum   : 1500,
					minFont   : 16,
					maxFont   : 20,
					fontRatio : 30
				});
				$('ul').flowtype({
					minFont   : 16,
					maxFont   : 18,
					fontRatio : 30
				});
		<?php
			}
		?>
			AOS.init();
		});
	</script>
	<!-- built with puppyCMS version <?php echo $puppy_version; ?> -->
	
</body>
</html>