<?php
/*
	Plugin Name: Principedia This is the one
	Plugin URI:
	Description: Create an instance of Principedia
	Version: 1.0
	Author: Ben Johnston
*/



function principedia_scripts(){
    wp_register_script( 'principedia', plugin_dir_url( __FILE__ ) . 'js/principedia.js', array( 'jquery' ));
    wp_enqueue_script( 'principedia' );
}
add_action('wp_enqueue_scripts', 'principedia_scripts');




/****************************************************
* Add the custom types
****************************************************/

$dir = plugin_dir_path( __FILE__ );

include($dir.'lib/course_analysis_type.php');
include($dir.'lib/learning_strategy_type.php');
// not used:
//include($dir.'lib/course_type.php');
include($dir.'lib/shortcodes.php');


/************************** CREATE COURSE ANALYSIS AUTHORING PAGE *********************/

//https://wordpress.org/support/topic/how-do-i-create-a-new-page-with-the-plugin-im-building

function principedia_install () {

    global $wpdb;

    $create_ca_page = 'Create A Course Analysis Entry';
    $create_ca_page_slug = 'create-course-analysis';

    // the menu entry...
    //delete_option("my_plugin_page_title");
    //add_option("my_plugin_page_title", $the_page_title, '', 'yes');
    // the slug...
    //delete_option("my_plugin_page_name");
    //add_option("my_plugin_page_name", $the_page_name, '', 'yes');
    // the id...
    //delete_option("my_plugin_page_id");
    //add_option("my_plugin_page_id", '0', '', 'yes');

    $the_page = get_page_by_title( $create_ca_page );

    if ( ! $the_page ) {

        // Create post object
        $_p = array();
        $_p['post_title'] = $create_ca_page;
        $_p['post_content'] = "This text may be overridden by the plugin. You shouldn't edit it.";
        $_p['post_status'] = 'publish';
        $_p['post_type'] = 'page';
        $_p['comment_status'] = 'closed';
        $_p['ping_status'] = 'closed';
        $_p['post_category'] = array(1); // the default 'Uncatrgorised'

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











/************************** ADD BUTTON TO TINYMCE *******************************/


// https://www.gavick.com/blog/wordpress-tinymce-custom-buttons


function principedia_add_tinymce_plugin($plugin_array) {

    $plugin_array['principedia_tc_button'] = plugins_url( '/text-button.js', __FILE__ );
    return $plugin_array;
}




function principedia_register_my_tc_button($buttons) {
   array_push($buttons, "principedia_tc_button");
   return $buttons;
}



function principedia_add_my_tc_button() {
    global $typenow;

    // check user permissions
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
    return;
    }
    // verify the post type - only do this if the type is principedia

    if( ! in_array( $typenow, array( 'principedia' ) ) )
        return;
    // check if WYSIWYG is enabled
    if ( get_user_option('rich_editing') == 'true') {

        add_filter("mce_external_plugins", "principedia_add_tinymce_plugin");
        add_filter('mce_buttons', 'principedia_register_my_tc_button');
    }
}



add_action('admin_head', 'principedia_add_my_tc_button');







/*********************** POPUP WINDOW *****************************/

add_action( 'wp_ajax_principedia_insert_dialog', 'principedia_insert_gistpen_dialog' );

function principedia_insert_gistpen_dialog() {

            echo "<div>Provide a list of the learning strategies and allow user to select</div>";
	    die();

}

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



