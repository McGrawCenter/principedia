<?php






// Our custom post type function
function create_ca_posttype() {

	register_post_type( 'principedia',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'Analyses' ),
				'singular_name' => __( 'Analysis' ),
				'edit_item'     => __( 'Edit Course Analysis' ),
				'new_item'      => __( 'New Course Analysis' ),
				'add_new_item'      => __( 'Add New Course Analysis' ),
			),
			'supports' => array('title','revisions','comments'),
			'hierarchical' => false,
			'public' => true,
			'taxonomies' => array('categories'),
			'show_in_menu' => true,
			'menu_position' => 6,
			'has_archive' => true,
			'rewrite' => array('slug' => 'principedia'),
		)
	);
}

add_action( 'init', 'create_ca_posttype' );







/******************************************
 * Add principedia custom fields
 ******************************************/
function add_principedia_meta_boxes() {

	add_meta_box('principedia_title_meta', 'Course Information', 'principedia_title_meta', "principedia", "normal", "low");

	add_meta_box("principedia_goals_meta", "Description of Course Goals and Curriculum", "add_principedia_goals_box", "principedia", "normal", "low");
	add_meta_box("principedia_instr_meta", "Learning From Classroom Instruction", "add_principedia_instr_box", "principedia", "normal", "low");
	add_meta_box("principedia_assig_meta", "Learning For and From Assignments and Assessments", "add_principedia_assig_box", "principedia", "normal", "low");
	add_meta_box("principedia_resou_meta", "External Resources", "add_principedia_resou_box", "principedia", "normal", "low");
	add_meta_box("principedia_shoul_meta", "What Students Should Know About This Course For Purposes of Course Selection", "add_principedia_shoul_box", "principedia", "normal", "low");
}


/******************************************
 * Create Course Information field area
 ******************************************/
function principedia_title_meta() {
	global $post;
	$custom = get_post_custom( $post->ID );
	if(isset($custom["principedia_course"][0])) 		{ $course = $custom["principedia_course"][0]; } else { $course = ""; }
	if(isset($custom["principedia_instructor"][0])) 	{ $instructor = $custom["principedia_instructor"][0]; } else { $instructor = ""; }
	if(isset($custom["principedia_semester"][0])) 		{ $semester = $custom["principedia_semester"][0]; } else { $semester = ""; }
	if(isset($custom["principedia_year"][0])) 		{ $year = $custom["principedia_year"][0]; } else { $year = ""; }
   ?>

  <p>
    <label for="principedia_course">Course Code:</label>
    <input id="principedia_course" type="text" autocomplete="off" spellcheck="true" value="<?php echo $course; ?>" size="30" name="principedia_course" style="width:100%;">
  </p>
  <p>
    <label for="principedia_semester">Semester:</label>
    <select id="principedia_semester" name="principedia_semester">
      <option value="F"<?php if($semester=='F') {echo "selected";} ?>>Fall</option>
      <option value="S"<?php if($semester=='F') {echo "selected";} ?>>Spring</option>
      <option value="SU"<?php if($semester=='F') {echo "selected";} ?>>Summer</option>
    </select>
  </p>
  <p>
    <label for="principedia_year">Year:</label>
    <input id="principedia_year" type="text" autocomplete="off" spellcheck="true" value="<?php echo $year; ?>" size="30" name="principedia_year" style="width:100%;">
  </p>
  <p>
    <label for="principedia_instructor">Instructor:</label>
    <input id="principedia_instructor" type="text" autocomplete="off" spellcheck="true" value="<?php echo $instructor; ?>" size="30" name="principedia_instructor" style="width:100%;">
  </p>

   <?php
}


/******************************************
 * Create goals field area
 ******************************************/
function add_principedia_goals_box()
{
	global $post;
	$custom = get_post_custom( $post->ID );
	if(isset($custom["goals"][0])) { $goals = $custom["goals"][0]; } else { $goals = ""; }
	$settings = array('media_buttons' => false, 'textarea_name' => 'my_options[textareafield]');
	?>
	<p><?php wp_editor( $goals, "goals", $settings ); ?></p>
	<?php

}
/******************************************
 * Create 'Learning from classroom instruction' area
 ******************************************/
function add_principedia_instr_box()
{
	global $post;
	$custom = get_post_custom( $post->ID );
	if(isset($custom["instruction"][0])) { $instruction = $custom["instruction"][0]; } else { $instruction = ""; }
	?>
	<p><?php wp_editor( $instruction, "instruction", $settings = array( 'tinymce' => true ) ); ?></p>
	<?php

}
/******************************************
 * Create 'Learning for and from assignments and assessments' area
 ******************************************/
