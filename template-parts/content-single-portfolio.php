<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package avat
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="single-project-content">
        <div class="row">
            <div class="single-portfolio-box col-12">
                <span class="list-title">О проекте</span>
                <div class="project-info">
                    <div class="row">
                        <div class="keys col-3">
                            <span class="key">Марка:</span>
                        </div>
                        <div class="values">
                            <span class="value"><?php echo get_query_var('brand'); ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="keys col-3">
                            <span class="key">Модель:</span>
                        </div>
                        <div class="values">
                            <span class="value"><?php echo $model; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="keys col-3">
                            <span class="key">Тип кузова:</span>
                        </div>
                        <div class="values">

                        </div>
                    </div>
                    <div class="row">
                        <div class="keys col-3">
                            <span class="key">Год выпуска:</span>
                        </div>
                        <div class="values">

                        </div>
                    </div>
                    <div class="row">
                        <div class="keys col-3">
                            <span class="key">Вид работы:</span>
                        </div>
                        <div class="values">

                        </div>
                    </div>
                </div>
            </div>
        </div>
<!--		<a href="--><?php //the_permalink() ?><!--" class="project-link">-->

<!--			<div class="project-description">-->
<!--<!--                <h1 class="page-title">--><?php ////wp_title("", true); ?><!--<!--</h1>-->
<!--<!--				<header class="entry-header">-->
<!--<!--					--><?php
////					if ( is_singular() ) :
////						the_title( '<h1 class="entry-title">', '</h1>' );
////					else :
////						the_title( '<h2 class="entry-title">', '</h2>' );
////					endif;
////					?>
<!--<!--				</header><!-- .entry-header -->
<!---->
<!--<!--				<div class="entry-content">-->
<!--<!--					--><?php
////						the_content( sprintf(
////							wp_kses(
////								/* translators: %s: Name of current post. Only visible to screen readers */
////								__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'avat' ),
////								array(
////									'span' => array(
////										'class' => array(),
////									),
////								)
////							),
////							get_the_title()
////						) );
////
////						wp_link_pages( array(
////							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'avat' ),
////							'after'  => '</div>',
////						) );
////					?>
<!---->
<!--<!--				</div><!-- .entry-content -->
<!--			</div><!-- .project-description -->
<!--		</a>-->
	</div><!-- .single-project-content -->
</article><!-- #post-<?php the_ID(); ?> -->
