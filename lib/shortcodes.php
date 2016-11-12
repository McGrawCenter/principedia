<?php
/***********************************  SHORTCODES ************************************/


function insert_department_list() {

	$terms = get_terms( 'department' );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	    echo '<ul>';
	    foreach ( $terms as $term ) {
		echo '<li>' . $term->name . '</li>';
	    	    wp_reset_query();
		    $args = array('post_type' => 'principedia',
			'tax_query' => array(
			    array(
				'taxonomy' => 'department',
				'field' => 'slug',
				'terms' => $term->slug,
			    ),
			),
		     );

		     $loop = new WP_Query($args);
		     if($loop->have_posts()) {

			echo '<ul>';
			while($loop->have_posts()) : $loop->the_post();
			    echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
			endwhile;
			echo '</ul>';
		     }
	    }
	    echo '</ul>';
	}

}


add_shortcode( 'dept_list' , 'insert_department_list' );



/* *********************************************
*
********************************************* */

function insert_strategies_list() {

	require_once(ABSPATH . "wp-admin/includes/taxonomy.php");

	$parent_term = get_term_by( 'name', 'Learning Strategy', 'category' );
	$parent_id = $parent_term->term_id;

	$terms = get_term_children( $parent_id, 'category' );

	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	    echo '<ul>';
	    foreach ( $terms as $term_id ) {
		$term = get_term( $term_id, 'category' );

		echo '<li>' . $term->name . '</li>';
	    	    wp_reset_query();
		    $args = array('post_type' => 'strategy',
			'orderby' => 'title',
			'order'   => 'ASC',
			'tax_query' => array(
			    array(
				'taxonomy' => 'category',
				'field' => 'slug',
				'terms' => $term->name
			    ),
			),
		     );

		     $loop = new WP_Query($args);
		     if($loop->have_posts()) {

			echo '<ul>';
			while($loop->have_posts()) : $loop->the_post();
			    echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
			endwhile;
			echo '</ul>';
		     }
	    }
	    echo '</ul>';
	}

}


add_shortcode( 'strategy_list' , 'insert_strategies_list' );



/* *********************************************
*
********************************************* */


function insert_learningstrategy_link() {

return "This is an LSD";
}


add_shortcode( 'learningstrategy_link' , 'insert_learningstrategy_link' );



/* *********************************************
*  SHORTCODE TO INSERT SERIES OF DROPDOWNS TO VIEW COURSE ANALYSES
********************************************* */


function insert_course_analysis_nav() {


$html .= "<label for='selectcourse'>Select Department</label>";
$html .= "<select name='selectcourse'>";
$html .= "  <option></option>";

if($departments = get_terms('department')) {
  foreach($departments as $dept) {
    $html .= "  <option class='dept-choice' deptid='{$dept->term_id}'>{$dept->name}</option>";
  }
}
$html .= "</select>\n";

$html .= "<div id='course-choice-dropdown'></div>\n";
$html .= "<div id='results'></div>\n";


// based on the selection above another select dropdown is inserted by javascript

return $html;

}


add_shortcode( 'course_analysis_nav' , 'insert_course_analysis_nav' );



