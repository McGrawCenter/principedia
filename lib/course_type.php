<?php
// Our custom post type function
function create_course_posttype() {

	register_post_type( 'course',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'Courses' ),
				'singular_name' => __( 'Course' ),
				'edit_item'     => __( 'Edit Course' ),
				'new_item'      => __( 'New Course' ),
				'add_new_item'      => __( 'Add New Course' ),
			),
			'supports' => array('title','editor'),
			'hierarchical' => false,
			'public' => true,
			'taxonomies' => array('categories'),
			'show_in_menu' => true,
			'menu_position' => 7,
			'has_archive' => true,
			'rewrite' => array('slug' => 'course'),
		)
	);
}
// Hooking up our function to theme setup
add_action( 'init', 'create_course_posttype' );






/**
 * Add principedia_course custom fields
 */
function add_course_meta_boxes() {

	add_meta_box('principedia_title_meta', 'Course Information', 'courses_title_meta', "course", "normal", "low");
}
/**
 * Create content to be added to title metabox
 */
function courses_title_meta() {
	global $post;
	$custom = get_post_custom( $post->ID );
	if(isset($custom["course_registrar_id"][0])) 		{ $course = $custom["course_registrar_id"][0]; } else { $course = ""; }

   ?>

  <p>
    <label for="course_registrar_id">Registrar ID:</label>
    <input id="course_registrar_id" type="text" autocomplete="off" spellcheck="true" value="<?php echo $course; ?>" size="30" name="course_registrar_id" style="width:100%;">
  </p>
   <?php
}



/**
 * Save custom field data when creating/updating posts
 */
function save_course_custom_fields(){

  global $post;

  if ( $post && $post->post_type=='course' )
  {

    update_post_meta($post->ID, "course_registrar_id", @$_POST['course_registrar_id']);

  }

}
add_action( 'admin_init', 'add_course_meta_boxes' );
add_action( 'save_post', 'save_course_custom_fields' );


/**
 * If page is of Course Type, add list of related courses analyses after the content
 */


function principedia_add_ca_list( $content ) {

    if(get_post_type() == 'course') {
	global $post;

        $content .= "<h4>Associated course analyses</h4>";
	$content .= '<ul>';
	$args =  array( 'numberposts'	=> -1,'post_type' => 'principedia','meta_key' => 'principedia_course','meta_value' => $post->post_title );
	$analyses =  get_posts($args);
	foreach($analyses as $analysis) {
	   $content .=  "<li><a href='{$analysis->guid}'>{$analysis->post_title}</a></li>";
	}
	$content .=  '</ul>';

    }
    return $content;
}


add_filter( 'the_content', 'principedia_add_ca_list' );





/************************* CREATE DEPARTMENTS TAXONOMY *********************************/


add_action( 'init', 'create_course_dept_taxonomy' );

function create_course_dept_taxonomy() {


	$labels = array(
		'name'                       => _x( 'Departments', 'taxonomy general name' ),
		'singular_name'              => _x( 'Department', 'taxonomy singular name' ),
		'search_items'               => __( 'Search Departments' ),
		'popular_items'              => __( 'Popular Departments' ),
		'all_items'                  => __( 'All Departments' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Department' ),
		'update_item'                => __( 'Update Department' ),
		'add_new_item'               => __( 'Add New Department' ),
		'new_item_name'              => __( 'New Department Name' ),
		'separate_items_with_commas' => __( 'Separate departments with commas' ),
		'add_or_remove_items'        => __( 'Add or remove departments' ),
		'choose_from_most_used'      => __( 'Choose from the most used departments' ),
		'not_found'                  => __( 'No departments found.' ),
		'menu_name'                  => __( 'Departments' ),
	);



	register_taxonomy(
		'department',
		'course',
		array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'departments' ),
		)
	);





// OUTPUT JSON LIST OF DEPARTMENTS

	if(isset($_GET['json']) && $_GET['json'] == 'departments') {
	  $taxonomy = 'department';
	  $tax_terms = get_terms($taxonomy);
	  die(json_encode($tax_terms));
	}



// OUTPUT JSON LIST OF courses

	if(isset($_GET['json']) && $_GET['json'] == 'courses') {

		$dept = $_GET['dept'];

		$returnArr = array();
		// first we need a list of posts for a specific dept

		$posts = get_posts(array(
		    'post_type' => 'course',
		    'tax_query' => array(
			array(
			'taxonomy' => 'department',
			'orderby' => 'title',
			'order' => 'ASC',
			'field' => 'name',
			'terms' => $dept)
		    ))
		);

		// then we need to loop through and extract the course ids

		foreach($posts as $key=>$val) {
		  $returnArr[$key] = new StdClass();
		  $returnArr[$key]->course = $val->post_title;
		}

		die(json_encode($returnArr));
	}






// OUTPUT JSON LIST OF ANALYSES BASED ON COURSE ID
	if(isset($_GET['json']) && $_GET['json'] == 'analyses') {

		$course = $_GET['courseid'];
		if($course != "") {
		  $returnArr = array();
		  // get a list of all the principedia type posts with $course as the principedia_course

		  $posts = get_posts(array(
		    'post_type' => 'principedia',
		    'meta_key'	=> 'principedia_course',
		    'meta_value'=> $course
		    )
		  );
		  foreach($posts as &$post) {
		    $post->meta = get_post_meta($post->ID);
		  }
		
		  die(json_encode($posts));
		}
	}

}

?>
