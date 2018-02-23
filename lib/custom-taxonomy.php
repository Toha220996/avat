<?php

/*
 * Новые таксономии
 */


function create_tax_brand() {

  $labels = array(
    'name'						=> 'Марка автомобиля',
    'singular_name'				=> 'Марка автомобиля',
    'search_items'				=> 'Найти марку',
    'all_items'					=> 'Все марки',
    'parent_item'				=> 'Марка автомобиля',
    'parent_item_colon'			=> 'Марка автомобиля:',
    'edit_item'					=> 'Изменить марку',
    'update_item'				=> 'Обновить марку',
    'add_new_item'				=> 'Добавить новую марку автомобиля',
    'new_item_name'				=> 'Новая марка',
    'menu_name'					=> 'Марки автомобилей'
  );

  register_taxonomy('brand' ,array('portfolio'), array(
    'hierarchical'				=> true,
    'labels'					=> $labels,
    'show_ui'					=> true,
    'show_admin_column'			=> true,
    'query_var'					=> true,
    'rewrite'					=> false,
	'publicly_queryable'		=> true,
  ));

}

add_action( 'init', 'create_tax_brand', 0 );

function create_tax_model() {

  $labels = array(
    'name'						=> 'Модель автомобиля',
    'singular_name'				=> 'Модель автомобиля',
    'search_items'				=> 'Найти модель',
    'all_items'					=> 'Все модели',
    'parent_item'				=> 'Модель автомобиля',
    'parent_item_colon'			=> 'Модель автомобиля:',
    'edit_item'					=> 'Изменить модель',
    'update_item'				=> 'Обновить модель',
    'add_new_item'				=> 'Добавить новую модель автомобиля',
    'new_item_name'				=> 'Новая модель',
    'menu_name'					=> 'Модели автомобилей'
  );

  register_taxonomy('model' ,array('portfolio'), array(
    'hierarchical'				=> true,
    'labels'					=> $labels,
    'show_ui'					=> true,
    'show_admin_column'			=> true,
    'query_var'					=> true,
    'rewrite'					=> false,
	'publicly_queryable'		=> true,
  ));

}

add_action( 'init', 'create_tax_model', 0 );

function create_tax_type_work() {

  $labels = array(
    'name'						=> 'Вид работы',
    'singular_name'				=> 'Вид работы',
    'search_items'				=> 'Найти вид',
    'all_items'					=> 'Все виды работ',
    'parent_item'				=> 'Вид работы',
    'parent_item_colon'			=> 'Вид работы:',
    'edit_item'					=> 'Изменить вид',
    'update_item'				=> 'Обновить вид',
    'add_new_item'				=> 'Добавить новый вид автомобиля',
    'new_item_name'				=> 'Новый вид',
    'menu_name'					=> 'Вид работ'
  );

  register_taxonomy('type_work' ,array('portfolio'), array(
    'hierarchical'				=> false,
    'labels'					=> $labels,
    'show_ui'					=> true,
    'show_admin_column'			=> true,
    'query_var'					=> true,
    'rewrite'					=> false,
	'publicly_queryable'		=> true,
  ));

}

add_action( 'init', 'create_tax_type_work', 0 );



/*
 * Изменение Чек-бокса на Радио-кноппки
 */

function tr_new_taxonomy_box() {
 
	// перечислить список таксономий через запятую
	$choosed_taxonomies = array( 'brand' );
	remove_meta_box( "modeldiv", 'portfolio', 'side' );
 
	if ( empty($choosed_taxonomies) )
		return;
 
	foreach ( $choosed_taxonomies as $tax_name ) {
		$taxonomy = get_taxonomy( $tax_name );
 
		if ( !$taxonomy->hierarchical || !$taxonomy->show_ui || empty($taxonomy->object_type) )
			continue;
 
		foreach ( $taxonomy->object_type as $post_type ) {
 
			// удаляем стандартный метабокс
			remove_meta_box( "{$tax_name}div", $post_type, 'side' );
 
			// добавляем собственный
			add_meta_box( "unique-{$tax_name}-div", $taxonomy->labels->singular_name, 'tr_tax_metabox', $post_type, 'side', 'high', array('taxonomy' => $tax_name) );
		}
	}
}
add_action( 'admin_menu', 'tr_new_taxonomy_box' );
 
/*
 * функция для вывода непосредственно списка элементов таксономий
 */

