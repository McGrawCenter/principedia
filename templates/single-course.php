<?php
/**
 * The template for displaying course analyses
 */

$edit = true;

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
					echo "<div>Dept: ".$meta['principedia_dept'][0]."</div>";
					echo "<div>Instructor: ".$meta['principedia_instructor'][0]."</div>";
					echo "<div>Year: ".$meta['principedia_year'][0]."</div>";
					?>
				THIS IS A COURSE PAGE
				</header><!-- .entry-header -->

				<div class="entry-content">

<?php
	//IF EDIT VARIABLE ABOVE IS SET TO TRUE, CREATE AN EDIT FORM, OTHERWISE JUST PRINT OUT THE TEXT
?>

					<h3>Description of Course Goals and Curriculum</h3>
					<?php
					if($edit) { ?>
					   <textarea name='goals'id='goals'><?php echo do_shortcode($meta['goals'][0]); ?></textarea>
					<?php } 
					else {
					?>
					<?php echo do_shortcode($meta['goals'][0]); ?>
					<?php } ?>



					<h3>Learning From Classroom Instruction</h3>
					<?php echo do_shortcode($meta['instruction'][0]); ?>

					<h3>Learning For and From Assignments</h3>
					<?php echo do_shortcode($meta['assignments'][0]); ?>

					<h3>External Resources</h3>
					<?php echo do_shortcode($meta['resources'][0]); ?>

					<h3>What Students Should Know About This Course For Purposes Of Course Selection</h3>
					<?php echo do_shortcode($meta['shouldknow'][0]); ?>

				</div><!-- .entry-content -->


				<footer class="entry-footer">

				</footer><!-- .entry-footer -->

			</article><!-- #post-## -->
			<?php
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
