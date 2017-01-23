<?php
/**
 * The template for displaying course analyses
 */
if ( is_user_logged_in() ) {
    $editlink = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if(strstr('?',$editlink)) { $editlink .= "&edit"; }
    else { $editlink .= "?edit"; }
    $editlink =  '<a href="'.$editlink.'">Edit</a>';
}

if(isset($_GET['edit']) && is_user_logged_in()) { $edit = true; } else { $edit = false; }


get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();
			$meta = get_post_meta($post->ID);
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php
						if ( is_single() ) :
							the_title( '<h1 class="entry-title">', '</h1>' );
						else :
							the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
						endif;

					echo "<div>Course: ".$meta['principedia_course'][0]."</div>";
					echo "<div>Instructor: ".$meta['principedia_instructor'][0]."</div>";
					echo "<div>{$meta['principedia_semester'][0]} {$meta['principedia_year'][0]}</div>";
					?>
				</header><!-- .entry-header -->

				<div class="entry-content">
<?php
if(!$edit && is_user_logged_in()) { echo $editlink; }
if($edit && is_user_logged_in()) { echo "<form name='course_analysis_edit' method='POST'><input type='hidden' name='ca_id' value='".$post->ID."'/>"; }

// these are the settings for the wysiwyg editors on the page
$editor_settings = array(
    'tinymce'       => array(
        'setup' => 'function (ed) {
            tinymce.documentBaseURL = "' . get_site_url() . '";
        }',
    ),
    'quicktags'     => TRUE,
    'editor_class'  => 'frontend-article-editor',
    'textarea_rows' => 20,
    'media_buttons' => FALSE
);


?>

<?php
	//IF EDIT VARIABLE ABOVE IS SET TO TRUE, CREATE AN EDIT FORM, OTHERWISE JUST PRINT OUT THE TEXT
?>

					<h3>Description of Course Goals and Curriculum</h3>
					<?php
					if($edit) { 
					    wp_editor( do_shortcode($meta['goals'][0]), 'goals', $editor_settings );
					} 
					else {
					?>
					<?php echo do_shortcode($meta['goals'][0]); ?>
					<?php } ?>



						<?php
						if(!$edit) {
						   if($c = get_section_comments($post->ID,'section','goals')) { format_section_comments($c); }
						}
						?>





					<h3>Learning From Classroom Instruction</h3>
					<?php
					if($edit) { 
					    wp_editor( do_shortcode($meta['instruction'][0]), 'instruction', $editor_settings );
					} 
					else {
					?>
					<?php echo do_shortcode($meta['instruction'][0]); ?>
					<?php } ?>


						<?php 
						if(!$edit) {
						  if($c = get_section_comments($post->ID,'section','instruction')) { format_section_comments($c); }
						}
						?>




					<h3>Learning For and From Assignments</h3>
					<?php
					if($edit) { 
					    wp_editor( do_shortcode($meta['assignments'][0]), 'assignments', $editor_settings);
					} 
					else {
					?>
					<?php echo do_shortcode($meta['assignments'][0]); ?>
					<?php } ?>


						<?php
						if(!$edit) {
						  if($c = get_section_comments($post->ID,'section','assignments')) { format_section_comments($c); }
						}
						?>





					<h3>External Resources</h3>
					<?php
					if($edit) { 
					    wp_editor( do_shortcode($meta['resources'][0]), 'resources', $editor_settings );
					} 
					else {
					?>
					<?php echo do_shortcode($meta['resources'][0]); ?>
					<?php } ?>


						<?php
						if(!$edit) {
						  if($c = get_section_comments($post->ID,'section','resources')) { format_section_comments($c); }
						}
						?>



					<h3>What Students Should Know About This Course For Purposes Of Course Selection</h3>
					<?php
					if($edit) { 
					    wp_editor( do_shortcode($meta['shouldknow'][0]), 'shouldknow', $editor_settings);
					} 
					else {
					?>
					<?php echo do_shortcode($meta['shouldknow'][0]); ?>
					<?php } ?>

						<?php
						if(!$edit) {
						  if($c = get_section_comments($post->ID,'section','shouldknow')) { format_section_comments($c); }
						}
						?>

					<?php
					if($edit) { ?>
					<p>&nbsp;</p>
					   <input type="submit" value="Submit"/>
					<?php } ?>
			<?php
			if($edit && is_user_logged_in()) { echo "</form>"; }
			?>

				</div><!-- .entry-content -->


				<footer class="entry-footer">

				</footer><!-- .entry-footer -->

			</article><!-- #post-## -->
		<?php
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				//comments_template( );


		comment_form( array(
			'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h2>',
		) );


			endif;
		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
