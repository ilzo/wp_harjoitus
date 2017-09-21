<div class="row">
<?php $i = 0; $j = 1; $reviews_length = count($reviews);
foreach($reviews as $review):
if(is_object($review)):  
?>  
<figure id="review-<?php echo $j ?>" class="review-item col-sm-6 col-md-4 col-lg-3">
    <a class="review-link thumbnail" href="<?php echo esc_attr($review->url); ?>">
        <?php echo get_the_post_thumbnail( $review->id, 'cover-thumb' ); ?>
        <div class="review-content-wrapper">
            <div class="review-content">
                <h4 class="review-title"><?php echo $review->title ?></h4>
                <div class="review-published">
                    <p><?php echo $review->published ?></p>
                </div>
            </div>
        </div>  
    </a>
</figure>     
<?php endif; ?> 
<?php if(($j % 3 === 0) && ($reviews_length - $i > 1)): ?>
</div><div class="row">
<?php elseif($reviews_length - $i === 1): ?>    
</div>   
<?php endif; $i++; $j++; endforeach; ?>        