<?php
/**
 * The sidebar containing the newsletter subscription widget
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
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