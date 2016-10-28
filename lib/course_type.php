<?php
// Our custom post type function
function create_course_posttype() {

	register_post_type( 'principedia_course',
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
			'menu_position' => 3,
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

	add_meta_box('principedia_title_meta', 'Course Information', 'courses_title_meta', "principedia_course", "normal", "low");
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
/*
  global $post;

  if ( $post )
  {

    update_post_meta($post->ID, "principedia_dept", @$_POST['principedia_dept']);
    update_post_meta($post->ID, "principedia_course", @$_POST['principedia_course']);
    update_post_meta($post->ID, "principedia_instructor", @$_POST['principedia_instructor']);
    update_post_meta($post->ID, "principedia_year", @$_POST['principedia_year']);

    update_post_meta($post->ID, "goals", @$_POST["goals"]);
    update_post_meta($post->ID, "instruction", @$_POST["instruction"]);
    update_post_meta($post->ID, "assignments", @$_POST["assignments"]);
    update_post_meta($post->ID, "resources", @$_POST["resources"]);
    update_post_meta($post->ID, "shouldknow", @$_POST["shouldknow"]);
  }
*/
}
add_action( 'admin_init', 'add_course_meta_boxes' );
add_action( 'save_post', 'save_course_custom_fields' );



?>


