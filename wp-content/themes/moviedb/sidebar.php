<?php
/**
 * The primary sidebar. Contains latest user reviews and news articles widgets.
 *
 *
 * @package WordPress
 * @subpackage Smoy
 * 
 */
if ( is_active_sidebar( 'primary' ) ) : ?>
<div id="sidebar-primary" class="widget-area col-sm-12 col-md-3 col-lg-3" role="primary">
    <?php dynamic_sidebar( 'primary' ); ?>
</div>
<?php endif; ?>