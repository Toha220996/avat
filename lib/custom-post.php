<?php

/*
 * Переименование дефолнтного типа записей
 */

$labels = apply_filters( "post_type_labels_{$post_type}", $labels );
function rename_posts_labels( $labels ){

	$new = array(
		'name'                  => 'Статьи',
		'singular_name'         => 'Статья',
		'add_new'               => 'Добавить статью',
		'add_new_item'          => 'Добавить статью',
		'edit_item'             => 'Редактировать статью',
		'new_item'              => 'Новая статья',
		'view_item'             => 'Просмотреть статью',
		'search_items'          => 'Поиск статей',
		'not_found'             => 'Статьи не найдены.',
		'not_found_in_trash'    => 'Статьи в корзине не найдены.',
		'parent_item_colon'     => '',
		'all_items'             => 'Все статьи',
		'archives'              => 'Архивы статей',
		'insert_into_item'      => 'Вставить в статью',
		'uploaded_to_this_item' => 'Загруженные для этоой статьи',
		'featured_image'        => 'Миниатюра статьи',
		'filter_items_list'     => 'Фильтровать список статей',
		'items_list_navigation' => 'Навигация по списку статей',
		'items_list'            => 'Список статей',
		'menu_name'             => 'Статьи',
		'name_admin_bar'        => 'Статья',
	);

	return (object) array_merge( (array) $labels, $new );
}

add_filter('post_type_labels_post', 'rename_posts_labels');


/*
 * Новые типы записей
 */

function register_post_type_portfolio() {
	$labels = array(
		'name'					=> 'Портфолио работ',
		'singular_name'			=> 'Новый проект',
		'add_new'				=> 'Добавить проект',
		'add_new_item'			=> 'Добавить новый проект',
		'edit_item'				=> 'Редактировать проект',
		'new_item'				=> 'Новый проект',
		'all_items'				=> 'Все проекты',
		'view_item'				=> 'Просмотр проекта на сайте',
		'search_items'			=> 'Искать проекты',
		'not_found'				=> 'Проектов не найдено.',
		'not_found_in_trash'	=> 'В корзине нет проектов.',
		'menu_name'				=> 'Портфолио'
	);
	$args = array(
		'labels'				=> $labels,
		'taxonomies'			=> array( 'brand' ),
		'public'				=> true,
		'query_var'				=> true,
		'rewrite'				=> false,
		//'rewrite'             => array( 'slug'=>'estate/%brand%/%portfolio_id%', 'with_front'=>false, 'feeds'=>false, 'pages'=>false, 'feed'=>false, 'paged'=>false ),
		'show_in_menu'			=> true,
		'has_archive'			=> false,
		'supports'				=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
		'show_ui'				=> true,
		'show_in_nav_menus'		=> false,
		'menu_position'			=> 9,
		'menu_icon'				=> 'dashicons-schedule'
	);
	register_post_type('portfolio', $args);
}

add_action( 'init', 'register_post_type_portfolio' );

function true_add_post_columns($my_columns){
	$my_columns = array(
		'title' => __('Заголовок портфолио'),
		'brand' => 'Марка автомобиля',
		'model' => 'Модель автомобиля',
		'position' => 'Приоритет',
		'date' => __('Date')
	);
	return $my_columns;
}
 
add_filter( 'manage_edit-portfolio_columns', 'true_add_post_columns', 10, 1 );

function true_fill_post_columns( $column ) {
	global $post;
	$brand = get_the_terms( $post->post_id, 'brand' );
	$model = get_the_terms( $post->post_id, 'model' );
	
	switch ( $column ) {
		case 'brand':
			echo "<a href='edit.php?post_type=portfolio&brand=" . current($brand)->name . "'>" . current($brand)->name . "</a>";
			break;
		case 'model':
			echo "<a href='edit.php?post_type=portfolio&model=" . current($model)->name . "'>" . current($model)->name . "</a>";
			break;
		case 'position':
			echo '<p>' . get_post_meta( $post->ID , 'portfolio_sort_box' , true) . '</p>';
			break;
	}
}
 
add_action( 'manage_posts_custom_column', 'true_fill_post_columns', 10, 1 );

add_filter('manage_edit-portfolio_sortable_columns', 'add_portfolio_sortable_column');

function add_portfolio_sortable_column($sortable_columns){
	$sortable_columns['brand'] = array('name', false); // false = asc. desc - по умолчанию
	$sortable_columns['model'] = array('model_model', false); // false = asc. desc - по умолчанию

	return $sortable_columns;
}

function portfolio_sort( $post ){
  add_meta_box( 
    'portfolio_sort_box', 
    'Приоритет проекта', 
    'portfolio_sort_order', 
    'portfolio' ,
    'normal'
    );
}
add_action( 'add_meta_boxes', 'portfolio_sort' );

function portfolio_sort_order( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'portfolio_sort_order_nonce' );
	$current_pos = get_post_meta( $post->ID, 'portfolio_sort_box', true); ?>
	<p>Введите приоритет (позицию) текущего проекта:</p>
	<p>4 - самый высокий приоритет</p>
	<p>1 - самый низкий приоритет</p>
	<input id="portfolio-position" type="range" min="1" max="4" name="pos" value="<?php echo $current_pos; ?>" />
	<div class="graduate">
		<p>1</p>
		<p>2</p>
		<p>3</p>
		<p>4</p>
	</div>
	<?php
}

function save_portfolio_sort_order( $post_id ){
  if ( !isset( $_POST['portfolio_sort_order_nonce'] ) || !wp_verify_nonce( $_POST['portfolio_sort_order_nonce'], basename( __FILE__ ) ) ){
    return;
  } 
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
    return;
  }
  if ( ! current_user_can( 'edit_post', $post_id ) ){
    return;
  }
  if ( isset( $_REQUEST['pos'] ) ) {
    update_post_meta( $post_id, 'portfolio_sort_box', sanitize_text_field( $_POST['pos'] ) );
  }
}
add_action( 'save_post', 'save_portfolio_sort_order' );

?>