<?php 
class Principedia_Widget extends WP_Widget {


	public function __construct() {
	    $widget_options = array( 
	      'classname' => 'principedia',
	      'description' => 'A dropdown list of course analyses available on the site.',
	    );
	    parent::__construct( 'principedia', 'Course Analysis Navigation', $widget_options );
	  }


	public function widget( $args, $instance ) {
	  $title = apply_filters( 'widget_title', $instance[ 'title' ] );
	  $blog_title = get_bloginfo( 'name' );
	  $tagline = get_bloginfo( 'description' );
	  echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title'];


	$html = "";
	$html .= "<select name='selectdept' id='selectdept'>";
	$html .= "  <option value='' disabled selected>Select Department</option>";

	if($departments = get_terms('department')) {
	  foreach($departments as $dept) {
	    $html .= "  <option class='dept-choice' deptid='{$dept->term_id}'>{$dept->name}</option>";
	  }
	}
	$html .= "</select>\n";

	$html .= "<div id='course-choice-dropdown'></div>\n";
	$html .= "<div id='learning_strategies_list'></div>\n";


	// based on the selection above another select dropdown is inserted by javascript

	echo $html;



 
	  echo $args['after_widget'];
	}

	public function form( $instance ) {
	  $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
	  <p>
	    <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
	    <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
	  </p><?php 
	}

	public function update( $new_instance, $old_instance ) {
	  $instance = $old_instance;
	  $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
	  return $instance;
	}



}
?>
