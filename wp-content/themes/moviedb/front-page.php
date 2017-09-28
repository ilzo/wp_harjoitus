<?php
if ( !defined('ABSPATH') ) {
    exit;
}
get_header(); ?>
<div class="row">
<section id="latest-reviews" class="home-section col-sm-12 col-md-8 col-lg-8 container-fluid">
    <h1 class="front-section-title">Latest reviews</h1>
    <div id="reviews-wrapper">
    <?php do_action('mdb_get_recent_reviews_home'); ?>
    </div>
</section>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>