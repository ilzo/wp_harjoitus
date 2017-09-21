<?php
/**
 * Template for displaying search form
 *
 * @package WordPress
 * @subpackage moviedb
 * 
 */
?>
<form method="get" id="searchform" class="navbar-form navbar-right" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="form-group has-feedback">
    <input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search reviews', 'moviedb' ); ?>" required/><input type="submit" class="submit" id="search-submit" name="search-submit"  value="" />
    <i class="glyphicon glyphicon-search form-control-feedback"></i>
    </div>
</form>