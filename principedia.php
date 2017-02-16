<?php
/*
	Plugin Name: Principedia v2
	Plugin URI:
	Description: Create an instance of Principedia
	Version: 1.0
	Author: Ben Johnston
*/



function principedia_scripts(){
    wp_register_script( 'principedia', plugin_dir_url( __FILE__ ) . 'js/principedia.js', array( 'jquery' ));
    wp_enqueue_script( 'principedia' );
    wp_enqueue_style( 'principedia-css', plugin_dir_url( __FILE__ ) . 'css/style.css' );

}
add_action('wp_enqueue_scripts', 'principedia_scripts');



/****************************************************
* Add the custom types
****************************************************/

$dir = plugin_dir_path( __FILE__ );


include($dir.'lib/course_analysis_type.php');

include($dir.'lib/learning_strategy_type.php');
include($dir.'lib/course_type.php');
include($dir.'lib/shortcodes.php');



/****************************************************
* Include class for custom widget and initalize
****************************************************/

function principedia_register_widget() { 
  register_widget( 'Principedia_Widget' );
}

include($dir.'widgets/course_analysis_nav.php');
add_action( 'widgets_init', 'principedia_register_widget' );




/****************************************************
* Add the custom types to the site search results
****************************************************/

function principedia_cpt_search( $query ) {
     
        if ( is_search() && $query->is_main_query() && $query->get( 's' ) ){
            $query->set('post_type', array('post', 'page', 'course', 'principedia', 'strategy'));
        }
        return $query;
    };
     
add_filter('pre_get_posts', 'principedia_cpt_search');



/************************** CREATE COURSE ANALYSIS AUTHORING PAGE *********************/

//https://wordpress.org/support/topic/how-do-i-create-a-new-page-with-the-plugin-im-building

function principedia_install () {

    global $wpdb;

    $create_ca_page = 'Sample Course Analysis';
    $create_ca_page_slug = 'sample-analysis';

    $the_page = get_page_by_title( $create_ca_page );

    if ( ! $the_page ) {

        // Create post object
        $_p = array();
        $_p['post_title'] = $create_ca_page;
        $_p['post_content'] = "This is a sample course anlysis";
        $_p['post_status'] = 'publish';
        $_p['post_type'] = 'page';
        $_p['comment_status'] = 'closed';
        $_p['ping_status'] = 'closed';
        $_p['post_category'] = array(1); // the default 'Uncategorised'

        // Insert the post into the database
        $the_page_id = wp_insert_post( $_p );

    }
    else {
        // the plugin may have been previously active and the page may just be trashed...

        $the_page_id = $the_page->ID;

        //make sure the page is not trashed...
        $the_page->post_status = 'publish';
        $the_page_id = wp_update_post( $the_page );

    }

    delete_option( 'my_plugin_page_id' );
    add_option( 'my_plugin_page_id', $the_page_id );


}

function principedia_remove () {

}



/* Runs when plugin is activated */
register_activation_hook(__FILE__,'principedia_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'principedia_remove' );








/************************** ADD BUTTON TO TINYMCE IN ADMIN AREA *******************************/
// https://www.gavick.com/blog/wordpress-tinymce-custom-buttons


function principedia_add_tinymce_plugin($plugin_array) {
    $plugin_array['principedia_tc_button'] = plugins_url( '/js/admin-strategy-button.js', __FILE__ );
    return $plugin_array;
}


function principedia_register_my_tc_button($buttons) {
   array_push($buttons, "principedia_tc_button");
   return $buttons;
}

function principedia_add_my_tc_button() {

    global $typenow;

    // check user permissions
    if (!current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
    return;
    }
    // verify the post type - only do this if the type is principedia and if 
    //user is in backend (is_admin just checks backend, not if user is actually admin)
    if( is_admin() ) { 
	if( !in_array( $typenow, array( 'principedia' ) ) ) {  return;  }
    }


    if ( get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "principedia_add_tinymce_plugin");
        add_filter('mce_buttons', 'principedia_register_my_tc_button');
    }
}

