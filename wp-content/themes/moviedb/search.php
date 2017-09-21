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
global $wp_query;
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$found = $wp_query->found_posts;
?>
<div id="primary" class="content-area">
<div id="main" class="site-main" role="main">
<div id="review-list-wrapper">
<div class="container-fluid">
    <div id="search-results-title-container" class="row">
        <h3 class="search-results-title"><span id="results-number"><?php echo $found; ?></span><?php if($found === '1'){_e( 'Result for', 'locale' );}else{_e( 'Results for', 'locale' ); } ?>: "<?php the_search_query(); ?>"</h3>
    </div>
</div>
<?php 
if( have_posts() ): 
while( have_posts() ): the_post(); 
$post_id = get_the_ID();
$rating = apply_filters('mdb_get_movie_rating', $post_id);
$summary = apply_filters('mdb_get_movie_summary', $post_id);
?>    
<figure id="review-<?php echo $post_id ?>" class="review-list-item container-fluid">
    <a class="review-link" href="<?php the_permalink(); ?>">
    <div class="row">    
    <div class="review-content-wrapper col-xs-12 col-sm-7 col-md-8 col-lg-9">
        <div class="review-list-item-header">
            <h3 class="review-title"><?php the_title(); ?></h3>
            <h3 class="rating-title"><span class="glyphicon glyphicon-star" aria-hidden="true"></span><?php echo $rating ?> / 5</h3>
            <div class="review-published">
                <p><?php echo get_the_date('d.m.Y', $post_id) ?></p>
            </div>
        </div>
        <div class="review-list-item-content">
            <p><?php echo $summary ?></p>
        </div>
    </div>
    <div class="list-item-image-container col-xs-12 col-sm-5 col-md-4 col-lg-3">
        <div class="thumbnail">
            <?php echo get_the_post_thumbnail( $post_id, 'cover-thumb' ); ?>
        </div>
    </div>    
    </div>
    </a>
</figure>
<?php 
endwhile; 
if(function_exists('mdb_pagination')) {
    mdb_pagination($wp_query->max_num_pages, '', $paged);
}
?>            
<?php else: ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
</div>
</div>
</div>
<?php get_footer(); ?>