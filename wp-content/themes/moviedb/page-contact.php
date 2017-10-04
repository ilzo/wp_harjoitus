<?php
/**
 * The template for displaying a list of recent movie review posts
 *
 * Template Name: Contact
 *
 * @package WordPress
 * @subpackage moviedb
 * 
 */
if ( !defined('ABSPATH') ) {
    exit;
}
get_header('single'); ?>
<div id="primary" class="content-area">
	<div id="main" class="site-main" role="main">
		<?php do_action('mdb_get_contact_page_content'); ?>
	</div>
</div>
<?php get_footer(); ?>