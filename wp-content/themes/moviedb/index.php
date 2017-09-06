<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package moviedb
 */
if ( !defined('ABSPATH') ) {
    exit;
}
get_header(); ?>
<section id="latest-reviews" class="home-section">
    <h1>Latest reviews</h1>
    <?php do_action('mdb_get_recent_reviews_home'); ?>
</section>

<section id="latest-news" class="home-section">
    <h1>Latest news</h1>
</section>

<section id="social" class="home-section">
</section>

<?php get_footer(); ?>