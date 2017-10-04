<?php
/**
 * The social sidebar. Contains social media icon widget.
 *
 *
 * @package WordPress
 * @subpackage Smoy
 * 
 */
if ( is_active_sidebar( 'social' ) ) : ?>
<div id="sidebar-social" role="secondary">
    <?php dynamic_sidebar( 'social' ); ?>
</div>
<?php endif; ?>