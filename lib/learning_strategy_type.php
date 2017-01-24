<?php
// Our custom post type function
function create_strategy_posttype() {

	register_post_type( 'strategy',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'Strategies' ),
				'singular_name' => __( 'Strategy' ),
				'edit_item'     => __( 'Edit Learning Strategy' ),
				'new_item'      => __( 'New Learning Strategy' ),
				'add_new_item'      => __( 'Add New Learning Strategy' ),
			),
			'supports' => array('title','editor','revisions'),
			'hierarchical' => false,
			'public' => true,
  			'show_in_rest' => true,
			'taxonomies' => array('category'),
			'show_in_menu' => true,
			'menu_position' => 8,
			'has_archive' => true,
			'rewrite' => array('slug' => 'strategies'),
		)
	);
}
// Hooking up our function to theme setup
add_action( 'init', 'create_strategy_posttype' );





/***************** CREATE CATEGORIES IF THEY ARE NOT ALREADY CREATED ***********************/
require_once(ABSPATH . "wp-admin/includes/taxonomy.php");


if( !term_exists('Learning Strategy') ) { wp_create_category('Learning Strategy'); }
$parent_term = get_term_by( 'name', 'Learning Strategy', 'category' );
//echo $parent_term->term_id."<br />";
$parent_id = $parent_term->term_id;

$categories = array('General Topics','Time Management','Exams','Reading', 'Oral Presentation', 'Problem Solving', 'Independent Work');
foreach($categories as $cat) {
   if( !term_exists($cat) ) { wp_create_category($cat, $parent_id ); }
}



