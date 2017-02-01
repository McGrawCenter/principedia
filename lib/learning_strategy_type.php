<?php
// Our custom post type function
function create_strategy_posttype() {

    if(!post_type_exists('strategy')) {
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
			'taxonomies' => array('strategy_category'),
			'show_in_menu' => true,
			'menu_position' => 8,
			'has_archive' => true,
			'rewrite' => array('slug' => 'strategies'),
		)
	);
	create_strategy_type_taxonomy();
	$post_id = create_strategy_sample_post();
	$term_obj = get_term_by('name','General Topics','stratcat');
 	wp_set_object_terms( $post_id, $term_obj->term_id, 'stratcat' ); 
    } // end if post type not exists


}
add_action( 'init', 'create_strategy_posttype' );


/************************
* Populate with one sample strategy
*************************/
function create_strategy_sample_post() {
    global $wpdb;


    $create_s_page = 'Active Reading Strategies: Remember and Analyze What You Read';
    $create_s_page_slug = 'active-reading-strategies';

    $the_page = get_page_by_title( $create_s_page, 'OBJECT', 'strategy' );

    if ( ! $the_page ) {
        // Create post object
        $_p = array();
        $_p['post_title'] = $create_s_page;
        $_p['post_content'] = "The text of the learning strategy....";
        $_p['post_status'] = 'publish';
        $_p['post_type'] = 'strategy';
        $_p['comment_status'] = 'closed';
        $_p['ping_status'] = 'closed';

        // Insert the post into the database
        return wp_insert_post( $_p );
    }
    else {
	return false;
    }

}






/************************* CREATE STRATEGY CATS TAXONOMY *********************************/


//add_action( 'init', 'create_strategy_type_taxonomy' );

function create_strategy_type_taxonomy() {


	$labels = array(
		'name'                       => _x( 'Strategy Category', 'taxonomy general name' ),
		'singular_name'              => _x( 'Strategy Category', 'taxonomy singular name' ),
		'search_items'               => __( 'Search Strategy Categories' ),
		'popular_items'              => __( 'Popular Categories' ),
		'all_items'                  => __( 'All Strategy Categories' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Strategy Category' ),
		'update_item'                => __( 'Update Strategy Category' ),
		'add_new_item'               => __( 'Add New Strategy Category' ),
		'new_item_name'              => __( 'New Strategy Category Name' ),
		'separate_items_with_commas' => __( 'Separate categories with commas' ),
		'add_or_remove_items'        => __( 'Add or remove categories' ),
		'choose_from_most_used'      => __( 'Choose from the most used categories' ),
		'not_found'                  => __( 'No categories found.' ),
		'menu_name'                  => __( 'Strategy Categories' ),
	);



	register_taxonomy(
		'stratcat',
		'strategy',
		array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'stratcat' ),
		)
	);


	// INSERT SOME SAMPLE CATEGORIES
	$categories = array('General Topics','Time Management','Exams','Reading', 'Oral Presentation', 'Problem Solving', 'Independent Work');

	foreach($categories as $cat) {
	   wp_insert_term($cat, 'stratcat');
	}


}
