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
<div id="sidebar-primary" class="widget-area" role="primary">
    <?php dynamic_sidebar( 'primary' ); ?>
</div>
<?php endif; ?>