function add_principedia_assig_box()
{
	global $post;
	$custom = get_post_custom( $post->ID );
	if(isset($custom["assignments"][0])) { $assignments = $custom["assignments"][0]; } else { $assignments = ""; }
	?>
	<p><?php wp_editor( $assignments, "assignments", $settings = array() ); ?></p>
	<?php
}
/******************************************
 * Create 'External Resources' area
 ******************************************/
function add_principedia_resou_box()
{
	global $post;
	$custom = get_post_custom( $post->ID );
	if(isset($custom["resources"][0])) { $resources = $custom["resources"][0]; } else { $resources = ""; }
	?>
	<p><?php wp_editor( $resources, "resources", $settings = array() ); ?></p>
	<?php
}
/******************************************
 * Create 'What students should know...' area
 ******************************************/
function add_principedia_shoul_box()
{
	global $post;
	$custom = get_post_custom( $post->ID );
	?>
	<p><?php wp_editor( $custom["shouldknow"][0], "shouldknow", $settings = array() ); ?></p>
	<?php
}




/**
 * Save custom field data when creating/updating posts
 */
function save_principedia_custom_fields(){
  global $post;

  if ( $post && isset($_POST['principedia_course']) )
  {

    // if a course page does not exist for this course ID, then create it.

    $courseid = $_POST['principedia_course'];
    if(!post_exists( $courseid )) {


	    $new_post = array(
		'post_title' => $courseid,
		'post_content' => '',
		'post_status' => 'publish',
		'post_date' => date('Y-m-d H:i:s'),
		'post_author' => '',
		'post_type' => 'course',
		'post_category' => array(0)
	    );
	    $post_id = wp_insert_post($new_post);
    }

    // END - if a course page does not exist for this course ID, then create it.

    update_post_meta($post->ID, "principedia_dept", @$_POST['principedia_dept']);
    update_post_meta($post->ID, "principedia_course", @$_POST['principedia_course']);
    update_post_meta($post->ID, "principedia_instructor", @$_POST['principedia_instructor']);
    update_post_meta($post->ID, "principedia_year", @$_POST['principedia_year']);
    update_post_meta($post->ID, "principedia_semester", @$_POST['principedia_semester']);

    update_post_meta($post->ID, "goals", @$_POST["goals"]);
    update_post_meta($post->ID, "instruction", @$_POST["instruction"]);
    update_post_meta($post->ID, "assignments", @$_POST["assignments"]);
    update_post_meta($post->ID, "resources", @$_POST["resources"]);
    update_post_meta($post->ID, "shouldknow", @$_POST["shouldknow"]);
  }
}
add_action( 'admin_init', 'add_principedia_meta_boxes' );
add_action( 'save_post', 'save_principedia_custom_fields' );









/******************** COURSE ANALYSIS COMMENT FORM *********************/

/****
*  Add a custom field to the comment form for courses analyses so that the user can
*  associated the comment with a particular section of the analysis (i.e. goals, resources, etc)
*  THIS NEEDS WORK
*   https://www.smashingmagazine.com/2012/05/adding-custom-fields-in-wordpress-comment-form/
*****/



function principedia_comment_form_default_fields () {
die('got here');
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );

    $fields[ 'section' ] = '<p class="comment-form-section">'.
      '<label for="section">' . __( 'Name' ) . '</label>'.
      ( $req ? '<span class="required">*</span>' : '' ).
      '<input id="author" name="section" type="text" value="'. esc_attr( $commenter['comment_author'] ) .
      '" size="30" tabindex="1"' . $aria_req . ' /></p>';

  return $fields;
}

add_filter('principedia_comment_form_default_fields', 'custom_fields');




function additional_fields () {
  echo '<p class="comment-form-title">'.
  '<label for="section">' . __( 'Section' ) . '</label>'.
  '<select id="section" name="section" tabindex="5">
     <option value="goals">Description of Course Goals and Curriculum</option>
     <option value="instruction">Learning From Classroom Instruction</option>
     <option value="assignments">Learning For and From Assignments</option>
     <option value="resources">External Resources</option>
     <option value="shouldknow">What Students Should Know About This Course For Purposes Of Course Selection</option>
   </select>
   </p>';
}

add_action( 'comment_form_logged_in_after', 'additional_fields' );
add_action( 'comment_form_after_fields', 'additional_fields' );



function save_comment_meta_data( $comment_id ) {
  if ( ( isset( $_POST['section'] ) ) && ( $_POST['section'] != '') )
  $section = wp_filter_nohtml_kses($_POST['section']);
  add_comment_meta( $comment_id, 'section', $section );

}


add_action( 'comment_post', 'save_comment_meta_data' );


