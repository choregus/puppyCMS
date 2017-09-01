<?php
	$page_title = "Menu";
	$sidebar_page = "menu.php";
	session_start();
	if (!isset($_SESSION['puppycms-admin'])) {
		header("Location: login.php");
	}

	$menu_file = '../ini/menu.ini';
	$menu = file_get_contents($menu_file);
	$menu = json_decode($menu);

	if (isset($_POST["menu-submit"])) {
		$new_menu = $_POST['created-menu-array'];
		
		$file = fopen($menu_file, "w") or die("Unable to open file!");
		fwrite($file, $new_menu);
		fclose($file);

		$menu_file = '../ini/menu.ini';
		$menu = file_get_contents($menu_file);
		$menu = json_decode($menu);
	}

	$content_dir = '../content/';

	include "header.php";

	function name_beautify($name){
		$file = str_replace(".txt","",$name);
	    return ucwords(str_replace("-"," ",$file));
	}

	function filesToSelect($dir){
	    $files_to_select = scandir($dir);

	    unset($files_to_select[array_search('.', $files_to_select, true)]);
	    unset($files_to_select[array_search('..', $files_to_select, true)]);

	    // prevent empty ordered elements
	    if (count($files_to_select) < 1){
	        return;
	    }
	    foreach($files_to_select as $file_to_select){
	    	$escape = ['index.txt', 'style.txt', 'style.css', '404.txt', 'styling-puppy.txt', 'thankyou.txt'];
	    	if ( !in_array($file_to_select, $escape, true ) ){
	    		$check = substr(strrchr($file_to_select, "."), 1);
		    	$file_url = str_replace(".txt","",$file_to_select);
		    	$name = ucwords(str_replace("-"," ",$file_url));
		    	$file_url = $dir.'/'.$file_url;
		    	$file_url = str_replace("../content//","",$file_url);

		    	if (is_file($dir.'/'.$file_to_select)) {
		    		if (($check == "" || $check == 'txt') && $file_to_select != 'bak') {
			    		echo '<div class="map-checkbox"><label><input type="checkbox" data-menu_url="'.$file_url.'" value="'.$file_to_select.'"><span>'. $name . '</span></label></div>';
			    	}
		    	} else if (is_dir($dir.'/'.$file_to_select)){
		    		if (($check == "" || $check == 'txt') && $file_to_select != 'bak') {
		    			filesToSelect($dir.'/'.$file_to_select);
		    		}
		    	}
	    	}
	    }
	}

	function createdMenu(array $array){
		$html = '';
		foreach($array as $value){
			$html .= '<li class="dd-item" data-menu_file="'.$value->menu_file.'" data-menu_url="'.$value->menu_url.'" data-menu_title="'.$value->menu_title.'"><div class="dd-handle">'. $value->menu_title . '<span class="fa fa-close menu_item_remove"></span></div>';
			if(array_key_exists("children",$value)){
				$html .= '<ol class="dd-list">';
					$html .= createdMenu($value->children);
				$html .= '</ol>';
			}
			$html .= '</li>';
		}
		return $html;
	}

	function listFolderFiles($dir){
	    $files_to_select = scandir($dir);

	    unset($files_to_select[array_search('.', $files_to_select, true)]);
	    unset($files_to_select[array_search('..', $files_to_select, true)]);

	    // prevent empty ordered elements
	    if (count($files_to_select) < 1){
	        return;
	    }
	    foreach($files_to_select as $ff){
	    	$escape = ['index.txt'];
	    	$check = substr(strrchr($ff, "."), 1);
	    	$name = str_replace(".txt","",$ff);
	    	$name = ucwords(str_replace("-"," ",$name));

	    	$type = "";

	    	if (is_file($dir.'/'.$ff)) {
	    		$type = 'file';
	    	} else if (is_dir($dir.'/'.$ff)){
	    		$type = 'folder';
	    	}

	    	if (($check == "" || $check == 'txt') && $ff != 'bak') {
	    		echo '<li class="dd-item dd3-item" data-item-type="'.$type.'" data-item-name="'.$ff.'"><div class="dd-handle dd3-handle">'. $name . ' <i class="fa fa-eye pull-right"></i></div>';
		        if(is_dir($dir.'/'.$ff)) {
	    			echo '<ol class="dd-list">';
		        		listFolderFiles($dir.'/'.$ff);
	    			echo '</ol>';
		        }
		        echo '</li>';
	    	}
	    }
	}

?>
	<?php include "navbar.php"; ?>
	<?php include "sidebar.php"; ?>

	<div class="main">
		<div class="main-content">
			<div class="container-fluid">

				<div class="panel panel-headline">
					<div class="panel-heading">
						<h3 class="panel-title">Create Menu</h3>
						<p class="subtitle">Add/Remove/Edit files and folders.</p>
					</div>
					<div class="panel-body">
						<form class="row" method="post" action="" id="menu-form">
							<textarea name="created-menu-array" id="created-menu-array" class="created-menu-array"></textarea>
							<div class="col-sm-4">
								<h3 class="text-center">Add Page/URL</h3>
								<hr/>
								<div class="panel panel-primary">
								  	<div class="panel-heading">Pages</div>
								  	<div class="panel-body">
								    	<div class="menu-available-pages" id="menu-available-pages">
											<?php 
												filesToSelect($content_dir); 
											?>
										</div>

										<div class="text-right">
											<button class="btn btn-default" id="menu-select-all">Select All</button>
											<button class="btn btn-primary" id="menu-add-pages">Add Page(s)</button>
										</div>
								  	</div>
								</div>

								<div class="panel panel-primary">
								  	<div class="panel-heading">Custom Link</div>
								  	<div class="panel-body">
								  		<div class="form-group">
								  			<label>URL</label>
											<input type="text" class="form-control" id="mal-url" name="">
								  		</div>

								  		<div class="form-group">
								  			<label>Link Text</label>
											<input type="text" class="form-control" id="mal-text" name="">
								  		</div>
										
										<div class="text-right">
											<button class="btn btn-primary pull-right" id="menu-add-link">Add Link</button>
										</div>
								  	</div>
								</div>
							</div>

							<div class="col-sm-8">
								<h3 class="text-center">Menu Structure</h3>
								<hr/>
								<div class="dd menu-selected-items" id="menu-selected-items">
									<ol class="dd-list menu-selected-items-list"><?php echo createdMenu($menu); ?></ol>
								</div>
							</div>

							<div class="form-group text-right">
								<div class="col-sm-12">
									<input type="submit" id="menu-submit" name="menu-submit" class="btn btn-success" value="Submit"/>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	include "footer.php";
?>