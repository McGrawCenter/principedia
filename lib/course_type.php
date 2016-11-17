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
      $content .= "<div id='ca_list'>GENERATE LIST OF RELATED COURSE ANALYSES HERE</div>";
    }
    return $content;
}


add_filter( 'the_content', 'principedia_add_ca_list' );




?>
