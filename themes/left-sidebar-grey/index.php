<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<?php echo $site_description;?>
	<meta name="author" content="">
	<link rel="icon" href="../../favicon.ico">

	<title><?php echo $site_title;?></title>

	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css" rel="stylesheet">
	<!-- Example - How to include assets from Theme folder -->
	<!-- <link href="<?php echo $site_template;?>/assets/example.css" rel="stylesheet"> -->
	<?php echo $theme_stylesheet;?>
	
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://fastcdn.org/FlowType.JS/1.1/flowtype.js" type="text/javascript"></script>
</head>

<body>
	<div id="wrapper">
        <div id="page-content-wrapper">
            <div class="container">
                <?php
					echo $contents;
				?>
            </div>
        </div>

        <footer class="bg-faded">
			<div class="container">
				&copy; <?php echo date('Y')?> <?php echo $site_name; ?>
			</div>
		</footer>
		<a href="#sidebar-toggle" class="btn btn-primary sidebar-toggle" id="sidebar-toggle"><i class="glyphicon glyphicon-menu-hamburger"></i></a>
        <div id="sidebar-wrapper">
        	<a class="sidebar-brand">
        		<?php echo $site_name; ?>
        	</a>
            <?php
				echo $get_navigation('sidebar-nav', 'sidebar-nav-sub', "", "", '<span class="glyphicon glyphicon-triangle-bottom gly-caret"></span>');
			?>
        </div>
    </div>
    
	<script src="<?php echo $site_template;?>/scripts.js"></script>
</body>

</html>