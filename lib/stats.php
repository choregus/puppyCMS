<?php

# show visitor stats and allow for showing of dynamic today and yesterday buttons

include('visitors.php');

echo "</table>";

echo '
<ul>
<li class="btn"><a href="#" class="all">All</a></li>
<li class="btn"><a href="#">'.date("d-m-Y").'</a></li>
<li class="btn"><a href="#">'.date("d-m-Y", time() - 60 * 60 * 24).'</a></li>
</ul>';

?>