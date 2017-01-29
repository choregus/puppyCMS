<?php
$path="../content/".$_GET['name'];
include("../config.php");

# this bit added by JW to stop people editing anything other than txt files - to be ultra safe.
$extension = substr(strrchr($_GET['name'],'.'),1);
if($extension != "txt"){
	header("location:index.php");
}

if(isset($_POST['save'])){

	$fileEdit = fopen($path, "w") or die("Unable to open file!");
	$txt = $_POST['fileEdit'];
	
	#################################################################

# replace the first instance of a link text name with a link to a url (as selected in config).
	
		#don't do this for certain pages
	# grab the first 200 characters of this file to see what the title contains.
$in_title = substr($txt, 0, 200); #read the first 200 characters of the file (the title and desc. usually)
# dont replace links in pages in this statement below (requires clever people)
	if 	(strpos($in_title, "404") !== false || strpos($in_title, "404") !== false)
	     {} else {
	
	
foreach($link_text as $text=>$link)
			{
				$in_title = substr($txt, 0, 200); #read the first 200 characters of the file (the title and desc. usually)

				if 	(strpos($in_title, $text) !== false) { # only link to words that are NOT in the title tag. e.g. a page with the title of 'Red Strawberries' will not link the word strawberries, but will mangos.
																						} else {
		if (strpos($txt, '['.$text.']') == false) { $txt = str_replace_first(''.$text.'', '['.$text.']('.$link.')', $txt); }
																						
																										}
					
			
			};

};

// YouTube short code replacement code

$txt = preg_replace('/{{(.*?)}}/', '<div class="yt-video"><iframe src="https://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe></div>', $txt);
$txt = preg_replace('/{{<iframe/', '<iframe', $txt);



#################################################################
	
	fwrite($fileEdit, $txt);
	fclose($fileEdit);

	if($_POST['exit'] != 0) {
		header("location:index.php");
	}

} else {
  
  //backup testing
copy ($path,"../content/bak/".date('Y-m-d-His')."-".$_GET['name']);
  
}

$fileN = file_get_contents($path);
?>

<html>
<head>
	<title>Editor</title>
	<link rel="stylesheet" href="https://unpkg.com/purecss@0.6.1/build/pure-min.css">
	<link rel="stylesheet" type="text/css" href="assets/alertify.css">
	<link rel="stylesheet" type="text/css" href="assets/style.css">
	<!-- markItUp! skin -->
	<link rel="stylesheet" type="text/css" href="markitup/skins/markitup/style.css">
	<!--  markItUp! toolbar skin -->
	<link rel="stylesheet" type="text/css" href="markitup/sets/default/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>

<div class="overlay" id="overlay"></div>

<h1 class="page-title">Editor</h1>

<div class="container button-list">
	<button class="pure-button button-success" title="Save edit" id="save"><i class="fa fa-save"></i> Save</button>
	<button class="pure-button pure-button-primary" title="Back to file list" id="exit"><i class="fa fa-arrow-left"></i> Back</button>
</div>

<div class="container editor-container">
	<form action="#" method="post" enctype="multipart/form-data" id="codeEit" class="pure-form editor-form">
		<label>Contents</label>
		<textarea id="area" name="fileEdit"><?php echo $fileN; ?></textarea>
		<div class="note">
			CTRL+S = Save | CTRL+Q = Save and Back
		</div>

		<input type="hidden" id="makeExit" name="exit" value="0" />
		<input type="hidden" name="save" value="save" />
	</form>
</div>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
	<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
	
	<script>
	new SimpleMDE({
		element: document.getElementById("area"),
		spellChecker: true,
		
	});


	$(document).ready(function(e) {
    $('#save').click(function(e) {
        $('#codeEit').trigger('submit');
    });
	
	$('#saveexit').click(function(e) {
		
		
		
		$('#makeExit').val("1");
		
        $('#codeEit').trigger('submit');
    });
	

	
});
	
	$(document).bind('keydown', function(e) {
  if(e.ctrlKey && (e.which == 83)) {
    e.preventDefault();
    $('#codeEit').trigger('submit');
    return false;
  }
});
		
	$(document).bind('keydown', function(e) {
  if(e.ctrlKey && (e.which == 81)) {
    e.preventDefault();
$('#makeExit').val("1");
		
        $('#codeEit').trigger('submit');    return false;
  }
});
	
	function active(sublist)
	{
		$('#overlay').addClass("overlay_active");
		var listId = '#'+sublist;
		$(listId).addClass("sub_list_active");
	}
	
	$(document).ready(function(e) {
        $('#overlay').click(function(e) {
            $(this).removeClass("overlay_active");
			$('.sub_list').removeClass("sub_list_active");
			$('#formCont').hide();
        });
		$('#cancel').click(function(e) {
            $('#overlay').removeClass("overlay_active");
			$('.sub_list').removeClass("sub_list_active");
        });
    });
	
	$("#exit").click(function(){
		window.location="index.php";
		});
	
	</script>
 
 <?php

?>

            
 </body>
 </html>