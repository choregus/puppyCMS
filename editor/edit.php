<?php
$path="../content/".$_GET['name'];

# this bit added by JW to stop people editing anything other than txt files - to be ultra safe.
$extension = substr(strrchr($_GET['name'],'.'),1);
			if($extension != "txt"){
				echo '
<script>

window.location="index.php";

</script>
';	
			}

if(isset($_POST['save']))
{

$fileEdit = fopen($path, "w") or die("Unable to open file!");
$txt = $_POST['fileEdit'];
fwrite($fileEdit, $txt);
fclose($fileEdit);


if($_POST['exit'] != 0)
{

echo '
<script>

window.location="index.php";

</script>
';	
	
}

}

$fileN = file_get_contents($path);
?>
<html>
<head>

<link rel="stylesheet" type="text/css" href="style.css">
	<!-- markItUp! skin -->
<link rel="stylesheet" type="text/css" href="markitup/skins/markitup/style.css">
	<!--  markItUp! toolbar skin -->
<link rel="stylesheet" type="text/css" href="markitup/sets/default/style.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>

<div class="menu-line"> 
<ul class="main_ul" >
	<li class="main_list" onClick="active('sub1')">
    	File
        <ul id="sub1" class="sub_list">

        	<li class="file-menu-list"  id="save">
            	Save
            </li>
            
            <li class="file-menu-list"  id="saveexit">
            	Save &amp; Exit
            </li>
            
            <li  class="file-menu-list" id="exit">
            	Exit
            </li>

        </ul>
    </li>
</ul> 
</div>
<style>
.overlay{
		width:100%;
		height:100%;
		position:fixed;
		left:0px;
		top:0px;
		background-color:rgba(153,153,153,0.3);
	display:none;
	}
	.overlay_active{
		display:inline-block;
	}
</style>


<div class="overlay" id="overlay">

</div>



<br>
<br>
<div style="z-index:10; width:auto; height:70%; position:relative;max-width:900px">
<form action="#" method="post" enctype="multipart/form-data" id="codeEit">


<textarea id="area" name="fileEdit">
<?php echo $fileN; ?>
</textarea>
CTRL+S = Save | CTRL+Q = Save and Exit

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
    

            
 </body>
 </html>