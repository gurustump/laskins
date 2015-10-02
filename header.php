<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js laskinsfest"><!--<![endif]-->

	<head>
		<meta charset="utf-8">
		
		<?php $isFilmFestPage = tribe_event_in_category('film-festival') && is_single(); ?>
		<?php $isMusicFestPage = tribe_event_in_category('music-festival') && is_single(); ?>
		<?php // force Internet Explorer to use the latest rendering engine available ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<?php // hacked the title here for just film-festival pages so it won't say "Upcoming Events" before the festival's name ?>
		<title><?php $isFilmFestPage ? the_title() :  wp_title(' | '); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-touch-icon.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">
            <meta name="theme-color" content="#121212">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php // wordpress head functions ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?>

		<?php // drop Google Analytics Here ?>
		<?php // end analytics ?>

	</head>
	<?php $bodyClass = '';
	if ($isFilmFestPage) { $bodyClass .= 'film-festival-page'; }
	if ($isMusicFestPage) { $bodyClass .= 'music-festival-page'; } ?>
	<body <?php body_class($bodyClass); ?> itemscope itemtype="http://schema.org/WebPage">

		<div id="container">

			<header class="header" role="banner" itemscope itemtype="http://schema.org/WPHeader">

				<div id="inner-header" class="wrap cf">

					<?php
						$logoTag = is_front_page() ? 'h1' : 'p';
					?>
					<<?php echo $logoTag; ?> id="logo" class="h1" itemscope itemtype="http://schema.org/Organization">
						<a href="<?php echo home_url(); ?>" rel="nofollow">
							<img src="<?php echo get_template_directory_uri(); ?>/library/images/logo-outlined.png" alt="<?php bloginfo('name'); ?>" />
							<span><?php bloginfo('name'); ?></span>
						</a>
					</<?php echo $logoTag; ?>>
					<a class="trigger-nav TRIGGER_NAV" href="#">
						<span class="ic">
							<span class="bar-1"></span>
							<span class="bar-2"></span>
							<span class="bar-3"></span>
						</span>
					</a>

					<?php // if you'd like to use the site description you can un-comment it below ?>
					<?php // bloginfo('description'); ?>

					<nav role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement" class="MAIN_NAV main-nav">

						<?php $socialFollow = get_posts(array('post_type' => 'module', 'numberposts' => 1, 'module_cat' => 'social-follow')); 
						if (count($socialFollow) > 0) { ?>
						<div class="social-follow">
							<?php echo $socialFollow[0]->post_content; ?>
						</div>
						<?php } ?>
						<?php wp_nav_menu(array(
    					         'container' => false,                           // remove nav container
    					         'container_class' => 'menu',                 // class of container (should you choose to use it)
    					         'menu' => __( 'The Main Menu', 'bonestheme' ),  // nav name
    					         'menu_class' => 'nav top-nav',               // adding custom nav class
    					         'theme_location' => 'main-nav',                 // where it's located in the theme
    					         'before' => '',                                 // before the menu
        			               'after' => '',                                  // after the menu
        			               'link_before' => '',                            // before each link
        			               'link_after' => '',                             // after each link
        			               'depth' => 0,                                   // limit the depth of the nav
    					         'fallback_cb' => ''                             // fallback function (if there is one)
						)); ?>

					</nav>

				</div>

			</header>
			
<?php /*
<pre style="padding-top:120px;background:orange;">
<?php print_r( wp_title(' | ', false)); ?>
</pre>
*/ ?>