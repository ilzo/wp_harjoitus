<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="page-wrapper">
<div class="bg-img">
    <img id="palm-tree-and-sun" src="<?php echo get_template_directory_uri(); ?>/img/background/retro_palm_sun.png" alt="Retro palm tree and sun" width="600px" height="579px" />
</div>
<header id="header-single">
    <div id="header-logo-container">
        <?php mdb_custom_logo(); ?>
    </div>
    <nav id="site-nav" class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <?php bootstrap_nav(); ?>
            </div>
        </div>
    </nav>
</header> 
<div id="content" class="site-content">