function tr_print_radiolist( $post_id, $taxonomy ) {
	$terms = get_terms( $taxonomy, array('hide_empty' => false, 'parent'  => 0) );
	if ( empty($terms) )
		return;
 
	// значение аттрибута name для всех радио-кнопок
	$name = ( $taxonomy == 'category' ) ? 'post_category' : "tax_input[{$taxonomy}]";
 
	// определяем, к каким рубрикам относится текущий пост
	$current_post_terms = get_the_terms( $post_id, $taxonomy );
	$current = array();
	if ( !empty($current_post_terms) ) {
		foreach ( $current_post_terms as $current_post_term )
			$current[] = $current_post_term->term_id;
	}

	$current_post_model_terms = get_the_terms( $post_id, 'model' );
	$current_model = array();
	if ( !empty($current_post_model_terms) ) {
		foreach ( $current_post_model_terms as $current_post_model_term )
			$current_model[] = $current_post_model_term->term_id;
}
 
// вывод списка
	$list = '';
	foreach ( $terms as $term ) {
		$list .= "<li id='{$taxonomy}-{$term->term_id}'>";
		$list .= "<label class='brand-name'>";
		//$list .= "<input type='radio' name='{$name}[]' value='{$term->term_id}' ".checked( in_array($term->term_id, $current), true, false )." id='in-{$taxonomy}-{$term->term_id}' />";
		$list .= " {$term->name}</label>";
		$list .= "</li>\n";
 
		// если вам наплевать на вложенные рубрики, то цикл foreach можно закончить прямо здесь
		$childs = get_terms( 'model', array('hide_empty' => false, 'parent'  => 0));
			$list .= "<ul class='children'>";
			foreach ($childs as $child){
				if ( $term->slug == get_term_meta($child->term_id , 'brand' , true ) ) {
					$list .= "<li id='{$taxonomy}-{$child->term_id}'>";
					$list .= "<label class='selectit'>";
					$list .= "<input type='radio' name='tax_input[model][]' value='{$child->term_id}' ".checked( in_array($child->term_id, $current_model), true, false )." id='in-{$taxonomy}-{$child->term_id}' />";
					$list .= " {$child->name}</label>";
					$list .= "</li>\n";
				}
			}
			$list .= "</ul>";
	}
	echo $list;
}


function set_portfolio_brand_value( $post_id , $post ) {
	if($post->post_type == 'portfolio') {
		$selected_model_terms = wp_get_post_terms($post_id, 'model');
		foreach ($selected_model_terms as $selected_model_term) {
			$brand_value = get_term_meta($selected_model_term->term_id , 'brand', false);
		}
		if (!empty($brand_value))
			wp_set_object_terms($post_id, current($brand_value) , 'brand');
	}
}

add_action("save_post", 'set_portfolio_brand_value', 10 , 2);

/*
 * содержимое метабокса
 */

function tr_tax_metabox( $post, $box ) {
	if ( !isset($box['args']) || !is_array($box['args']) )
		$args = array();
	else
		$args = $box['args'];
 
	$defaults = array('taxonomy' => 'category');
	extract( wp_parse_args($args, $defaults), EXTR_SKIP );
	$tax = get_taxonomy($taxonomy);
 
	$name = ( $taxonomy == 'category' ) ? 'post_category' : 'tax_input[' . $taxonomy . ']';
 
	$metabox = "<div id='taxonomy-{$taxonomy}' class='categorydiv'>";
	$metabox .= "<input type='hidden' name='{$name}' value='0' />";
	$metabox .= "</ul>";
	$metabox .= "<div id='{$name}-all'>";
	$metabox .= "<ul id='{$taxonomy}checklist' class='list:{$taxonomy} categorychecklist form-no-clear'>";
	echo $metabox;
 
	tr_print_radiolist( $post->ID, $taxonomy );
 
	echo "</ul></div></div>";
}

$taxname = 'model';

// Поля при добавлении элемента таксономии
add_action("{$taxname}_add_form_fields", 'add_new_custom_fields');
// Поля при редактировании элемента таксономии
add_action("{$taxname}_edit_form_fields", 'edit_new_custom_fields');

// Сохранение при добавлении элемента таксономии
add_action("create_{$taxname}", 'save_custom_taxonomy_meta');
add_action("create_{$taxname}", 'set_brand_value');
// Сохранение при редактировании элемента таксономии
add_action("edited_{$taxname}", 'save_custom_taxonomy_meta');
add_action("edited_{$taxname}", 'set_brand_value');

