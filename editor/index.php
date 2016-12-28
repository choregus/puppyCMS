<?php
	session_start();
?>
<html>
<head>

	<title>File List</title>

	<link rel="stylesheet" href="https://unpkg.com/purecss@0.6.1/build/pure-min.css">
	<link rel="stylesheet" type="text/css" href="assets/alertify.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="assets/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="assets/alertify.min.js"></script>
	<script type="text/javascript">
		var filename;
		function renameFile(x, name){
		// filename =  x.substr(x.lastIndexOf('.')+1);
		// console.log(filename);

		// var extension = x.substr(0, x.lastIndexOf('.')) || x;
		// console.log(extension);

			alertify.set({ buttonFocus: "none" });
			alertify.prompt("Rename '"+x+"' into", function (e, str) {
			    // str is the input text
			    if (e) {
			    	if (str == "") {
			    		alertify.alert("You must type a name.");
			    	} else {
				        $.ajax({
						    type: "POST",
						    url: "function.php",
						    data: "rename=" + str + "&oldName="+name,
						    success : function(text){
						    	alertify.alert("File successfully renamed");
						        window.location="index.php";
						    }
						});
			    	}
			    } else {
			        // user clicked "cancel"
			    }
			}, x);

		}

		function deleteFile(name) {
			alertify.set({ buttonFocus: "none" });
			alertify.confirm('Are you sure you want to delete "'+ name +'"', function (e) {
			    if (e) {
			        $.ajax({
					    type: "POST",
					    url: "function.php",
					    data: "oldName=" + name,
					    success : function(text){
					        window.location="index.php";
					    }
					});
			    } else {
			        // user clicked "cancel"
			    }
			});
		        // alert(respond);
				// window.location="index.php";
		}
		
		function addNew() {
			alertify.set({ buttonFocus: "none" });
			alertify.prompt("Create a page", function (e, str) {
			    // str is the input text
			    if (e) {
			    	if (str == "") {
			    		alertify.alert("You must type a name.");
			    	} else {
				    	var pathx=str;
				        $.ajax({
						    type: "POST",
						    url: "function.php",
						    data: "pathx=" + pathx,
						    success : function(data){
						    	console.log(data);
						    	var loc = "edit.php?name="+data;
						        window.location = loc;
						    }
						});
			    	}
			    } else {
			        // user clicked "cancel"
			    }
			}, "");
		}
		
		$(document).ready(function(e) {
	        $('#uploadbtn').click(function(e) {
	        	$('#overlay').show();
	            $('#formCont').show();
	        });
			$('#cancel').click(function(e) {
	            $('#formCont').hide();
	        	$('#overlay').hide();
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
			
				echo '<script>alert("Invalid Login");</script>';
				
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


if(isset($_POST['upload'])){
	$uploadFile = $_FILES['uploadFile'];

	if($uploadFile['size'] > 1) {
		$exten = explode(".", strrev($uploadFile['name']));
		$run = false;
		if($exten[0] == "txt") {
			$run = true;
		}else if($exten[0] == "gpj"){
			$run = true;
		}else if($exten[0] == "fig"){
			$run = true;
		}else if($exten[0] == "gnp"){
			$run = true;
		}else if($exten[0] == "fdp"){
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


	<div class="overlay" id="overlay"></div>

    <div id="formCont" class="puppy-modal">
      	<form enctype="multipart/form-data" action="#" method="post">
      		<h5 class="puppy-modal-title">Upload</h5>
      		<div class="puppy-modal-body">
      			<label>Select file</label>
      			<input type="file" name="uploadFile" />
      		</div>

      		<div class="puppy-modal-footer">
      			<input type="submit" name="upload" value="upload" class="pure-button button-success"/>
            	<input type="button" value="Cancel" id="cancel"  class="pure-button button-error"/>
      		</div>
        </form>
    </div>

    <h1 class="page-title">Available Files</h1>

    <div class="container button-list">
    	<button class="pure-button pure-button-primary" title="Create new page" onClick="addNew()"><i class="fa fa-file-o"></i> New Page</button>
		<button class="pure-button pure-button-primary" title="Upload assets" id="uploadbtn"><i class="fa fa-upload"></i> Upload Assets</button>
    </div>

    <div class="container">
    	<table class="pure-table pure-table-horizontal file-list-table" cellspacing="0" width="100%">
	    	<thead>
		      	<tr>
		        	<td>Name</td>
		            <td>Size</td>
		            <td width="130" align="center">Actions</td>
		        </tr>
		    </thead>
		    <tbody>
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
		        <tr class="row_select">
		        	<td class="file_name">
						<a href='<?php  echo '../content/'.$file; ?>'><?php  echo $file; ?></a>
		            </td>
		            
		            <td>
		            	<?php
							$sizeOfFile = number_format((filesize("../content/".$file)/1024), 2);
							 
							if($sizeOfFile < 1024){
								echo $sizeOfFile." kb";
							} else if($sizeOfFile >= 1024){
								echo number_format((filesize($sizeOfFile)/1024), 2)." mb";
							}
						?>
		            </td>

		            <td align="right">
		            	<button title="Rename file" class="button rename button-success pure-button button-small" onClick="renameFile('<?php  echo $file2[0]; ?>', '<?php  echo $file; ?>')"><i class="fa fa-pencil"></i></button>

			            <?php
							$extension = substr(strrchr($file,'.'),1);
							if($extension == "html" || $extension == "txt"){
						?>
			            	<a title="Edit page" class="button-secondary pure-button button-small" href="edit.php?name=<?php  echo $file; ?>"><i class="fa fa-edit"></i></a>
			            <?php } ?>

		            	<button title="Delete file or page" class="button delete button-error pure-button button-small" onClick="deleteFile('<?php  echo $file; ?>')"><i class="fa fa-trash"></i></button>
		            </td>
		        </tr>
	            <?php
			}
	      
	    }
	    closedir($dh);
		?>
		</tbody>
		</table>
    </div>

	<div>
		puppyFileExplorer by James Welch - <a href="backup.php">Backup files to zip</a> | Go back to <a href="../">your site</a>.
	</div>
		
    <?php
  }
}
?>
<script>
	$(document).ready(function(e) {
        $('#overlay').click(function(e) {
            $(this).hide();
			$('#formCont').hide();
        });
    });
</script>
</body>
</html>
