<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package avat
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="site">
	<header id="masthead" class="site-header container-fluid">
		<div class="row">
			<div class="site-branding-wrap container-fluid">
				<!--  --><div class="row">
					<div class="site-branding container">
						<div class="row">
							<div class="col-12 col-md-3">
								<div class="custom-logo-wrap">
									<object type="image/svg+xml" data="<?php echo get_template_directory_uri() . "/img/logo.svg"; ?>"  id="main-logo"></object>
									<p class="logo-desk">автоателье</p>
								</div>
							</div>
							<div class="adress col-12 col-md-3">
								<div class="adress-wrap">
									<p><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo get_theme_mod('adress', ''); ?></p>
								</div>
							</div>
							<div class="work-time col-12 col-md-3">
								<div class="work-time-wrap">
									<p><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo get_theme_mod('work_time', ''); ?></p>
								</div>
							</div>
							<div class="phone col-12 col-md-3">
								<div class="phone-wrap">
									<p><i class="fa fa-mobile" aria-hidden="true"></i><?php echo get_theme_mod('phone', ''); ?></p>
								</div>
							</div>
						</div><!-- .row -->
					</div><!-- .site-branding -->
				</div><!-- .row -->
			</div><!-- .site-branding-wrap -->
			<div class="main-navigation-wrap">
				<nav id="site-navigation" class="main-navigation">
						<?php
							wp_nav_menu( array(
								'container'			=> false,
								'theme_location'	=> 'menu-1',
								'menu_id'			=> 'primary-menu',
								'menu_class'		=> 'main-menu row',
								'walker'			=> new magomra_walker_nav_menu
							));
						?>
				</nav><!-- #site-navigation -->
			</div><!-- .main-navigation-wrap -->
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