function list_brands( $term_id) {
	$categories = get_terms( 'brand' , array('hide_empty' => false, 'parent'  => 0));
	 
	// если рубрики, соответствующие заданным параметрам, существуют,
	if($categories){
	 
		$metakoks =  "<select id='brand-checklist' name='brand'>";
		foreach ($categories as $cat){
	 		$metakoks .= "<option class='brand-{$cat->term_id}' " . selected( $cat->slug, get_term_meta( $term_id , 'brand' , 1 ) , false ) . " value='{$cat->slug}'>";
	 		$metakoks .= "{$cat->name}</option>";
		}
		$metakoks .= "<input type='hidden' name='extra[brand]' value='aaa'/>";
		$metakoks .= '</select>';
	}
	return $metakoks;
}



function set_brand_value() {
	$extra_brand = $_POST['extra']['brand'];
	$selected_brand = $_POST['brand'];
	$extra_brand = $selected_brand;
}

function edit_new_custom_fields( $term ) {
	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label>Марка автомобиля</label></th>
		<td>
			<?php 
				echo list_brands( $term->term_id ); 
			?>
		</td>
	</tr>
	<?php
}

function add_new_custom_fields( $taxonomy_slug ){
	?>
	<div class="form-field">
		<label for="tag-brand">Марка автомобиля</label>
		<?php 
			echo list_brands( $term->term_id ); 
		?>
	</div>
	<?php
}

function save_custom_taxonomy_meta( $term_id ) {
	if ( ! isset($_POST['extra']) ) return;
	if ( ! current_user_can('edit_term', $term_id) ) return;
	if ( ! wp_verify_nonce( $_POST['_wpnonce'], "update-tag_$term_id" ) && // wp_nonce_field( 'update-tag_' . $tag_ID );
		! wp_verify_nonce( $_POST['_wpnonce_add-tag'], "add-tag" ) // wp_nonce_field('add-tag', '_wpnonce_add-tag');
	) return;

	// Все ОК! Теперь, нужно сохранить/удалить данные
	$extra = wp_unslash($_POST['extra']);

	foreach( $extra as $key => $val ){
		$val = $_POST['brand'];
		// проверка ключа
		$_key = sanitize_key( $key );
		if( $_key !== $key ) wp_die( 'bad key'. esc_html($key) );

		// очистка
		if( $_key === 'tag_posts_shortcode_links' )
			$val = sanitize_textarea_field( strip_tags($val) );
		else
			$val = sanitize_text_field( $val );

		// сохранение
		if( ! $val )
			delete_term_meta( $term_id, $_key );
		else
			update_term_meta( $term_id, $_key, $val );
	}
	return $term_id;
}

/*
 * Изменение колонок списка таксономий
 */


function true_add_tax_model_columns($my_columns){
	$my_columns = array(
		'cb' => '<input type="checkbox" />',
		'name' => __('Название модели'),
		'brand' => __('Название марки'),
		'slug' => __('Slug'),
		'posts' => __('Количество проектов')
		);
	return $my_columns;
}
 
add_filter( 'manage_edit-model_columns', 'true_add_tax_model_columns');

function true_add_tax_brand_columns($my_columns){
	$my_columns = array(
		'cb' => '<input type="checkbox" />',
		'name' => __('Название марки'),
		'slug' => __('Slug'),
		'posts' => __('Количество проектов')
		);
	return $my_columns;
}
 
add_filter( 'manage_edit-brand_columns', 'true_add_tax_brand_columns');

function true_fill_tax_model_columns( $out, $column_name, $id ) {
	$term = get_term($id, 'model');
	$brand_terms = get_term_meta($term->term_id, 'brand');
	foreach ($brand_terms as $brand_term) {
		$brand = $brand_term;
	}
	switch ($column_name) {
		case 'brand':
			$out .= "<a href='edit.php?post_type=portfolio&brand=" . $brand . "'>" . ucfirst($brand) . "</a>"; 
 			break;
		default:
			break;
	}
	return $out;
}
 
add_action( 'manage_model_custom_column', 'true_fill_tax_model_columns', 10, 3 );

add_filter('manage_edit-model_sortable_columns', 'add_brand_sortable_column');
function add_brand_sortable_column($sortable_columns){
	$sortable_columns['brand'] = array('brand', false); // false = asc. desc - по умолчанию

	return $sortable_columns;
}

?>
