<?php
/**
 * The template part for displaying single news articles
 *
 * @package WordPress
 * @subpackage moviedb
 *
 */
$post_id = get_the_ID();
/*
if(has_post_thumbnail()){
    $thumb_id = get_post_thumbnail_id($post_id);
    $post_thumb_markup = apply_filters( 'mdb_get_single_post_img_markup', $thumb_id);
}
*/

?>
<article id="post-<?php echo $post_id ?>" <?php post_class(); ?>>
    <div class="container-fluid">
        <header id="single-post-header">
            <div class="single-post-header-wrapper container-fluid">
                <div class="single-post-header-info-container row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php the_title( '<h1 id="post-title">', '</h1>' ); ?>
                    <p class="author-name">Posted by: <?php the_author_meta('display_name'); ?></p>
                    <p><?php echo get_the_date('d.m.Y'); ?></p>
                    <?php if(has_post_thumbnail()) : ?>
                    </div>
                </div>
                <div class="single-thumb-container row">
                    <div id="single-thumb"></div>
                </div>
                <?php endif; ?>
            </div>
        </header>
        <?php if (get_post_gallery()):
            echo get_post_gallery();
        endif; ?>
        <div class="row">
            <div class="col-md-12">
                <div id="single-content" class="panel">
                    <?php the_content();?>
                </div>
            </div>
        </div>
        <!--
        <div class="row">
            <div class="col-md-12">
                <footer class="single-footer">  
                </footer>
            </div>
        </div>
        -->
	</div>
</article>