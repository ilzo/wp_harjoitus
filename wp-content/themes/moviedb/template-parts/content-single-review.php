<?php
/**
 * The template part for displaying single movie reviews
 *
 * @package WordPress
 * @subpackage moviedb
 *
 */
$post_id = get_the_ID();

$rating = apply_filters('mdb_get_movie_rating', $post_id);

$specs = apply_filters( 'movie_specs', $post_id);

?>
<article id="post-<?php echo $post_id ?>" <?php post_class(); ?>>
    <div class="container-fluid">
        <header class="single-review-header row">
            <div id="single-review-title" class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <?php the_title( '<h1 class="movie-title">', '</h1>' ); ?>
            </div>
            <div id="single-review-rating" class="col-xs-12 col-sm-12 col-md-3 col-lg-3"><h2 class="rating-title"><span class="glyphicon glyphicon-star" aria-hidden="true"></span><?php echo $rating; ?><span class="rating-slash">/</span>5</h2></div>
        </header>
        <div class="row">
            <?php if( has_post_thumbnail() ) : ?>
            <div class="cover-image-container col-sm-12 col-md-4 col-lg-3">
                <?php 
                $thumb_id = get_post_thumbnail_id($post_id);
                $cover_pic_markup = apply_filters( 'mdb_get_post_img_markup', $thumb_id);
                echo $cover_pic_markup; 
                ?>
            </div>
            <?php endif; ?>
            <div class="movie-specs-container col-sm-12 col-md-8 col-lg-9">
                <div class="panel">
                    <div class="panel-heading">
                        <h4>Specs</h4>
                    </div>
                    <table id="movie-specs" class="table">
                        <tr>
                            <td>Released</td>
                            <td><?php echo esc_html($specs->year); ?></td>
                        </tr>
                        <tr>
                            <td>Director</td>
                            <td><?php echo esc_html($specs->director); ?></td>
                        </tr>
                        <tr>
                            <td>Runtime</td>
                            <td>
                                <p><?php 
                                    $hours = $specs->duration['hours'];  
                                    if($hours): echo esc_html($hours); ?> hours 
                                    <?php endif; ?>
                                    <?php echo esc_html($specs->duration['mins']); ?> mins</p>
                            </td>
                        </tr>
                        <tr>
                            <td>Summary</td>
                            <td><?php echo esc_html($specs->summary); ?></td>
                        </tr>
                        <tr>
                            <td>Genres</td>
                            <td><?php do_action('mdb_get_movie_genres', $post_id);?></td>
                        </tr>
                        <?php $specs->printRelatedMoviesMarkup(); ?>
                    </table>
                </div>
            </div>
        </div>
        <?php if (get_post_gallery()):
            echo get_post_gallery();
        endif; ?>
        <div class="row">
            <div class="col-md-12">
                <div id="single-review-content">
                    <?php the_content();?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <footer class="single-review-footer">
                    <h4>Review written by</h4>
                    <div class="review-author"><h2 class="author-name"><?php the_author_meta('display_name'); ?></h2></div>
                </footer>
            </div>
        </div>
	</div>
</article>