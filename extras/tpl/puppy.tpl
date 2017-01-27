<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{title}</title>
		{description}
    	{head_purecss}
    	{head_style}
    	{head_jquery}
	    {head_evil}
	    {head_scroll_anim}
	    {head_slider}
</head>
<body class="{menu_type}">
	<div class="pure-g" id="layout">
		<div class="pure-u-1 pure-u-md-1-1">
{IF:show_slides}
    	<ul>
    	{LOOP:slides}
        <li>{slide}</li>
        {ENDLOOP}
</ul>
{ENDIF}
{parsedown}

<a href="#menu" id="menuLink" class="menu-link"><span></span></a>
<div id="menu">
<div class="pure-menu">
<a class="pure-menu-heading" href="#">{site_brand}</a>
<ul class="pure-menu-list">
<li class="pure-menu-item"><a href="{site_root}" class='pure-menu-link'>Home</a></li>
{LOOP:menu_pages}
<li class="pure-menu-item">{menu_pages}</li>
{ENDLOOP}
{IF:show_edit}{show_edit_text}{ENDIF}
{IF:puppy_link}{show_puppy_link}{ENDIF}

</ul>
    </div>
  </div>
{IF:show_social}{show_social_icons}{ENDIF}
 </div>
</div>
<script type="text/javascript">
{IF:show_slides}
  		$(function() {
    		$(".rslides").responsiveSlides({ 	});
  		});
{ENDIF}
{IF:show_social}{show_social_js_code}{ENDIF}
</script>
<script src="extras/ui.js"></script>
<script type="text/javascript">
$(document).ready(function() {
{top_menu_js}
{better_fonts_js}
    AOS.init();
});
</script>
	<!-- built with puppyCMS version {puppy_version} -->
	</body>
</html>