<?php
/*
REALLY SIMPLE TRAFFIC LOGGER V1.0.2

Copyright Lee Hodson, leehodson[a@t]journalxtra.com, 2011/2012/2013

Script's Page: https://journalxtra.com/web-development/php/really-simple-traffic-logger/

Kudos to AJK's comment at JournalXtra to add an if statement to disable the table's echo if no data is to be output the screen.

Requires PHP 5.2 +

LICENSE

0, This license relates to ALL versions of really simple traffic logger, derivative works, forks and its (or their) inclusion within other works. For the purposes of this license, the word "script" implies "really simple traffic logger" and the term "author" implies "Dion de Ville".
1, This script is free to use.
2, You may employ this script for any purpose.
3, The author is not responsible for any negative consequences.
4, The author is not responsible for the way it is employed.
5, You may share this script but this license must remain.
5b, When  sharing this script, this license and everything above it (including the author's details) must remain intact whether the script is shared in its entirety or shared as a derivative or fork of itself or a partitive work of a larger script.
6. This script may be used for commercial purposes.
7, The author of this script welcomes donations (visit http://journalxtra.com to send donations or contact the script's author).

*/

# CONFIGURABLE VARIABLES

    # Run indefinitely or run once only?
    $no_cycle = "0" ; # Set to "0" to work during the stated times on every day they occur. Set to "1" to run once only. $no_cycle= "1" activates session mode

    # Directory path. Where is the script relative to the page that calls it? Do not include the script title (stl.php) here.
    $dpath = "extras/stats/";
    # Stats Storage Directory path. Should stay as data/
    $spath = "data/";

    # Decide the counters to display. Switch  all to "0" to run silently. Switch any to "1" to enable it.
    $show_se_cy_counter = "0" ; # Show session/cycle counter (current cycle's count)
    $show_tote_counter = "0" ; # Show end of days' tally counter (archived count)
    $show_total_counter = "0" ; # Show tally (sum of current log and archive counts)

    # Title the counters. HTML tags allowed. Remember to use single quotes (') instead of double quotes (")
    $title_se_cy_counter = "<strong>Today's Visits:</strong>" ;
    $title_tote_counter = "<strong>Previous Visits:</strong>" ;
    $title_total_counter = "<strong>Total Visits:</strong>" ;

    # Style the counter. Remove these if you want to specify the styling in your CSS sheet or elsewhere
    $ts = "background-color:black;font-size: 12px;"; # Table
    $td = "background-color: red;padding-left: 4px;padding-right: 4px;"; # Table Data
    $ss = "color: white;"; # text Span

    # Timezone
     date_default_timezone_set('Europe/London'); # Comment this out if you wish to use your server's time. Valid timezones are listed at http://www.php.net/manual/en/timezones.php

    # Logging times
    # Set the cycle's start and end times to the same values to track visitors over 24 hour cycles
    # Archives are created at the end of every cycle.

    # Cycle start
    $start_hour = "00" ; # 24 Hour format. Range: 00 to 23. Use leading zeros. E.g 01 or 02 or 15
    $start_minutes = "00" ; # Range: 00 to 59. Use leading zeros
    $start_seconds = "00" ; # Range: 00 to 59. Use leading zeros

    # Cycle end.
    # Must be higher than Cycle Start times when $no_cycle = "1" otherwise the counter stops.
    $reset_hour = "00";
    $reset_minutes = "00";
    $reset_seconds = "00";

