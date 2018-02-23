<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package avat
 */

$brands = get_terms( 'brand', array('hide_empty' => false, 'parent'  => 0));
$models = get_terms( 'model', array('hide_empty' => false, 'parent'  => 0));


?>

<article id="post-<?php the_ID(); ?>" <?php post_class("col-12"); ?>>
	<div class="single-project-content container">
        <div class="row">
            <div class="col-12">
                <span class="list-title">О проекте</span>
                <div class="project-info">
                    <div class="row">
                        <div class="keys col-3">
                            <span class="key">Марка:</span>
                        </div>
                        <div class="values">
                            <span class="value"><?php 
                            if($brands) {
                                foreach ($brands as $brand) {
                                    if($brand->slug == get_query_var('brand')) {
                                        echo $brand->name;
                                    }
                                }
                            }?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="keys col-3">
                            <span class="key">Модель:</span>
                        </div>
                        <div class="values">
                            <span class="value"><?php 
                            if($models) {
                                foreach ($models as $model) {
                                    if($model->slug == get_query_var('model')) {
                                        echo $model->name;
                                    }
                                }
                            }?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="keys col-3">
                            <span class="key">Тип кузова:</span>
                        </div>
                        <div class="values">
                            <?php
                                echo (get_post_meta($post->ID , 'body_type_car', true));
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="keys col-3">
                            <span class="key">Год выпуска:</span>
                        </div>
                        <div class="values">
                            <?php
                                echo (get_post_meta($post->ID , 'age_car', true)) . " г.";
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="keys col-3">
                            <span class="key">Вид работы:</span>
                        </div>
                        <div class="values">
                            <?php
                             $types_work = get_the_terms( $post->ID , 'type_work');
                            if($types_work) {
                                foreach ($types_work as $type_work) {
                                        echo '<span class="span-type-work">' . $type_work->name . '</span></br>'; 
                                }
                            }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .single-project-content -->
</article><!-- #post-<?php the_ID(); ?> -->
