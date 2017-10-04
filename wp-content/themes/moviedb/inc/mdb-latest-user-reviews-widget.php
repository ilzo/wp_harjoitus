<?php
/**
 * Widget API: MDB_Latest_User_Reviews_Widget class
 *
 * @package WordPress
 * @subpackage moviedb
 * 
 */
class MDB_Latest_User_Reviews_Widget extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_latest_user_reviews',
			'description' => __( 'Custom widget to show latest user reviews.', 'moviedb' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'latest-user-reviews', __( 'Latest user reviews', 'moviedb' ), $widget_ops );
		$this->alt_option_name = 'widget_latest_user_reviews';
	}

	
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Latest user reviews' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 3;
		if ( ! $number )
			$number = 3;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
        $user_reviews = '';
        
		if(function_exists('glsr_get_reviews')){
            $user_reviews = glsr_get_reviews([
                "count"  => $number
            ]);
        }
        
        echo $args['before_widget']; 
        if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} 
        ?>
		<div id="user-reviews-widget-wrapper">
            <ul>
        <?php if ( !empty($user_reviews) ) : ?>
        <?php foreach( $user_reviews as $review ) : ?>
            <?php $assigned_to = (int) $review->assigned_to; ?>
            <li class="widget-item">
                <a class="widget-item-link" href="<?php echo esc_url( get_permalink( $assigned_to ) ); ?>">
                <h4 class="widget-item-title"><?php echo get_the_title( $assigned_to ); ?></h4>
                <?php if ( $show_date ) : ?>
                    <?php $the_date = get_the_modified_date( 'd.m.Y', $review->ID ); ?>
                    <span class="widget-item-date"><?php echo $the_date; ?></span>
                <?php endif; ?>
                <div class="widget-item-rating">
                <?php do_action('mdb_get_rating_stars', $review->rating); ?>
                </div>
                <div class="widget-item-content"><p><?php echo wp_trim_words( $review->content, 30, ' ...' ); ?></p><div class="widget-item-author"><span class="en-dash">&ndash;</span><?php echo $review->author; ?></div></div>
                </a>
            </li>
        <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p><?php _e( 'No user reviews were found.' ); ?></p>
        <?php endif; ?>
		</div>
        <?php
        echo $args['after_widget'];
	}

	
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		return $instance;
	}

	
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 3;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
        ?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of reviews to show:' ); ?></label>
		<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>

        <p><input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" /><label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display review date?' ); ?></label></p>
        <?php
	}
}
