<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package avat
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="site-info">
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer();

//	if ( ! is_admin()) {
//		var_dump($wp_query);
//	}

	function __type_deal_elements(){
			$deal_terms = get_terms(array( 'taxonomy'=>'model','hide_empty'=>0, 'fields'=>'id=>slug' ));
			$deal_terms[] = implode('-', $deal_terms); // sale-rent
			return $deal_terms;
		}

	//print_r( get_queried_object() );
?>

</body>
</html>
