
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
var table = $('#visitors').DataTable( {
"order": [[ 0, "desc" ]]
});

$('ul').on( 'click', 'a', function () {
 
table
    .columns( 0 )
    .search(  $(this).text() )
    .draw();
});

$('ul').on( 'click', 'a.all', function () {

table
    .search( "" )
    .columns( 0 )
    .search( "" )
    .draw();
});


} );
	</script>

<h1>Unique Visitors</h2>
<br/><br/>
<div style="clear:both;"></div>
  <table class="display compact" cellspacing="1" id="visitors">
    <thead><tr><th>DATE</th><th>IP</th><th>BROWSER</th><th>Landed</th><th>REFERRER</th></tr></thead>
     <tr><td>09-06-2017 17:04</td><td>[ ::1 ]</td><td>Mozilla/5.0 (Windows NT 10.0; WOW64; rv:54.0) Gecko/20100101...</td><td>/puppycms/...</td><td>Unknown</td></tr>
     <tr><td>27-08-2017 10:56</td><td>[ 86.27.6.253 ]</td><td>Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36...</td><td>/admin/assets/img/favicon.png...</td><td>http://retrosoccermanager.com/admin/settings.php</td></tr>
     <tr><td>27-08-2017 11:12</td><td>[ 2.137.102.2 ]</td><td>python-requests/2.13.0...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>27-08-2017 11:12</td><td>[ 86.27.6.253 ]</td><td>Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36...</td><td>/admin/assets/img/favicon.png...</td><td>http://retrosoccermanager.com/admin/edit.php?name=index.txt</td></tr>
     <tr><td>27-08-2017 11:13</td><td>[ 144.48.151.11 ]</td><td>Mozilla/5.0 (Windows NT 10.0; WOW64; rv:56.0) Gecko/20100101...</td><td>/favicon.ico...</td><td>Unknown</td></tr>
     <tr><td>27-08-2017 11:15</td><td>[ 86.27.6.253 ]</td><td>Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36...</td><td>//...</td><td>http://retrosoccermanager.com//</td></tr>
     <tr><td>27-08-2017 11:25</td><td>[ 144.48.151.11 ]</td><td>Mozilla/5.0 (Windows NT 10.0; WOW64; rv:56.0) Gecko/20100101...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>27-08-2017 11:27</td><td>[ 86.27.6.253 ]</td><td>Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36...</td><td>/admin/assets/img/favicon.png...</td><td>http://retrosoccermanager.com/admin/page-editor.php</td></tr>
     <tr><td>27-08-2017 11:34</td><td>[ 144.48.151.11 ]</td><td>Mozilla/5.0 (Windows NT 10.0; WOW64; rv:56.0) Gecko/20100101...</td><td>/about-us...</td><td>Unknown</td></tr>
     <tr><td>27-08-2017 11:34</td><td>[ 86.27.6.253 ]</td><td>Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36...</td><td>/admin/assets/img/favicon.png...</td><td>http://retrosoccermanager.com/admin/edit.php?name=index.txt</td></tr>
     <tr><td>27-08-2017 12:34</td><td>[ 104.238.248.15 ]</td><td>Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>27-08-2017 13:07</td><td>[ 144.48.151.11 ]</td><td>Mozilla/5.0 (Windows NT 10.0; WOW64; rv:56.0) Gecko/20100101...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>27-08-2017 13:27</td><td>[ 58.97.220.224 ]</td><td>Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36...</td><td>/about-us...</td><td>Unknown</td></tr>
     <tr><td>27-08-2017 13:29</td><td>[ 66.249.93.6 ]</td><td>Mozilla/5.0 (Linux; Android 8.0.0; Pixel XL Build/OPR6.17062...</td><td>/about-us...</td><td>android-app://com.google.android.gm</td></tr>
     <tr><td>27-08-2017 13:29</td><td>[ 66.249.93.10 ]</td><td>Mozilla/5.0 (Linux; Android 8.0.0; Pixel XL Build/OPR6.17062...</td><td>/favicon.ico...</td><td>http://retrosoccermanager.com/about-us</td></tr>
     <tr><td>27-08-2017 13:29</td><td>[ 66.249.93.8 ]</td><td>Mozilla/5.0 (Linux; Android 8.0.0; Pixel XL Build/OPR6.17062...</td><td>/favicon.ico...</td><td>http://retrosoccermanager.com/about-us</td></tr>
     <tr><td>27-08-2017 13:29</td><td>[ 66.249.93.10 ]</td><td>Mozilla/5.0 (Linux; Android 8.0.0; Pixel XL Build/OPR6.17062...</td><td>//...</td><td>http://retrosoccermanager.com/about-us</td></tr>
     <tr><td>27-08-2017 13:29</td><td>[ 66.249.93.8 ]</td><td>Mozilla/5.0 (Linux; Android 8.0.0; Pixel XL Build/OPR6.17062...</td><td>/favicon.ico...</td><td>http://retrosoccermanager.com/about-us</td></tr>
     <tr><td>27-08-2017 13:52</td><td>[ 109.202.27.22 ]</td><td>Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.7 (KHTML...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>27-08-2017 13:53</td><td>[ 58.97.220.224 ]</td><td>Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36...</td><td>/about-us...</td><td>Unknown</td></tr>
     <tr><td>27-08-2017 14:44</td><td>[ 144.48.151.11 ]</td><td>Mozilla/5.0 (Windows NT 10.0; WOW64; rv:56.0) Gecko/20100101...</td><td>/about-us...</td><td>Unknown</td></tr>
     <tr><td>27-08-2017 15:20</td><td>[ 110.88.44.29 ]</td><td>Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>27-08-2017 15:20</td><td>[ 70.42.131.170 ]</td><td>Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Tr...</td><td>/...</td><td>http://www.bing.com/search?q=amazon</td></tr>
     <tr><td>27-08-2017 16:46</td><td>[ 212.83.152.183 ]</td><td>Mozilla/4.0 (compatible; Synapse)...</td><td>/wp-login.php...</td><td>Unknown</td></tr>
     <tr><td>27-08-2017 17:00</td><td>[ 86.27.6.253 ]</td><td>Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36...</td><td>/admin/assets/img/favicon.png...</td><td>http://retrosoccermanager.com/admin/index.php</td></tr>
     <tr><td>27-08-2017 18:06</td><td>[ 144.76.219.43 ]</td><td>Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:51.0) Gecko/2010...</td><td>/...</td><td>http://www.siteindexed.com/myurl=retrosoccermanager.com</td></tr>
     <tr><td>27-08-2017 18:06</td><td>[ 86.27.6.253 ]</td><td>Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36...</td><td>/...</td><td>http://retrosoccermanager.com/faq</td></tr>
     <tr><td>27-08-2017 23:52</td><td>[ 50.117.89.222 ]</td><td>Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>28-08-2017 04:55</td><td>[ 202.105.116.213 ]</td><td>Mozilla/7.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>28-08-2017 05:44</td><td>[ 212.83.158.95 ]</td><td>Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTM...</td><td>/...</td><td>http://retrosoccermanager.com</td></tr>
     <tr><td>28-08-2017 06:16</td><td>[ 50.117.89.222 ]</td><td>Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>28-08-2017 08:26</td><td>[ 144.48.151.11 ]</td><td>Mozilla/5.0 (Windows NT 10.0; WOW64; rv:56.0) Gecko/20100101...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>28-08-2017 09:10</td><td>[ 66.249.93.8 ]</td><td>Mozilla/5.0 (Linux; Android 8.0.0; Pixel XL Build/OPR6.17062...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>28-08-2017 09:12</td><td>[ 66.249.93.6 ]</td><td>Mozilla/5.0 (Linux; Android 8.0.0; Pixel XL Build/OPR6.17062...</td><td>/about...</td><td>http://retrosoccermanager.com/</td></tr>
     <tr><td>28-08-2017 09:12</td><td>[ 66.249.93.10 ]</td><td>Mozilla/5.0 (Linux; Android 8.0.0; Pixel XL Build/OPR6.17062...</td><td>/favicon.ico...</td><td>http://retrosoccermanager.com/about</td></tr>
     <tr><td>28-08-2017 09:12</td><td>[ 66.249.93.8 ]</td><td>Mozilla/5.0 (Linux; Android 8.0.0; Pixel XL Build/OPR6.17062...</td><td>/faq...</td><td>http://retrosoccermanager.com/about</td></tr>
     <tr><td>28-08-2017 09:14</td><td>[ 66.249.93.6 ]</td><td>Mozilla/5.0 (Linux; Android 8.0.0; Pixel XL Build/OPR6.17062...</td><td>/faq...</td><td>http://retrosoccermanager.com/faq</td></tr>
     <tr><td>28-08-2017 09:14</td><td>[ 66.249.93.10 ]</td><td>Mozilla/5.0 (Linux; Android 8.0.0; Pixel XL Build/OPR6.17062...</td><td>/screenshots...</td><td>http://retrosoccermanager.com/faq</td></tr>
     <tr><td>28-08-2017 09:14</td><td>[ 66.249.93.8 ]</td><td>Mozilla/5.0 (Linux; Android 8.0.0; Pixel XL Build/OPR6.17062...</td><td>/favicon.ico...</td><td>http://retrosoccermanager.com/screenshots</td></tr>
     <tr><td>28-08-2017 09:16</td><td>[ 66.249.93.10 ]</td><td>Mozilla/5.0 (Linux; Android 8.0.0; Pixel XL Build/OPR6.17062...</td><td>/favicon.ico...</td><td>http://retrosoccermanager.com/</td></tr>
     <tr><td>28-08-2017 10:15</td><td>[ 86.27.6.253 ]</td><td>Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36...</td><td>/...</td><td>http://retrosoccermanager.com/</td></tr>
     <tr><td>28-08-2017 14:20</td><td>[ 104.238.248.15 ]</td><td>Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>28-08-2017 16:33</td><td>[ 66.249.66.22 ]</td><td>Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.c...</td><td>/robots.txt...</td><td>Unknown</td></tr>
     <tr><td>28-08-2017 16:38</td><td>[ 66.249.76.39 ]</td><td>Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.c...</td><td>/faq...</td><td>Unknown</td></tr>
     <tr><td>28-08-2017 16:47</td><td>[ 174.129.103.253 ]</td><td>Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>28-08-2017 17:30</td><td>[ 86.27.6.253 ]</td><td>Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36...</td><td>/...</td><td>http://retrosoccermanager.com/screenshots</td></tr>
     <tr><td>28-08-2017 20:16</td><td>[ 198.186.192.44 ]</td><td>Unknown...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>28-08-2017 20:47</td><td>[ 34.212.13.96 ]</td><td>Opera/12.0(Windows NT 5.1;U;en)Presto/22.9.168 Version/12.00...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>28-08-2017 23:39</td><td>[ 104.238.248.15 ]</td><td>Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>29-08-2017 05:20</td><td>[ 66.249.76.41 ]</td><td>Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.c...</td><td>/faq...</td><td>Unknown</td></tr>
     <tr><td>29-08-2017 06:09</td><td>[ 104.238.248.15 ]</td><td>Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>29-08-2017 06:31</td><td>[ 66.249.76.39 ]</td><td>Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.c...</td><td>/about...</td><td>Unknown</td></tr>
     <tr><td>29-08-2017 09:45</td><td>[ 109.224.217.102 ]</td><td>Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 ...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>29-08-2017 11:15</td><td>[ 38.100.21.171 ]</td><td>Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2)...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>29-08-2017 15:43</td><td>[ 104.238.248.15 ]</td><td>Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)...</td><td>/...</td><td>Unknown</td></tr>
     <tr><td>29-08-2017 19:04</td><td>[ 86.27.6.253 ]</td><td>Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36...</td><td>/admin/assets/img/favicon.png...</td><td>http://retrosoccermanager.com/admin/settings.php</td></tr>
