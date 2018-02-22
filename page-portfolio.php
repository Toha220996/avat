<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package avat
 */

get_header(); ?>

	<div id="primary" class="content-area container">
		<main id="main" class="site-main">
			<div class="row">
				<div class="sidebar col-12 col-md-3">
					<?php 
						get_template_part( 'template-parts/custom-sidebar' );
					?>
				</div>
				<div class="projects col-12 col-md-9">
					<div class="row">
						<header class="page-header col-12">
							<h1 class="page-title"><?php wp_title("", true); ?></h1>
						</header><!-- .page-header -->
						<?php
						$args = array(
							'post_type'	=> 'portfolio',
							'orderby'	=> 'meta_value',
							'meta_key'	=> 'portfolio_sort_box',
							'order'		=> 'DESC'
						);
						$query = new WP_Query($args);
						while ( $query->have_posts() ) : $query->the_post();
						?>
						<?php
							get_template_part( 'template-parts/content-list-portfolio' );
						endwhile;?>
					</div>
				</div><!-- .projects -->
			</div><!-- .row -->
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
