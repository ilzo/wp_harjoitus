<div id="review-list-wrapper">
<?php $i = 0; $j = 1; $reviews_length = count($reviews);
foreach($reviews as $review):
if(is_object($review)):  
?>  
<figure id="review-<?php echo $j ?>" class="review-list-item container-fluid">
    <a class="review-link" href="<?php echo esc_attr($review->url); ?>">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                <div class="thumbnail">
                    <?php echo get_the_post_thumbnail( $review->id, 'cover-thumb' ); ?>
                </div>
            </div>
            <div class="review-content-wrapper col-xs-12 col-sm-8 col-md-9 col-lg-9">
                <div class="review-list-item-header">
                    <h3 class="review-title"><?php echo $review->title ?></h3>
                    <h3 class="rating-title"><span class="glyphicon glyphicon-star" aria-hidden="true"></span><?php echo $review->rating ?> / 5</h3>
                    <div class="review-published">
                        <p><?php echo $review->published ?></p>
                    </div>
                </div>
                <div class="review-list-item-content">
                    <p><?php echo $review->summary ?></p>
                </div>
                <div class="review-list-item-footer">
                    
                </div>
            </div>  
        </div>
    </a>
</figure>     
<?php endif; $i++; $j++; endforeach; ?>        
</div>
<div class="pagination">
    <?php 
    //do_action('mdb_get_archive_pagination', $mdb_reviews_query); 
    echo $mdb_reviews_pagination;
    
    
    
    ?>
</div>