<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-portfolio
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
                </div><!-- .sidebar -->
				<div class="project col-12 col-md-9">
                    <div class="row">
                        <header class="page-header col-12">
                            <h1 class="page-title"><?php wp_title("", true); ?></h1>
                        </header><!-- .page-header -->
				<?php
				while ( have_posts() ) : the_post();

                    //the_post_navigation();





					// If comments are open or we have at least one comment, load up the comment template.
//					if ( comments_open() || get_comments_number() ) :
//						comments_template();
//					endif;

				endwhile; // End of the loop.

                get_template_part( 'template-parts/content-single-portfolio' );

				?>
				    </div><!-- .single-project -->
            </div><!-- .row -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
