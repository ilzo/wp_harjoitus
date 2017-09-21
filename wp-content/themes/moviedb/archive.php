<?php
/**
 * The template for displaying a list of recent movie review posts
 *
 * Template Name: Reviews
 *
 * @package WordPress
 * @subpackage moviedb
 * 
 */
if ( !defined('ABSPATH') ) {
    exit;
}
get_header('single'); 
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'post',
    'posts_per_page' => 10,
    'paged' => $paged
);
$mdb_query = new WP_Query( $args ); 
?>
<div id="primary" class="content-area">
<div id="main" class="site-main" role="main">
<div id="review-list-wrapper">
<?php if ( $mdb_query->have_posts() ) : ?>
<?php while ( $mdb_query->have_posts() ) : $mdb_query->the_post(); 
$post_id = get_the_ID();     
?>
<figure id="post-<?php echo $post_id ?>" class="post-list-item container-fluid">
<a class="post-link" href="<?php the_permalink(); ?>">
<div class="row">
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
        <div class="thumbnail">
            <?php echo get_the_post_thumbnail( $post_id, 'cover-thumb' ); ?>
        </div>
    </div>
    <div class="post-content-wrapper col-xs-12 col-sm-8 col-md-9 col-lg-9">
        <div class="post-list-item-header">
            <h3 class="post-title"><?php the_title(); ?></h3>
            <div class="post-published">
                <p><?php echo get_the_date('d.m.Y', $post_id) ?></p>
            </div>
        </div>
        <div class="post-list-item-content">
            <p><?php the_excerpt(); ?></p>
        </div>
    </div>  
</div>
</a>
</figure>
<?php endwhile; ?>   
<?php
if (function_exists(mdb_pagination)) {
    mdb_pagination($mdb_query->max_num_pages, '', $paged);
}
?>            
<?php wp_reset_postdata(); ?>
<?php else:  ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>  
</div>
</div>
</div>
<?php get_footer(); ?>