add_action('admin_head', 'principedia_add_my_tc_button');








/************************** ADD BUTTON TO TINYMCE IN FRONTEND COURSE ANALYSIS PAGES *******************************/
// https://www.gavick.com/blog/wordpress-tinymce-custom-buttons


function principedia_add_frontend_tinymce_plugin($plugin_array) {
    $plugin_array['principedia_tc_button'] = plugins_url( '/js/frontend-strategy-button.js', __FILE__ );
    return $plugin_array;
}


function principedia_register_frontend_button($buttons) {
   array_push($buttons, "principedia_tc_button");
   return $buttons;
}

function principedia_add_frontend_button() {

    global $typenow;

    // check user permissions
    if (!current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
    return;
    }

    // verify the post type - only do this if the type is principedia and if 
    // user is in backend (is_admin just checks backend, not if user is actually admin)
    if( is_admin() ) { 
	if( !in_array( $typenow, array( 'principedia' ) ) ) {  return;  }
    }


    if ( get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "principedia_add_frontend_tinymce_plugin");
        add_filter('mce_buttons', 'principedia_register_frontend_button');
    }
}



add_action('wp_head', 'principedia_add_frontend_button');








/*****************************************/
/*
function fb_change_mce_options($initArray) {

    // Comma separated string od extendes tags
    // Command separated string of extended elements
    $ext = 'pre[id|name|class|style]]';
    if ( isset( $initArray['extended_valid_elements'] ) ) {
        $initArray['extended_valid_elements'] .= ',' . $ext;
    } else {
        $initArray['extended_valid_elements'] = $ext;
    }
    // maybe; set tiny paramter verify_html
    //$initArray['verify_html'] = false;

    return $initArray;
}
add_filter( 'tiny_mce_before_init', 'fb_change_mce_options' );
*/



/*********************** POPUP WINDOW *****************************/



function principedia_insert_gistpen_dialog() {
	echo "<script>";
        echo "var args = top.tinymce.activeEditor.windowManager.getParams();\n";

	echo "jQuery('.strategy-link').click(function() { ";
	echo "  jQuery('.strategy-link').removeClass('selected');";
	echo "  jQuery(this).addClass('selected');";
/*
	echo " var target_id = jQuery(this).attr('rel');";
        echo " var markOpen  = '<a href=\"#\" class=\"learning-strategy-link\" rel=\"'+target_id+'\">', markClose = '</a>', highlight = markOpen + args.editor.selection.getContent() + markClose;";
        echo " args.editor.focus();";
        echo " args.editor.selection.setContent( markOpen + args.editor.selection.getContent() + markClose ); ";
        echo " args.editor.windowManager.close(); ";
*/
	echo " });";

        echo "</script>";
        echo "<ul style='padding:20px;height:260px;width:450px;overflow-x:hidden;overflow-y:scroll;'>";
	$args =  array( 'numberposts'	=> -1,'post_type' => 'strategy', 'orderby' => 'title', 'sort_order' => 'desc');
	$strategies =  get_posts($args);
	foreach($strategies as $strategy) {
	   echo "<li><a href='#' class='strategy-link' rel='".$strategy->ID."' style='cursor:pointer'>".$strategy->post_title."</a></li>";
	}
        echo "</ul>";
   die();
}

add_action( 'wp_ajax_principedia_insert_dialog', 'principedia_insert_gistpen_dialog' );

/******************************
* Use custom template for course analysis pages
*
******************************/
function course_analysis_custom_post_type_template($single_template) {
     global $post;

     if ($post->post_type == 'principedia') {
          $single_template = dirname( __FILE__ ) . '/templates/course_analysis.php';
     }
     return $single_template;
}
add_filter( 'single_template', 'course_analysis_custom_post_type_template' );












