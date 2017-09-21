<?php
if ( !defined('ABSPATH') ) {
    exit;
}
get_header(); ?>
<?php get_sidebar(); ?>
<section id="latest-reviews" class="home-section container-fluid">
    <h1 class="front-section-title">Latest reviews</h1>
    <div id="reviews-wrapper">
    <?php do_action('mdb_get_recent_reviews_home'); ?>
    </div>
</section>

<section id="latest-news" class="home-section container-fluid">
    <h1 class="front-section-title">Latest news</h1>
</section>

<section id="social" class="home-section">
</section>

<?php get_footer(); ?>