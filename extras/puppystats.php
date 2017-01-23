<?php

#PuppyStats - a very simple web statistics tool built for PuppyCRM, based on microLogger.
    define("DATE_FORMAT","d-m-Y H:i");
    define("LOG_FILE","extras/visitors.php");

$logfileHeader='
<!DOCTYPE html>
<html>
<head>
   <title>Puppy Stats</title>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
  	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.3.js"></script>
  	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<style>
.btn {
  background: #3498db;
  font-family: Arial;
  color: #ffffff;
  font-size: 16px;
  padding: 10px;

  float: left;
  width: 150px;
  list-style-type: none;
  margin-left: 10px;
}

.btn:hover {
  background: #3cb0fd;
}

li a {
    color: #fff;
    text-decoration: none;
}
</style>
</head>
<body>
<script type="text/javascript">
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!

var yyyy = today.getFullYear();
if(dd<10){
    dd="0"+dd;
}
if(mm<10){
    mm="0"+mm;
}
var today = dd+"-"+mm+"-"+yyyy;
var yesterday = (dd-1)+"-"+mm+"-"+yyyy;


$(document).ready(function() {
var table = $(\'#visitors\').DataTable( {
"order": [[ 0, "desc" ]]
});

$(\'ul\').on( \'click\', \'a\', function () {
 
table
    .columns( 0 )
    .search(  $(this).text() )
    .draw();
});

$(\'ul\').on( \'click\', \'a.all\', function () {

table
    .search( "" )
    .columns( 0 )
    .search( "" )
    .draw();
});


} );
	</script>

<h1>Unique Visitors</h2>
<ul>
<li class="btn"><a href="#" class="all">All</a></li>
<li class="btn"><a href="#">'.date("d-m-Y").'</a></li>
<li class="btn"><a href="#">'.date("d-m-Y", time() - 60 * 60 * 24).'</a></li>
</ul>
<br/><br/>
<div style="clear:both;"></div>
  <table class="display compact" cellspacing="1" id="visitors">
    <thead><tr><th>DATE</th><th>IP</th><th>BROWSER</th><th>Landed</th><th>REFERRER</th></tr></thead>'."\n";

    $userAgent = (isset($_SERVER['HTTP_USER_AGENT']) && ($_SERVER['HTTP_USER_AGENT'] != "")) ? $_SERVER['HTTP_USER_AGENT'] : "Unknown";
    $userIp    = (isset($_SERVER['REMOTE_ADDR'])     && ($_SERVER['REMOTE_ADDR'] != ""))     ? $_SERVER['REMOTE_ADDR']     : "Unknown";
    $refferer  = (isset($_SERVER['HTTP_REFERER'])    && ($_SERVER['HTTP_REFERER'] != ""))    ? $_SERVER['HTTP_REFERER']    : "Unknown";
    $uri       = (isset($_SERVER['REQUEST_URI'])     && ($_SERVER['REQUEST_URI'] != ""))     ? $_SERVER['REQUEST_URI']     : "Unknown";

    $hostName   = gethostbyaddr($userIp);
    $actualTime = date(DATE_FORMAT);
    $userAgent  = substr($userAgent,0,60)."..."; #truncate this as is not that important
    
#create a log entry to write the latest user's info to the end of the file
    $logEntry = "     <tr><td>$actualTime</td><td>[ $userIp ]</td><td>$userAgent</td><td>$uri</td><td>$refferer</td></tr>\n";

#### write to the file ####

#if the file doesnt yet exist, create it
    if (!file_exists(LOG_FILE)) {
        $logFile = fopen(LOG_FILE,"w");
        fwrite($logFile, $logfileHeader);
        fwrite($logFile,$logEntry);
        fclose($logFile);
    }
    else { #add to the log file if it already exists.
        $logFile = fopen(LOG_FILE,"a");

#grab the last line of the file, so we can see the IP address of the previous visitor
$file = file(LOG_FILE);
#the line below effectively does a tail -1
for ($i = max(0, count($file)-1); $i < count($file); $i++) {
#the line below grabs the IP address from the logEntry
preg_match('/\[(.*)\]/', $file[$i], $matches);
}

# ignore this page view if it's the same IP as the last page view (so only record unique visitors)
if ($matches[0] !== "[ ".$userIp." ]" ) {
    
    fwrite($logFile,$logEntry); }
    fclose($logFile);
    }
#### end of  writing to the file ####
?>