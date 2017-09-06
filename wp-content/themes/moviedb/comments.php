<?php
/**
 *
 * @package WordPress
 * @subpackage moviedb
 * @since 1.0
 * @version 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area container-fluid">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'avatar_size' => 100,
					'style'       => 'ol',
					'short_ping'  => true,
					'reply_text'  => /*twentyseventeen_get_svg( array( 'icon' => 'mail-reply' ) ) .*/ __( 'Reply', 'moviedb' ),
				) );
			?>
		</ol>

		<?php the_comments_pagination( array(
			'prev_text' => '<span class="screen-reader-text">' . __( 'Previous', 'moviedb' ) . '</span>',
			'next_text' => '<span class="screen-reader-text">' . __( 'Next', 'moviedb' ) . '</span>',
		) );

	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php _e( 'Comments are closed.', 'moviedb' ); ?></p>
	<?php
	endif;
	//do_action('mdb_get_comment_form');
    //ic_reviews();
    //comment_form();
    ?>
    <div class="row">
        <div id="review-summary-container" class="panel">
            <h3>User rating</h3>
            <?php echo do_shortcode('[site_reviews_summary assigned_to="post_id"]'); ?>
        </div>
    </div>
    
    <div class="row">
        <div id="review-summary-container" class="panel">
            <h3>User reviews</h3>
            <?php echo do_shortcode('[site_reviews assigned_to="post_id" hide="title"]');  ?>
        </div>
    </div>
    
    <div class="row">
        <?php echo do_shortcode('[site_reviews_form assign_to="post_id" hide="terms,title,email"]');  ?>
    </div>
    
</div><!-- #comments -->
