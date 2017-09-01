
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{title}</title>
		{description}
    	{head_jquery}
        {head_evil}
	    {head_scroll_anim}
	    {head_slider}
    <!-- Bootstrap Core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    	{head_style}
    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 70px; /* Required padding for .navbar-fixed-top. */
    }

    .navbar-nav > li:hover > .navbar-nav-sub{
        display: block;
        right: 0;
    }

    .navbar-nav > li li:hover > .navbar-nav-sub{
        display: block;
        top: 0;
    }

    .navbar-nav-sub{
        display: none;
        position: absolute;
        top: 100%;
        right: 100%;
        min-width: 200px;
        border:1px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
        padding: 0;
        list-style: none;
        margin: 0;
    }

        .navbar-nav-sub li{
            position: relative;
        }

            .navbar-nav-sub li a{
                display: block;
                padding: 8px 15px;
                white-space: nowrap;
                overflow:hidden;
                text-overflow: "...";
                color: #000;
                text-decoration: none;
            }
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{site_root}">{site_brand}</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    {navigation}
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                {parsedown}
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Bootstrap Core JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>

</html>
