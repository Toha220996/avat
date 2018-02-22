
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
			<?php
			if ( have_posts() ) : ?>
			<div class="row">
				<div class="sidebar col-3">
					<?php 
						get_template_part( 'template-parts/custom-sidebar' );
					?>
				</div>
				<div class="projects col-9">
					<div class="row">
						<header class="page-header col-12">
							<h1 class="page-title">Автомобили: <?php
							if( get_query_var('model') && get_query_var('brand'))
								echo ucfirst(get_query_var('brand')) . ' ' . strtoupper(get_query_var('model')); 
							else
								echo ucfirst(get_query_var('brand'));
							?>
							</h1>
							<?php
								the_archive_description( '<div class="archive-description">', '</div>' );
							?>
						</header><!-- .page-header -->
						<div class="container">
							<div class="row">
								<?php
								while ( have_posts() ) : the_post();

									/*
									 * Include the Post-Format-specific template for the content.
									 * If you want to override this in a child theme, then include a file
									 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
									 */
									get_template_part( 'template-parts/content-list-portfolio' );

								endwhile;
							else :

								get_template_part( 'template-parts/content', 'none' );

							endif; ?>
							</div>
						</div>
					</div>
				</div><!-- .projects -->
			</div><!-- .row -->
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
