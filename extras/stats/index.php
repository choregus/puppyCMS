<html>
<head>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
  	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.3.js"></script>
  	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" class="init">
$(document).ready(function() {
	$('#today').DataTable( {
        "iDisplayLength": 25,
        "order": [1,"desc"],
        "columnDefs": [
            {
                //hide the columns that we don't need to see because of how puppy renders
                "targets": [ 0,3,6,7,8,9,11],
                "visible": false,
                "searchable": false
            }, 
        ]
    }
  );
  
  	$('#yesterday').DataTable( {
        "iDisplayLength": 25,
        "order": [1,"desc"],
        "columnDefs": [
            {
                //hide the columns that we don't need to see because of how puppy renders
                "targets": [ 0,3,6,7,8,9,11],
                "visible": false,
                "searchable": false
            }, 
        ]
    }
  );
  
} );
	</script>      
</head>
  <body>
    
    <?php $yesterday = "cy_archive[".date('Y-m-d')."].csv"; # get the date so we can dynamically load yesterday's log file. ?>
    
    <h1>Today's Visitors</h1>
<?php readcsv('data/access_log.csv',true, 'today');  # read  csv file and put into a table ?>

  <h2>Yesterday's Visitors</h2>
<?php readcsv('data/'.$yesterday.'',true, 'yesterday');  # read  csv file and put into a table ?>
    
  
</body>
  </html>



<?php     
function readcsv($filename, $header=false, $day) {
$handle = fopen($filename, "r");
echo '<table id="'.$day.'" class="display" cellspacing="0" width="90%">';
//display header row if true
if ($header) {
    $csvcontents = fgetcsv($handle);
    echo '<thead><tr>';
    foreach ($csvcontents as $headercolumn) {
      
      # tweak the header text
       if ( strpos($headercolumn,'AGENT') !== false ) $headercolumn = "OS"; 
       if ( strpos($headercolumn,'LOOKING_FOR') !== false ) $headercolumn = "LANDED";

          echo "<th>$headercolumn</th>";
    }
    echo '</tr></thead>';
}
// displaying contents
	
	
while ($csvcontents = fgetcsv($handle)) {
  
  #tidy up the display by removing erroneous things that puppy causes (and favicon.ico thing, which may need removing)
  if ( strpos($csvcontents[4],'edit') || strpos($csvcontents[4],'extras')  || strpos($csvcontents[10],'favicon') !== false )  { 
  } else {
		
		# for use with looking for previous array	
		
		
    echo '<tr>';
			
		
		
    foreach ($csvcontents as $column) {
    	
			
      #do some tweaking depending on content of a cell
      if ( strpos($column,'NULL') !== false ) $column = "Direct"; # if its someone typing in the url
      if ( strpos($column,'http') !== false ) $column = "<a href='".$column."'>".$column."</a>"; # if its someone typing in the url
      if ( strpos($column,'google.com/bot.html') !== false ) $column = "<font color='red'>Google Bot</font>"; # if its a google bot
      if ( strpos($column,'CrOS ') !== false ) $column = "<font color='INDIGO'>Chrome OS</font>"; # if its a google bot
      if ( strpos($column,'; Android ') !== false ) $column = "<font color='DEEPPINK'>Android</font>"; # if its a google bot
      if ( strpos($column,'; Linux ') !== false ) $column = "<font color='DARKORANGE'>Linux</font>"; # if its a google bot
      if ( strpos($column,'Windows ') !== false ) $column = "<font color='SEAGREEN'>Windows</font>"; # if its a google bot
      if ( strpos($column,'Macintosh') !== false ) $column = "<font color='DARKKHAKI'>Apple Mac</font>"; # if its a google bot
      if ( strpos($column,'iPhone') !== false ) $column = "<font color='DARKKHAKI'>iPhone</font>"; # if its a google bot
      
					
				
        #echo "<td>".$csvcontents[2]." xxx ".$column." yyy ".$jw[$i]."</td>";
        echo "<td>".$column."</td>";
			
			
    }
    echo '</tr>';
																								
		
        } //end of removing erroneous things that puppy puts in
 
} //end of while loop
echo '</table>';
		
fclose($handle);
}

?>