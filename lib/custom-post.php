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




// подключаем функцию активации мета блока (my_extra_fields)
add_action('add_meta_boxes', 'extra_fields', 1);

function extra_fields() {
	add_meta_box( 'id_body_type_car', 'Тип кузова', 'body_type_car_field', 'portfolio', 'normal', 'high'  );
	add_meta_box( 'id_age_car_field', 'Год выпуска', 'age_car_field', 'portfolio', 'normal', 'high'  );
}
function body_type_car_field( $post ){
	?>
	<p>Выберите тип кузова автомобиля:</p>
	<p><select name="extra[body_type_car]">
			<?php $body_type_car = get_post_meta($post->ID, 'body_type_car', 1); ?>
			<option value="Не выбрано!">Выбрать</option>
			<option value="Седан" <?php selected( $body_type_car, 'Седан' )?> >Седан</option>
			<option value="Универсал" <?php selected( $body_type_car, 'Универсал' )?> >Универсал</option>
			<option value="Хэтчбэк" <?php selected( $body_type_car, 'Хэтчбэк' )?> >Хэтчбэк</option>
			<option value="Купе" <?php selected( $body_type_car, 'Купе' )?> >Купе</option>
			<option value="Внедорожник" <?php selected( $body_type_car, 'Внедорожник' )?> >Внедорожник</option>
			<option value="Минивэн" <?php selected( $body_type_car, 'Минивэн' )?> >Минивэн</option>
			<option value="Кабриолет" <?php selected( $body_type_car, 'Кабриолет' )?> >Кабриолет</option>
		</select></p>

	<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
	<?php
}

function age_car_field( $post ){
	?>
	<p>Укажите год выпуска автомобиля:</p>
	<p><textarea type="text" name="extra[age_car]" style="width:100%;height:50px;"><?php echo get_post_meta($post->ID, 'age_car', 1); ?></textarea></p>

	<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
	<?php
}



// включаем обновление полей при сохранении
add_action('save_post', 'my_extra_fields_update', 0);

/* Сохраняем данные, при сохранении поста */
function my_extra_fields_update( $post_id ){
	if ( ! wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__) ) return false; // проверка
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; // выходим если это автосохранение
	if ( !current_user_can('edit_post', $post_id) ) return false; // выходим если юзер не имеет право редактировать запись

	if( !isset($_POST['extra']) ) return false; // выходим если данных нет

	// Все ОК! Теперь, нужно сохранить/удалить данные
	$_POST['extra'] = array_map('trim', $_POST['extra']); // чистим все данные от пробелов по краям
	foreach( $_POST['extra'] as $key=>$value ){
		if( empty($value) ){
			delete_post_meta($post_id, $key); // удаляем поле если значение пустое
			continue;
		}

		update_post_meta($post_id, $key, $value); // add_post_meta() работает автоматически
	}
	return $post_id;
}
?>