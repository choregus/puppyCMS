<h1>List of Previous File Edits</h1>
<?php

$files = array();
$dir = opendir('.'); // open the cwd..also do an err check.
while(false != ($file = readdir($dir))) {
        if(($file != ".") and ($file != "..") and ($file != "index.php")) {
                $files[] = $file; // put in array.
        }
}

natsort($files); // sort.

// print.
foreach($files as $file) {
        echo("<a href='$file'>$file</a> <br />\n");
}



?>