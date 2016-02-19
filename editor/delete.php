<?php
$file = "../content/".$_POST['oldName'];
if (!unlink($file))
  {
  echo ("Error deleting $file");
  }
else
  {
  echo ("Deleted $file");
  }
?> 