function principedia_handle_form_post () {


/******************************
* Course analysis edit form submission
******************************/

if(isset($_POST['ca_id'])) {

    $meta = get_post_meta( $_POST['ca_id'] );

    update_post_meta($_POST['ca_id'], "goals", $_POST['goals']);
    update_post_meta($_POST['ca_id'], "instruction", $_POST['instruction']);
    update_post_meta($_POST['ca_id'], "assignments", $_POST['assignments']);
    update_post_meta($_POST['ca_id'], "resources", $_POST['resources']);
    update_post_meta($_POST['ca_id'], "shouldknow", $_POST['shouldknow']);

    $linkto = get_permalink($_POST['ca_id']);
    header('Location:'.$linkto);

  }




  /******************************
  * Course analysis create form submission
  ******************************/
  if( isset($_POST['course_title']) &&  isset($_POST['course_code']) &&  isset($_POST['semester']) &&  isset($_POST['department']) &&  isset($_POST['year']) &&  isset($_POST['instructor']) ) {

    if(is_user_logged_in()) {
	    $user = wp_get_current_user();

	    $post_id = wp_insert_post( array('author'=>$user->data->user_login, 'post_status'=>'publish',  'post_title'=> $_POST['course_title'],  'post_type'=>'principedia'));

	    update_post_meta($post_id, "principedia_course", 		$_POST['course_code']);
	    update_post_meta($post_id, "principedia_semester", 		$_POST['semester']);
	    update_post_meta($post_id, "principedia_year", 		$_POST['year']);
	    update_post_meta($post_id, "principedia_instructor", 	$_POST['instructor']);

	    add_post_meta($post_id, "goals", " ");
	    add_post_meta($post_id, "instruction", " ");
	    add_post_meta($post_id, "assignments", " ");
	    add_post_meta($post_id, "resources", " ");
	    add_post_meta($post_id, "shouldknow", " ");

	    // create course post if necessary and assign department category
	    // if a course page does not exist for this course ID, then create it.

	    $courseid = $_POST['course_code'];
	    $course_exists = get_page_by_title($courseid, OBJECT, 'course');

	    if(!$course_exists) {

		    $new_post = array(
			'post_title' => $courseid,
			'post_content' => '',
			'post_status' => 'publish',
			'post_date' => date('Y-m-d H:i:s'),
			'post_author' => '',
			'post_type' => 'course',
			'post_category' => array(0)
		    );



		    $course_post_id = wp_insert_post($new_post);

		    wp_set_object_terms( $course_post_id, $_POST['department'], 'department' );
	    }

	    // END - if a course page does not exist for this course ID, then create it.


	    $linkto = get_permalink($post_id);

	    header('Location: '.$linkto);
	    die();
    } // end if logged in
    else { 
	    header('Location: index.php');
	    die();
    }
  }
}

add_action('init', 'principedia_handle_form_post');









/******************************
* Get a list of comments with a specific meta value
*
******************************/


function get_section_comments($post_id, $meta_name, $meta_value) {


	$returnArr = array();
	$args = array('post_id' => $post_id);
	$comments = get_comments($args);


	foreach($comments as $comment) {
	  $section_meta_value = get_comment_meta( $comment->comment_ID, $meta_name);
	  if(isset($section_meta_value[0]) && $section_meta_value[0] == $meta_value) { $returnArr[] = $comment; }
	}

	return $returnArr;
}


// formatting the comments attached to individual sections
// this is not the best way to do this. Need to figure out how to use a custom template instead
function format_section_comments($section, $comments) {
	$html = "<div class='section-comments'>";
	$html .= "<div><a href='#' class='show-comments' rel='{$section}'>COMMENTS</a></div>";
	$html .= "  <div class='comments-list comments-list-{$section}'>";
	foreach($comments as $comment) {
	if($comment->comment_approved == 1) {
	  $html .= "    <div><strong>{$comment->comment_author}</strong> </div>";
	  $html .= "    <div>{$comment->comment_date}</div>";
	  $html .= "    <div>{$comment->comment_content}</div>";
	}
	}
	$html .= "  </div>";
	$html .= "</div>";
  echo $html;
}



