<?php
session_start();
?>
<html>
<head>

<link rel="stylesheet" type="text/css" href="style.css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">

function renameFile(x, name){
	
	var m = prompt("Change "+x+" to a new filename");
	if(m == "" || m == null){
		alert("Enter name.");
		}
		else{
	
	$.post("rename.php", {oldName:name,
						rename: m
	}, function(respond){
        alert(respond);
		window.location="index.php";
    });
	
		}
	
	}
	function deleteFile(name){
	
	
	$.post("delete.php", {oldName:name}, function(respond){
        alert(respond);
		window.location="index.php";
    });
	
	}
	
	function addNew()
	{
		var m = prompt("Enter file name and type");
		if(m == "" || m == null){
			alert("Enter a name");
			}
		else{
		var pathx="../content/"+m;
		
		
		$.post("create.php", {pathx:pathx}, function(respond){
        alert(respond);
		window.location="index.php";
    });
	
		}
		
		
	}
	
	$(document).ready(function(e) {
        $('#uploadbtn').click(function(e) {
            $('#formCont').show();
        });
		$('#cancel').click(function(e) {
            $('#formCont').hide();
        });
    });
	
</script>

</head>
<body>


<?php


if(isset($_POST['login']))
{
	if(file_exists("loadpass.ds"))
	{
	$open = fopen('loadpass.ds', 'r');
		$pass = trim(fgets($open));
		
		if($pass == $_POST['password'])
			{
			
			$_SESSION['session'] = time();
				
			}else{
			
				echo '
											<script>
											
											alert("Invalid Login");
											
											</script>
											
											';
				
			}
	fclose($open);
	}else{
	$open = fopen('loadpass.ds', 'w');
	fwrite($open, $_POST['password']);
	$_SESSION['session'] = time();
	fclose($open);
		
	}
	
}

if(!isset($_SESSION['session']))
{
	
	
	echo '
	<form action="#" method="post">
	<table align="center">
		<tr>
			<td align="center"><input type="password" name="password" size="70" placeholder="Enter password (or create if first time)" /></td>
		</tr>
		<tr>
			<td align="center"><input type="submit" name="login" value="Login" /></td>
		</tr>
	</table>
	</form>
	';
	
	
	exit();
	
}



?>

<?php
if(isset($_POST['upload']))
{


										$uploadFile = $_FILES['uploadFile'];

										if($uploadFile['size'] > 1)

										{
											$exten = explode(".", strrev($uploadFile['name']));
											
											$run = false;
											
											if($exten[0] == "txt")
											{
											
											$run = true;
												
											}else if($exten[0] == "gpj")
											{
											
											$run = true;
												
											}else if($exten[0] == "fig")
											{
											
											$run = true;
												
											}else if($exten[0] == "gnp")
											{
											
											$run = true;
												
											}else if($exten[0] == "fdp")
											{
											
											$run = true;
												
											}

										if($run)
										{
										$path_file = "../content/".$uploadFile['name'];

											move_uploaded_file($uploadFile['tmp_name'], $path_file);
											
											echo '
											<script>
											
											alert("File uploaded successfully");
											
											</script>
											
											';
											
										}else{
										
											echo '
											<script>
											
											alert("Unsupported file format");
											
											</script>
											
											';
											
										}
											
										}
										
}



$dir = "../content/";



// Open a directory, and read its contents
if (is_dir($dir)){
  if ($dh = opendir($dir)){
	  ?>
<div class="menu-line">
<ul class="main_ul" >
	<li class="main_list" onClick="active('sub1')">
    	File
        <ul id="sub1" class="sub_list">

        	<li class="file-menu-list" onClick="addNew()">

            	Add new

            </li>

            <li class="file-menu-list" id="uploadbtn">

            	Upload

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


      <!--<button onClick="addNew()" >Add New</button> &nbsp; <button id="uploadbtn">Upload</button> -->
      <br>
      <br>
      <div id="formCont" style="width:100%;height:auto; display:none;" class="mid_cont">
      	<div style="width:400px; height:100px; position:relative; margin:auto; margin-top:200px; z-index:999999; border-radius:4px; background-color:#fff; padding:20px; padding-top:40px; text-align:center;">
      	<form enctype="multipart/form-data" action="#" method="post">
        	<input type="file" name="uploadFile" />
            <br>
            <br>
            	<input type="submit" name="upload" value="upload" style="float:left; width:100px; height:30px;"> <input type="button" value="Cancel" id="cancel" style="float:right; width:100px; height:30px;"/>
            <br>
            <br>
            
        </form>
        </div>
      </div>
      <table style="width:100%; border:dashed 1px #0099FF; max-width:900px; " cellspacing="0">
      <tr style="background-color:#0099FF; height:30px; font-size:18px; line-height:30px; color:#fff; font-family:'Segoe UI'; text-align:center;">
      
      
        	<td style="min-width:400px;">
            Name
            </td>
            
            <td style="width:40px;">
            Size
            </td>
              
            <td style="width:40px;">
            Rename
            </td>
            <td style="width:40px;">
            	Edit
            
            </td>
            <td style="width:40px;">
            
            	Delete
            
            </td>
            
        </tr>
      <?php
	  
	  $storage = scandir($dir);
	  
	  //print_r();
	  
    //while (($file = readdir($dh)) !== false){
		foreach($storage as $file)
		{
		$file2 = explode('.',$file);
		
			
		if((isset($file2[1])) && ($file2[1]!="") && ($file2[1]!="php") && ($file2[1]!="js"))
		{
			$type=true;
		}
		else
		{
			$type=false;
		}
		if($type)
		{?>
        
        <tr style="text-align:center;" class="row_select">
        	<td style="width:400px; text-align:left;" class="file_name">
						<a href='<?php  echo '../content/'.$file; ?>'><?php  echo $file; ?></a>
            </td>
            
            <td style="border-left:dashed 1px #0099FF;">
            	<?php
				
				$sizeOfFile = number_format((filesize("../content/".$file)/1024), 2);
				 
				if($sizeOfFile < 1024){
					echo $sizeOfFile." kb";
					}
				else if($sizeOfFile >= 1024){
					
					echo number_format((filesize($sizeOfFile)/1024), 2)." mb";
					}
				
				?>
            	
            </td>
            
            
            <td style="border-left:dashed 1px #0099FF;">
            	<button onClick="renameFile('<?php  echo $file2[0]; ?>', '<?php  echo $file; ?>')" class="button rename"></button>
            	
            </td>
            
            
            
            
            <td style="border-left:dashed 1px #0099FF;">
            <?php
			$extension = substr(strrchr($file,'.'),1);
			if($extension == "html" || $extension == "txt"){
			 ?>
            	<a href="edit.php?name=<?php  echo $file; ?>"><button class="button edit" ></button></a>
               <?php } ?>
            </td>
            
            <td style="border-left:dashed 1px #0099FF;">
            
            	<button class="button delete" onClick="deleteFile('<?php  echo $file; ?>')"></button>
            
            </td>
            
        </tr>
            
            <?php
		}
      
    }
    closedir($dh);
	?>
	</table>
	
	puppyFileExplorer by James Welch - <a href="backup.php">Backup files to zip</a>.
	
    <?php
  }
}
?>
<script>
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
	/*$(document).ready(function(e) {
        $('#file1').click(function(e) {
            $('#overlay').addClass(overlay_active);
        });
    });*/
	
    </script>
</body>
</html>