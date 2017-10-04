<div class="row row-eq-height">
<?php 
$i = 1; 
foreach($reviews as $review):
if(is_object($review)):  
?>  
<figure id="review-<?php echo $i; ?>" class="review-item col-xs-12 col-sm-6 col-md-4 col-lg-3">
    <a class="review-link thumbnail" href="<?php echo esc_attr($review->url); ?>">
        <?php echo get_the_post_thumbnail( $review->id, 'lazy_340x500_1' ); ?>
        <div class="review-content-wrapper">
            <div class="review-content">
                <h4 class="review-title"><?php echo $review->title; ?></h4>
            </div>
            <div class="review-published">
                <p><?php echo $review->published; ?></p>
            </div>
        </div>  
    </a>
</figure>     
<?php endif; ?> 
<?php $i++; endforeach; ?>
</div>