# FUNCTION
# Find search engine query strings ( modified from http://betterwp.net/wordpress-tips/get-search-keywords-from-referrer/ )

    function keywords($url = '')
    {
        // Get the referrer
        $referrer = (!empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
        $referrer = (!empty($url)) ? $url : $referrer;
        if (empty($referrer))
            return false;
     
        // Parse the referrer URL
        $parsed_url = parse_url($referrer);
        if (empty($parsed_url['host']))
            return false;
        $host = $parsed_url['host'];
        $query_str = (!empty($parsed_url['query'])) ? $parsed_url['query'] : '';
        $query_str = (empty($query_str) && !empty($parsed_url['fragment'])) ? $parsed_url['fragment'] : $query_str;
        if (empty($query_str))
            return false;
     
        // Parse the query string into a query array
        parse_str($query_str, $query);
     
        // Check some major search engines to get the correct query var
        $search_engines = array(
            'q' => 'alltheweb|altavista|aol|aolsearch|ask|ask|bing|daum|ekolay|google|images.google||kvasir|live|msn|mynet|najdi|ozu|pchome|search|sesam|seznam|sNOWsh|szukacz',
            'query' => 'aol.|cnn|lycos|mamma|naver|netscape|terra',
            'qs' => 'alice|virgilio',
            'p' => 'yahoo',
            'wd' => 'baidu',
            'about' => 'terms',
            'aol..' => 'encquery',
            'answers' => 's',
            'eniro' => 'search_word',
            'google.se' => 'as_q', // seen on google.se
            'onet' => 'qt',
            'rambler' => 'words',
            'voila' => 'rdata',
            'wp' => 'szukaj',
            'yam' => 'k',
            'yandex' => 'text'

        );
        foreach ($search_engines as $query_var => $se)
        {
            $se = trim($se);
            preg_match('/(' . $se . ')\./', $host, $matches);
            if (!empty($matches[1]) && !empty($query[$query_var]))
                return $query[$query_var];
        }
        return false;
    }



# NOT REALLY CONFIGURABLE VARIABLES (except, maybe, file names)

  # Current server time and date
    $time = date("H:i:s");
    $date = date("Y-m-d");
    $_24 = "86400" ; # 24 Hours worth of seconds
  # File names
    $log = "access_log.csv";
    $archive_se = "se_archive"."[".$date."].csv";
    $archive_cy = "cy_archive"."[".$date."].csv";
    $tally = "tally.txt" ;
  # Access details
    if (isset($_SERVER['REMOTE_ADDR'])) {$ip = $_SERVER['REMOTE_ADDR'];} else {$ip = "NULL";}
    if (isset($_SERVER['REMOTE_ADDR'])) {$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);} else {$hostname = "NULL";}
    if (isset($_SERVER['HTTP_REFERER'])) {$referrer = $_SERVER['HTTP_REFERER'];} else {$referrer = "NULL";}
    if (isset($_SERVER['HTTP_USER_AGENT'])) {$agent = $_SERVER['HTTP_USER_AGENT'];} else {$agent = "NULL";}
    if (isset($_SERVER['SCRIPT_FILENAME'])) {$page = $_SERVER['SCRIPT_FILENAME'];} else {$page = "NULL";}
    if (isset($_SERVER['DOCUMENT_ROOT'])) {$doc_root = $_SERVER['DOCUMENT_ROOT'];} else {$doc_root = "NULL";}
    if (isset($_SERVER['PHP_SELF'])) {$script = $_SERVER['PHP_SELF'];} else {$script = "NULL";}
    if (isset($_SERVER['PATH_INFO'])) {$path = $_SERVER['PATH_INFO'];} else {$path = "NULL";}
    if (isset($_SERVER['REQUEST_URI'])) {$looking_for = $_SERVER['REQUEST_URI'];} else {$looking_for = "NULL";}
  # Function handle
    $keywords = keywords();

  # Log file's contents
    $log_file_content = "\"$date\","."\"$time\","."\"$ip\","."\"$hostname\","."\"$referrer\","."\"$agent\","."\"$page\","."\"$doc_root\","."\"$script\","."\"$path\","."\"$looking_for\","."\"$keywords\"";
    $log_file_header = "\"DATE\","."\"TIME\","."\"IP\","."\"HOSTNAME\","."\"REFERRER\","."\"AGENT\","."\"PAGE\","."\"DOC_ROOT\","."\"SCRIPT\","."\"PATH\","."\"LOOKING_FOR\","."\"KEYWORDS\"";



