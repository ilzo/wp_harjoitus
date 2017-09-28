<?php
/**
 * Widget API: MDB_Latest_News_Widget class
 *
 * @package WordPress
 * @subpackage smoy
 * 
 */

/**
 * This class overrides the default Wordpress widget class WP_Widget_Recent_Posts. Use this class to modify the default functionality of 
 * recent posts widget.
 *
 */
class MDB_Latest_News_Widget extends WP_Widget {

	/**
	 * Sets up a new Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_latest_news',
			'description' => __( 'Custom widget to show latest news articles.', 'moviedb' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'latest-news', __( 'Latest News', 'moviedb' ), $widget_ops );
		$this->alt_option_name = 'widget_latest_news';
	}

	/**
	 * Outputs the content for the current Latest News widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Latest News widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Latest news' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 2;
		if ( ! $number )
			$number = 2;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		/**
		 * Filters the arguments for the Latest News widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the latest news.
		 */
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
            'post_type'           => 'post',
			'posts_per_page'      => $number,
            'category_name'       => 'news',
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		)));
        
        echo $args['before_widget']; 
        if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} 
        ?>

        <div id="news-widget-wrapper">
        <?php if ( $r->have_posts() ) : ?>
		<ul>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
            <li class="widget-item">
                <a class="widget-item-link" href="<?php echo esc_url( get_permalink() ); ?>">
                <div class="widget-item-header">
                    <h4 class="widget-item-title"><?php echo get_the_title(); ?></h4>
                    <?php if ( $show_date ) : ?>
                    <span class="widget-item-date"><?php echo get_the_date('d.m.Y'); ?></span>
                    <?php endif; ?>
                </div>
                <div class="widget-item-content"><?php echo wp_trim_words( get_the_excerpt(), 20, ' ...' ); ?></div>
                </a>
            </li>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
        </ul>
		<?php else: ?>
        <p><?php _e( 'No news post were found.' ); ?></p>    
        <?php endif; ?>
        </div>
        <?php echo $args['after_widget']; 
        
	}

	/**
	 * Handles updating the settings for the current Latest News widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		return $instance;
	}

	/**
	 * Outputs the settings form for the Latest News widget.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 2;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
        ?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of news posts to show:' ); ?></label>
		<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
        <?php
	}
}
