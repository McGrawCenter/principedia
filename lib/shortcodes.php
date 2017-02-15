<?php
/***********************************  SHORTCODES ************************************/


function constructRegistrarCourseCode($year, $semester) {
  $year = substr($year, -2);
  switch($semester) {
    case 'S':
      $semester = "4";
    break;
    case 'SU':
      $semester = "1";
    break;
    default:
      $semester = "2";
    break;
  }
  return "1".$year.$semester;
}


/* *********************************************
*  Shortcode to insert a list of course analyses order by Department
********************************************* */


function insert_department_list() {

	// level 1 - list of departments
	$terms = get_terms( 'department' );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	    echo '<ul>';
	    foreach ( $terms as $term ) {
		echo '<li>' . $term->name . '</li>';


		    // level 2 - list of courses in that department

	    	    wp_reset_query();
		    $args = array('post_type' => 'course',
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
			    $post = get_post(get_the_ID());
			    echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';


		   		// level 3 - list of analyses for that course
				echo '<ul>';
				$args =  array( 'numberposts'	=> -1,'post_type' => 'principedia','meta_key' => 'principedia_course','meta_value' => $post->post_title );
				$analyses =  get_posts($args);
				foreach($analyses as $analysis) {
				   echo "<li><a href='{$analysis->guid}'>{$analysis->post_title}</a></li>";
				}
				echo '</ul>';

			endwhile;
			echo '</ul>';
		     }


	    }
	    echo '</ul>';
	}

}

add_shortcode( 'course_analysis_list' , 'insert_department_list' );





/* *********************************************
*  Shortcode to insert a list of course analyses order by Department and by Course
********************************************* */
/*

function insert_course_list() {

	$terms = get_terms( 'department' );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	    echo '<ul>';
	    foreach ( $terms as $term ) {
		echo '<li>' . $term->name . '</li>';


		   // second level
	    	    wp_reset_query();
		    $args = array('post_type' => 'course',
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
		    // end second level
	    }
	    echo '</ul>';
	}

}

add_shortcode( 'course_list' , 'insert_course_list' );
*/



/* *********************************************
*  Shortcode to insert a form for adding new course analysis from frontend
********************************************* */


function insert_new_course_analysis_form() {

  if(is_user_logged_in()) {

  echo "<form name='new_course_analysis' method='POST'>
    <p>
      <label for='course_title'>Course title</label>
      <input type='text' name='course_title' id='course_title' value='' placeholder='Introduction to Computer Science' onfocus='this.placeholder=\"\"'/>
    </p>
    <p>
      <label for='course_code'>Course code</label>
      <input type='text' name='course_code' id='course_code' value='' placeholder='COM101'  onfocus='this.placeholder=\"\"' />
    </p>
    <p>
      <label for='semester'>Semester</label>
      <select name='semester' id='semester'>
	<option value='F' >Fall</option>
	<option value='S' selected>Spring</option>
	<option value='SU' >Summer</option>
      </select>
    </p>
    <p>
      <label for='year'>Year</label>
      <input type='text' name='year' id='year' value='' />
    </p>
    <p>
      <label for='year'>Department</label>
      <input type='text' name='department' id='department' value='' placeholder='Computer Science'  onfocus='this.placeholder=\"\"'/>
    </p>

    <p>
      <label for='instructor'>Instructor</label>
      <input type='text' name='instructor' id='instructor' value='' />
    </p>
    <p>
      <input type='submit' value='Add Course Analysis'/>
    </p>
    </form>
  ";
  }
  else {
    echo "You must be logged in to create a course analysis";
  }

}

add_shortcode( 'new_course_analysis_form' , 'insert_new_course_analysis_form' );






/* *********************************************
*  Shortcode to insert a list of all the learning strategies
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
*  SHORTCODE TO INSERT SERIES OF DROPDOWNS TO VIEW COURSE ANALYSES
********************************************* */


function insert_course_analysis_nav() {

$html = "";
$html .= "<label for='selectdept' class='ca_dropdown_label'>Select Department</label> ";
$html .= "<select name='selectdept' id='selectdept'>";
$html .= "  <option></option>";

if($departments = get_terms('department')) {
  foreach($departments as $dept) {
    $html .= "  <option class='dept-choice' deptid='{$dept->term_id}'>{$dept->name}</option>";
  }
}
$html .= "</select>\n";

$html .= "<div id='course-choice-dropdown'></div>\n";
$html .= "<div id='learning_strategies_list'></div>\n";


// based on the selection above another select dropdown is inserted by javascript

return $html;

}


add_shortcode( 'course_analysis_select' , 'insert_course_analysis_nav' );