# DEFAULT VARIABLE VALUES

    if (($start_hour == 0) | ($start_hour == "")) {$start_hour = "00";}
    if (($start_minutes == 0) | ($start_minutes == "")) {$start_minutes == "00";}
    if (($start_seconds == 0) | ($start_seconds == "")) {$start_seconds == "00";}

    if (($reset_hour == 0) | ($reset_hour == "")) {$reset_hour = "00";}
    if (($reset_minutes == 0) | ($reset_minutes == "")) {$reset_minutes == "00";}
    if (($reset_seconds == 0) | ($reset_seconds == "")) {$reset_seconds == "00";}

    $cycle_start = strtotime("$start_hour:$start_minutes:$start_seconds");
    $cycle_end = strtotime("$reset_hour:$reset_minutes:$reset_seconds");
    $cycle = $cycle_end-$cycle_start;
    if ($cycle == 0) {$cycle = $_24;}
    if (($no_cycle == "") | ($no_cycle > 1)) {$no_cycle = "0";}

    $log = $dpath.$spath.$log ;
    $archive_se = $dpath.$spath.$archive_se ;
    $archive_cy = $dpath.$spath.$archive_cy ;
    $tally = $dpath.$spath.$tally ;

# WORKING

# Create log file with header if it does not exist
if (!file_exists($log))
{
file_put_contents($log,"$log_file_header\n");
}
# Cyclic logging
if (($no_cycle == 0) && (time() >= $cycle_start))
{
    if ((time() >= $cycle_end) && (!file_exists($archive_cy)))
      {
      $count = (count(file($log))-1);
      file_put_contents($tally,"$count\n",FILE_APPEND);
      $arc_log = file_get_contents($log);
      file_put_contents($archive_cy,"$date.$time\n");
      file_put_contents($archive_cy,$arc_log);
      file_put_contents($log,"$log_file_header\n");
      }
    # Create/append access log file
     file_put_contents($log,"$log_file_content\n",FILE_APPEND);
}
# Session logging
if (($no_cycle == 1) && (time() >= $cycle_start) && (time() <= $cycle_end))
{
    # Append access log file
     file_put_contents($log,"$log_file_content\n",FILE_APPEND);
}
# Create end of session archive
if (($no_cycle == 1) && (time() > $cycle_end) && (!file_exists($archive_se)))
    {
    $count = (count(file($log))-1);
    file_put_contents($tally,"$count\n",FILE_APPEND);
    $arc_log = file_get_contents($log);
    file_put_contents($archive_se,"$date.$time\n");
    file_put_contents($archive_se,$arc_log);
    file_put_contents($log,"$log_file_header\n");
    }
# Sum the contents of $tally (tally.txt)
if (file_exists($tally))
    {
    $tal = file($tally);
    $tote = array_sum($tal);
    } else
    {
    $tote = 0;
    }

# Count Log File's Lines
$count = (count(file($log))-1);

# START COUNTER DISPLAY

  if ($show_se_cy_counter == "1" || $show_total_counter == "1" || $show_tote_counter == "1" ){

    echo "<table id='simple_php_counter' style='$ts'>";    
    if ($show_se_cy_counter == "1")
      {
      echo "<tr><td style='$td'><span class='simple_php_counter' style='$ss'>".$title_se_cy_counter."</span></td><td style='$td'>$count</td></tr>";
      }

    if ($show_total_counter == "1")
      {
      echo "<tr><td style='$td'><span class='simple_php_counter' style='$ss'>".$title_tote_counter."</span></td><td style='$td'>$tote</td></tr>";
      }

    if ($show_tote_counter == "1")
      {
      echo "<tr><td style='$td'><span class='simple_php_counter' style='$ss'>".$title_total_counter."</span></td><td style='$td'>".($count+$tote)."</td></tr>";
      }
    echo "</table>";

  # END COUNTER DISPLAY

  }

?>