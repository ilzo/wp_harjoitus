<?php
add_action( 'after_setup_theme', 'mdb_setup' );

function mdb_setup() {
	
	add_theme_support( 'title-tag' );
    
    load_theme_textdomain( 'moviedb' );
    
    
    
    
	add_theme_support( 'custom-logo', array(
		'height'      => 500,
		'width'       => 500,
		'flex-height' => true,
	) );
    
    //remove_filter( 'the_content', 'wpautop' );
    
	add_theme_support( 'post-thumbnails' );
    //add_image_size( 'cover-thumb', 340, 500, true);
    
    
    
    /*
    add_image_size( 'cover-thumb-single-small', 480);
    add_image_size( 'cover-thumb-single', 680);
    */
    
    /*
    add_image_size( 'service-thumb-desktop', 1280);
    add_image_size( 'service-thumb-mobile', 460, 230, true);
    */
    
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
    
	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );
    
    /*
    add_theme_support( 'custom-background', array(
        'default-color'             => '',
        'default-image'             => '',
        'default-size'              => '',
        'default-repeat'            => 'no-repeat',
        'default-position-x'        => 'center',
        'default-position-y'        => 'center',
        'default-attachment'        => '',
        //'wp-head-callback'          => '_custom_background_cb',
        'admin-head-callback'       => '',
        'admin-preview-callback'    => ''
    ));
	*/
    
    /*
    if ( ! isset( $content_width ) ) {
        $content_width = 800;
    }
    */
         
}

add_action('init', 'mdb_review_init');

function mdb_review_init() {
    
    $labels = array(
        'name' => _x('Reviews', 'post type general name'),
        'singular_name' => _x('Review', 'post type singular name'),
        'add_new_item' => _x( 'Add new movie review', 'moviedb' ),
        'set_featured_image' => _x('Set cover image', 'moviedb')
    );

    register_post_type( 'mdb_review', array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'has_archive' => true,
        'menu_icon' => 'dashicons-video-alt',
        'supports' => array(
            'title',  
            'author', 
            'editor', 
            'thumbnail',  
            'comments'
        ),
        'register_meta_box_cb' => 'mdb_review_metaboxes',
        'rewrite' => array('slug' => 'reviews')
    ));
    
    $labels = array(
        'name' => _x('Genres', 'taxonomy general name'),
        'singular_name' => _x('Genre', 'taxonomy singular name'),
        'add_new_item' => _x( 'Add new genre', 'moviedb' ),
        'all_items' => _x( 'All genres', 'moviedb' ),
        'search_items' => _x( 'Search genres', 'moviedb' ),
    );
    
    register_taxonomy( 'mdb_genres', 'mdb_review', array(
        'labels' => $labels,
        'hierarchical' => true,  
        'query_var' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'capabilities' => array(
            'manage_terms',
            'edit_terms',
            'delete_terms',
            'assign_terms'
        ),
        'rewrite' => array('slug' => 'genres')
    ));
    
    // Better be safe than sorry when registering custom taxonomies for custom post types. 
    // Use register_taxonomy_for_object_type() right after the function to interconnect them. 
    // Else you could run into minetraps where the post type isn't attached inside filter callback that run during parse_request or pre_get_posts.
    // https://codex.wordpress.org/Function_Reference/register_taxonomy
    register_taxonomy_for_object_type( 'mdb_genres', 'mdb_review' );
    
}

// For theme development, rewrite rules should be flushed only when switching to current theme
add_action( 'after_switch_theme', 'mdb_rewrite_flush' );

function mdb_rewrite_flush() {
    mdb_review_init();
    flush_rewrite_rules();
}

function mdb_custom_logo() {
	
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}

}


add_action( 'init', 'mdb_register_navigation_menus' );

function mdb_register_navigation_menus() {
  register_nav_menu('top-menu', __( 'Top Menu', 'moviedb' ));
}

function load_scripts() {

    wp_register_script('bootstrap-js', get_template_directory_uri() .'/js/bootstrap.min.js', array('jquery'), '3.3.7', true);
    
    wp_register_script('simple-lightbox-js', get_template_directory_uri() .'/js/simpleLightbox.min.js', array('jquery'), '1.2.9', false);
    
    wp_register_script('app-js', get_template_directory_uri() .'/js/app.js', array('jquery', 'bootstrap-js'), '1.0.0', true);
    
    wp_register_script('contact-form-js', get_template_directory_uri() .'/js/contact-form.js', array('jquery'), '1.0.0', true);
    
    wp_enqueue_script( 'bootstrap-js' );
    
    wp_enqueue_script( 'app-js' );
    
    if(is_singular('mdb_review') || in_category('news')){
        wp_enqueue_script( 'simple-lightbox-js' );
    }
    
    /*
    if(is_home()){
        wp_enqueue_script( '' );
    }
    if(is_home() || is_page('eng')){
       wp_enqueue_script( '' );
    }
    if(is_home() || is_singular('mdb_review') || (is_singular() && in_category('blogi'))){
        wp_enqueue_script( '' );
        wp_localize_script('', 'WPURLS', array('theme_path' => get_stylesheet_directory_uri()));
    }
    */
    
    if(is_page('contact')) { 
        wp_enqueue_script( 'contact-form-js' );
    }

}

function mdb_styles() {
    wp_enqueue_style( 'bootstrap-css', get_stylesheet_directory_uri() . '/css/bootstrap.min.css');
    
    if(is_singular('mdb_review') || in_category('news')){
        wp_enqueue_style( 'simple-lightbox-css', get_stylesheet_directory_uri() . '/css/simpleLightbox.min.css');
    }
}

/*
function mdb_load_dashicons_front_end() {
    wp_enqueue_style( 'dashicons' );
}
*/

add_action( 'wp_enqueue_scripts', 'mdb_styles' );
add_action( 'wp_enqueue_scripts', 'load_scripts' );

//add_action( 'wp_enqueue_scripts', 'mdb_load_dashicons_front_end' );


/*

add_action('mdb_get_custom_header_image_id', 'mdb_output_custom_header_img_id');

function mdb_output_custom_header_img_id() {
    // Get the header image data    
    $data = get_object_vars(get_theme_mod('header_image_data'));
    //$data = get_theme_mod('header_image_data');
    $attachment_id = is_array($data) && isset($data['attachment_id']) ? $data['attachment_id'] : false;

    if($attachment_id) {
       echo esc_attr($attachment_id);
    }
    
}
*/

require_once( get_template_directory() . '/inc/wp-bootstrap-navwalker.php' );

function bootstrap_nav() {
	wp_nav_menu( array(
            'theme_location'    => 'top-menu',
            'depth'             => 2,
            'container'         => 'false',
            'menu_class'        => 'nav navbar-nav',
            'walker'            => new wp_bootstrap_navwalker(),
            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
            'search'            => get_search_form()
    ));
}


add_action( 'widgets_init', 'mdb_widgets_init' );

require_once( get_template_directory() . '/inc/mdb-latest-user-reviews-widget.php' );
require_once( get_template_directory() . '/inc/mdb-latest-news-widget.php' );

function mdb_widgets_init() {
    register_sidebar(array(
        'name' => __( 'Main Sidebar', 'moviedb' ),
        'id' => 'primary',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'moviedb' ),
        'before_widget' => '<div class="widget-container">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __( 'Social Sidebar', 'moviedb' ),
        'id' => 'social',
        'description' => __( 'Sidebar for social widgets. Sidebar is shown above footer at the bottom of page.', 'moviedb' ),
        'before_widget' => '<div class="widget-container">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_widget('MDB_Latest_User_Reviews_Widget');
    register_widget('MDB_Latest_News_Widget');
}




add_action('admin_head', 'admin_styles');

function admin_styles() {
  echo '<style>#mdb_rating_input_container{margin-top:20px;}#mdb_rating_input_container input:not(:first-child){margin-left:15px;}</style>';
}



function mdb_review_metaboxes( $post ) {
    add_meta_box(
        'movie_specs_meta_box', // (string) (required) HTML 'id' attribute of the edit screen section
        __( 'Specs', 'moviedb' ), // (string) (required) Title of the edit screen section, visible to user
        'print_movie_specs_meta_box', // (callback) (required) Function that prints out the HTML for the edit screen section. The function name as a string, or, within a class, an array to call one of the class's methods.
        'mdb_review', // (string) (required) The type of Write screen on which to show the edit screen section ('post', 'page', 'dashboard', 'link', 'attachment' or 'custom_post_type' where custom_post_type is the custom post type slug)
        'normal', // (string) (optional) The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side')
        'low' // (string) (optional) The priority within the context where the boxes should show ('high', 'core', 'default' or 'low')
    );
    
    add_meta_box(
        'movie_rating_meta_box',
        __( 'Rating', 'moviedb' ), 
        'print_movie_rating_meta_box', 
        'mdb_review', 
        'normal', 
        'low'
    );
    
}

function print_movie_specs_meta_box( $post, $metabox ) {
    
    /*
    wp_nonce_field( 'mdb_review_summary_meta_box', 'mdb_review_summary_meta_box_nonce' );
    $value = get_post_meta( $post->ID, '_movie_summary', true );
    echo '<textarea style="width:100%" id="movie_summary" name="movie_summary">' . esc_attr( $value ) . '</textarea>';
    */
    $post_id = $post->ID;
    $year = get_post_meta( $post_id, 'movie_year', true );
    $director = get_post_meta( $post_id, 'movie_director', true );
    $summary = get_post_meta( $post_id, 'movie_summary', true );
    $duration_h = get_post_meta( $post_id, 'movie_duration_hours', true );
    $duration_min = get_post_meta( $post_id, 'movie_duration_mins', true );
    $prequel = get_post_meta( $post_id, 'movie_prequel', true );
    $sequel = get_post_meta( $post_id, 'movie_sequel', true );
    
    ?>
    <!-- These hidden fields are a registry of metaboxes that need to be saved if you wanted to output multiple boxes. The current metabox ID is added to the array. -->
    <input type="hidden" name="meta_box_ids[]" value="<?php echo $metabox['id']; ?>" />
    <!-- http://codex.wordpress.org/Function_Reference/wp_nonce_field -->
    <?php wp_nonce_field( 'save_' . $metabox['id'], $metabox['id'] . '_nonce' ); ?>

    <!-- This is a sample of fields that are associated with the metabox. You will notice that get_post_meta is trying to get previously saved information associated with the metabox. -->
    <!-- http://codex.wordpress.org/Function_Reference/get_post_meta -->
    <table class="form-table">
    <tr><th><label for="movie_year"><?php _e( 'Release year', 'moviedb' ); ?></label></th>
    <td><input name="movie_year" type="text" id="movie_year" value="<?php echo esc_attr( $year ); ?>" class="regular-text"></td></tr>
    <tr><th><label for="movie_director"><?php _e( 'Director', 'moviedb' ); ?></label></th>
    <td><input name="movie_director" type="text" id="movie_director" value="<?php echo esc_attr( $director ); ?>" class="regular-text"></td></tr><tr><th><label for="movie_duration_hours"><?php _e( 'Duration', 'moviedb' ); ?></label></th>
    <td><input name="movie_duration_hours" type="text" id="movie_duration_hours" value="<?php echo esc_attr( $duration_h ); ?>" class="regular-text"><span>Hours</span></td><td><input name="movie_duration_mins" type="text" id="movie_duration_mins" value="<?php echo esc_attr( $duration_min ); ?>" class="regular-text"><span>Minutes</span></td></tr>
    <tr><th><label for="movie_prequel"><?php _e( 'Prequel ID', 'moviedb' ); ?></label></th><td><input name="movie_prequel" type="text" id="movie_prequel" value="<?php echo esc_attr( $prequel ); ?>" class="regular-text"></td></tr>
    <tr><th><label for="movie_sequel"><?php _e( 'Sequel ID', 'moviedb' ); ?></label></th><td><input name="movie_sequel" type="text" id="movie_sequel" value="<?php echo esc_attr( $sequel ); ?>" class="regular-text"></td></tr>
    <tr><th><label for="movie_summary"><?php _e( 'Summary', 'moviedb' ); ?></label></th><td><textarea style="width:100%" id="movie_summary" name="movie_summary"><?php echo esc_html( $summary ); ?></textarea></td></tr>
    </table>

    <!-- These hidden fields are a registry of fields that need to be saved for each metabox. The field names correspond to the field name output above. -->
    <input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="movie_year" />
    <input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="movie_director" />
    <input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="movie_duration_hours" />
    <input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="movie_duration_mins" />
    <input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="movie_prequel" />
    <input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="movie_sequel" />
    <input type="hidden" name="<?php echo $metabox['id']; ?>_fields[]" value="movie_summary" />
    
    <?php
    
    
    
}

function print_movie_rating_meta_box( $post ) {
    wp_nonce_field( 'mdb_movie_rating_meta_box', 'mdb_movie_rating_meta_box_nonce' );
    $value = get_post_meta( $post->ID, 'movie_rating', true ); 
    ?>
    <label><?php _e( 'Rate the movie', 'moviedb' ); ?></label>
    <br/>
    <div id="mdb_rating_input_container">
        <input type="radio" name="movie_rating" value="0" <?php checked( $value, '0' ); ?> >0
        <input type="radio" name="movie_rating" value="0.5" <?php checked( $value, '0.5' ); ?> >0.5
        <input type="radio" name="movie_rating" value="1" <?php checked( $value, '1' ); ?> >1
        <input type="radio" name="movie_rating" value="1.5" <?php checked( $value, '1.5' ); ?> >1.5
        <input type="radio" name="movie_rating" value="2" <?php checked( $value, '2' ); ?> >2
        <input type="radio" name="movie_rating" value="2.5" <?php checked( $value, '2.5' ); ?> >2.5
        <input type="radio" name="movie_rating" value="3" <?php checked( $value, '3' ); ?> >3
        <input type="radio" name="movie_rating" value="3.5" <?php checked( $value, '3.5' ); ?> >3.5
        <input type="radio" name="movie_rating" value="4" <?php checked( $value, '4' ); ?> >4
        <input type="radio" name="movie_rating" value="4.5" <?php checked( $value, '4.5' ); ?> >4.5
        <input type="radio" name="movie_rating" value="5" <?php checked( $value, '5' ); ?> >5
    </div>
    <?php
}

add_action( 'save_post', 'save_movie_specs_metabox' );

function save_movie_specs_metabox( $post_id ) {
    
    // Check if this information is being submitted by means of an autosave; if so, then do not process any of the following code
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){ return; }
    
    
    
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
        if ( !current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    }else{
        if ( !current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }
    

    // Determine if the postback contains any metaboxes that need to be saved
    if( empty( $_POST['meta_box_ids'] ) ){ return; }

    // Iterate through the registered metaboxes
    foreach( $_POST['meta_box_ids'] as $metabox_id ){
        // Verify the request to update this metabox
        if( ! wp_verify_nonce( $_POST[ $metabox_id . '_nonce' ], 'save_' . $metabox_id ) ){ continue; }

        // Determine if the metabox contains any fields that need to be saved
        if( count( $_POST[ $metabox_id . '_fields' ] ) == 0 ){ continue; }

        // Iterate through the registered fields        
        foreach( $_POST[ $metabox_id . '_fields' ] as $field_id ){
            // Update or create the submitted contents of the fiels as post meta data
            // http://codex.wordpress.org/Function_Reference/update_post_meta
            
            if('movie_prequel' == $field_id){
                update_post_meta($_POST[ $field_id ], 'movie_sequel', $post_id);
            }
            
            if('movie_sequel' == $field_id){
                update_post_meta($_POST[ $field_id ], 'movie_prequel', $post_id);
            }
            
            update_post_meta($post_id, $field_id, $_POST[ $field_id ]);
        }
    }

        
}



add_action( 'save_post', 'save_movie_rating_metabox' );

function save_movie_rating_metabox( $post_id ) {
    
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( !isset( $_POST['mdb_movie_rating_meta_box_nonce'] ) ) {
        return;
    }

    if ( !wp_verify_nonce( $_POST['mdb_movie_rating_meta_box_nonce'], 'mdb_movie_rating_meta_box' ) ) {
        return;
    }
    
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
        if ( !current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    }else{
        if ( !current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }
    
    if ( !isset( $_POST['movie_rating'] ) ) {
        return;
    }
    
    $is_valid_rating_value = false;
    
    switch ($_POST['movie_rating']) {
        case '0':
            $is_valid_rating_value = true;
            break;
        case '0.5':
            $is_valid_rating_value = true;
            break;
        case '1':
            $is_valid_rating_value = true;
            break;
        case '1.5':
            $is_valid_rating_value = true;
            break;
        case '2':
            $is_valid_rating_value = true;
            break;
        case '2.5':
            $is_valid_rating_value = true;
            break;
        case '3':
            $is_valid_rating_value = true;
            break;
        case '3.5':
            $is_valid_rating_value = true;
            break;
        case '4':
            $is_valid_rating_value = true;
            break;
        case '4.5':
            $is_valid_rating_value = true;
            break;
        case '5':
            $is_valid_rating_value = true;
            break;               
    }
    
    $rating_data = $is_valid_rating_value ? $_POST['movie_rating'] : '';

    update_post_meta( $post_id, 'movie_rating', $rating_data );
}



add_filter( 'manage_mdb_review_posts_columns', 'mdb_showid_add_id_column', 5 );
add_action( 'manage_mdb_review_posts_custom_column', 'mdb_showid_id_column_content', 5, 2 );


function mdb_showid_add_id_column( $columns ) {
   $columns['mdb_showid_id'] = 'ID';
   return $columns;
}

function mdb_showid_id_column_content( $column, $id ) {    
  if( 'mdb_showid_id' == $column ) {
    echo $id;
  }
}




add_action( 'save_post', 'mdb_upload_post_custom_image_sizes' );

/**
 * This function utilizes lazy image size function to generate additional custom image sizes for post featured image and all content images.
 * Image sizes are created only when editing service and blog posts, after saving the post. 
 *
 */
function mdb_upload_post_custom_image_sizes($post_id) {
	if(wp_is_post_revision($post_id))
		return;
    
	$type = get_post_type($post_id);
    $cat_name = '';
    $wp_term_obj = get_the_category($post_id);
    if ($wp_term_obj){
        $cat_name = $wp_term_obj[0]->name;
    }
    
    $thumb_id = get_post_thumbnail_id($post_id);
    if(!empty($thumb_id)){
        $thumb_srcset = wp_get_attachment_image_srcset($thumb_id, 'full');
        $thumb_sizes = explode( ", ", $thumb_srcset );
        $thumb_srcset_length = count($thumb_sizes);
        // Call lazy image size function if the image has only full and/or medium-large size uploaded
        if ($thumb_srcset_length < 3) {
            if($type == 'mdb_review') {
                lazy_image_size($thumb_id, 340, 500, true);
            }elseif($cat_name == 'News'){
                lazy_image_size($thumb_id, 1280, 9999, false);
            }

            lazy_image_size($thumb_id, 480, 9999, false);
            lazy_image_size($thumb_id, 680, 9999, false);
        }     
    }

    $post_images = mdb_get_post_images($post_id, $thumb_id);
    if(!empty($post_images)){
        foreach ($post_images as $image) {
            $srcset_length = count($image['sizes']);
            $img_id = $image['id'];
            if($srcset_length < 3){
                lazy_image_size($img_id, 480, 9999, false);
                lazy_image_size($img_id, 1280, 9999, false);
            } 
        }  
    }     
}

/**
 * Create an image with the desired size on-the-fly.
 *
 * This function will generate an image by temporarily registering an image size, generating the image (if necessary) and 
 * then removing the size so new images will not be created in that size. It's "lazy" because images are not generated until they are needed.
 *
 * https://wordpress.stackexchange.com/questions/181877/generate-thumbnails-only-for-featured-images
 * 
 * @param $image_id
 * @param $width
 * @param $height
 * @param $crop
 *
 */
function lazy_image_size($image_id, $width, $height, $crop) {
    // Temporarily create an image size
    $size_id = 'lazy_' . $width . 'x' .$height . '_' . ((string) $crop);
    add_image_size($size_id, $width, $height, $crop);

    /*
    $size_id = 'lazy_' . $width;
    add_image_size($size_id, $width);
    */
    
    // Get the attachment data
    $meta = wp_get_attachment_metadata($image_id);

    // If the size does not exist
    if(!isset($meta['sizes'][$size_id])) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $file = get_attached_file($image_id);
        $new_meta = wp_generate_attachment_metadata($image_id, $file);

        // Merge the sizes so we don't lose already generated sizes
        $new_meta['sizes'] = array_merge($meta['sizes'], $new_meta['sizes']);

        // Update the meta data
        wp_update_attachment_metadata($image_id, $new_meta);
    }

    // Remove the image size so new images won't be created in this size automatically
    remove_image_size($size_id);
}




/*
add_filter('intermediate_image_sizes_advanced', 'mdb_unset_service_image_sizes');
    
function mdb_unset_service_image_sizes($sizes) {
    $post_id = $_REQUEST['post_id'];
    $type = get_post_type($post_id);
    //$wp_term_obj = get_the_category($post_id)[0];
    //$cat_name = $wp_term_obj->name;
    if ($type !== 'mdb_review') { 
        unset($sizes['cover-thumb']);
        
    }
    return $sizes;       
}

*/

function mdb_get_post_images($id, $thumb_id, $size = 'full') {
  $images = array();
  $attachments = get_posts( array(
    'post_type' => 'attachment',
    'posts_per_page' => -1,
    'post_status' => 'any',
    'post_parent' => $id,
    'exclude' => $thumb_id)
  );
  /* Return array of all images */
  if ($attachments) {
    $i = 0;  
    foreach ($attachments as $attachment) {
      $attach_id = $attachment->ID;
      $img_srcset = wp_get_attachment_image_srcset($attach_id, $size);
      $sizes = explode( ", ", $img_srcset );
      $image['id'] = $attach_id;
      $image['sizes'] = $sizes;
      $images[$i] = $image;
      $i++;
    }
  }
 return $images;
}



add_action('mdb_get_movie_genres', 'movie_genres_output', 10, 1);

function movie_genres_output($post_id) {
    $taxonomy = 'mdb_genres';
    $post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'ids' ) );
    $separator = ', ';

    if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {

        $term_ids = implode( ',' , $post_terms );

        $terms = wp_list_categories( array(
            'title_li' => '',
            'style'    => 'none',
            'echo'     => false,
            'taxonomy' => $taxonomy,
            'include'  => $term_ids
        ) );

        $terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );

        // Display post categories.
        echo  $terms;
    }
}


add_filter('mdb_get_post_img_markup', 'mdb_post_img_markup_output', 10, 1);


/**
 *
 * Generate custom responsive image html-markup for any post attachment. 
 *
 */
function mdb_post_img_markup_output($attachment_id) {
    
    if( empty( $attachment_id) )
        return false;
    
    if( is_archive() ) {
        $img_src = wp_get_attachment_image_url($attachment_id, 'medium_large');
        $img_srcset = wp_get_attachment_image_srcset($attachment_id, 'medium_large');
        $img_sizes = wp_get_attachment_image_sizes($attachment_id, 'medium_large');
        
    }else{
        $img_src = wp_get_attachment_image_url($attachment_id, 'full');
        $img_srcset = wp_get_attachment_image_srcset($attachment_id, 'full');
        $img_sizes = wp_get_attachment_image_sizes($attachment_id, 'full');
    }
    
    $output = '<img src="'. esc_url($img_src) .'" srcset="'. esc_attr($img_srcset) .'" sizes="'. esc_attr($img_sizes) .'" />';
    return $output;
}


add_filter('post_gallery', 'mdb_review_gallery_output', 10, 2);

function mdb_review_gallery_output($string, $attr) {
    $output = '<div id="mdb-gallery" class="row">';
    $posts = get_posts(array('include' => $attr['ids'],'post_type' => 'attachment', 'order' => 'ASC'));
    $i = 1;
    foreach($posts as $imagePost) {
        $src = esc_url_raw( wp_get_attachment_image_url($imagePost->ID, 'full') );
        $output .= '<figure class="gallery-item col-xs-12 col-sm-6 col-md-4 col-lg-3">';
        $output .= '<a href="'.$src.'" class="thumbnail">';
        $output .= apply_filters( 'mdb_get_post_img_markup', $imagePost->ID);
        $output .= '</a>';
        $output .=  '</figure>';
        
        if($i % 2 === 0){
            $output .= '<div class="gallery-spacer-two-cols col-xs-12 col-sm-12 col-md-12"></div>';
        }
        
        if($i % 3 === 0){
            $output .= '<div class="gallery-spacer-three-cols col-xs-12 col-sm-12 col-md-12"></div>';
        }
        
        $i++;
    }
    $output .= '</div>';
    return $output;
}


add_filter( 'the_content', 'mdb_strip_content_gallery', 10 );

function mdb_strip_content_gallery( $content ) {
    if(is_singular('mdb_review')) {
        preg_match_all( '/'. get_shortcode_regex() .'/s', $content, $matches, PREG_SET_ORDER );
        if ( ! empty( $matches ) ) {
            foreach ( $matches as $shortcode ) {
                if ( 'gallery' === $shortcode[2] ) {
                    $pos = strpos( $content, $shortcode[0] );
                    if ($pos !== false)
                        return substr_replace( $content, '', $pos, strlen($shortcode[0]) );
                }
            }
        }
    }
    return $content;
}




/*
add_filter('the_content', 'strip_gallery');

function strip_gallery($content){
   
    preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches, PREG_SET_ORDER );

    if ( ! empty( $matches ) ) {
        foreach ( $matches as $shortcode ) {
            if ( 'gallery' === $shortcode[2] ) {
                $pos = strpos( $content, $shortcode[0] );
                if( false !== $pos ) {
                    return substr_replace( $content, '', $pos, strlen( $shortcode[0] ) );
                }
            }
        }
    }

    return $content;    
}
*/



/*
function  strip_shortcode_gallery( $content ) {
    preg_match_all( '/'. get_shortcode_regex() .'/s', $content, $matches, PREG_SET_ORDER );
    if ( ! empty( $matches ) ) {
        foreach ( $matches as $shortcode ) {
            if ( 'gallery' === $shortcode[2] ) {
                $pos = strpos( $content, $shortcode[0] );
                if ($pos !== false)
                    return substr_replace( $content, '', $pos, strlen($shortcode[0]) );
            }
        }
    }
    return $content;
}
*/

add_filter( 'excerpt_length', 'mdb_excerpt_length', 999 );

function mdb_excerpt_length( $length ) {
    if(is_front_page()){
      return 20;  
    }
	return 50;
}

add_filter( 'excerpt_more', 'mdb_excerpt_more' );

function mdb_excerpt_more( $more ) {
	return ' ...';
}

add_filter('mdb_get_movie_rating', 'mdb_movie_rating_output', 10, 1);

function mdb_movie_rating_output($post_id) {
    $rating = 0;
    if(in_array( 'movie_rating', get_post_custom_keys($post_id))) {
        $rating = get_post_meta( $post_id, 'movie_rating', true);
    }
    
    return $rating;
}


add_filter('mdb_get_movie_summary', 'mdb_movie_summary_output', 10, 1);

function mdb_movie_summary_output($post_id) {
    $summary = '';
    if(in_array( 'movie_summary', get_post_custom_keys($post_id))) {
        $summary = get_post_meta( $post_id, 'movie_summary', true);
    }
    
    return $summary;
}



add_filter( 'movie_specs', 'init_movie_specs_obj' ); 

function init_movie_specs_obj($post_id) {
    $specs_obj = '';
    if(is_singular('mdb_review')) {
        $year = '';
        $director = '';
        $hours = '';
        $mins = '';
        $prequel = '';
        $sequel = '';
        $duration = array();
        class MDB_Movie_Specs {
             public $year;
             public $director;
             public $duration;
             public $prequel;
             public $sequel;
             public $summary;
            
             public function __construct($year, $director, $duration, $prequel, $sequel, $summary) {
                 $this->year = $year;
                 $this->director = $director;
                 $this->duration = $duration;
                 $this->prequel = $prequel;
                 $this->sequel = $sequel;
                 $this->summary = $summary;
             }
            
            public function printRelatedMoviesMarkup() {
                $preq_id;
                $seq_id;
                
                if(is_numeric($this->prequel) && is_numeric($this->sequel)){
                    $preq_id = (int) $this->prequel;
                    $seq_id = (int) $this->sequel;
                    ?>
                    <tr>
                        <td>Prequel</td>
                        <td>
                            <a href="<?php echo esc_url( get_permalink( $preq_id ) ); ?>"><?php echo esc_html( get_the_title( $preq_id ) ); ?></a>
                        </td>
                    </tr>
                    <tr>
                        <td>Sequel</td>
                        <td>
                            <a href="<?php echo esc_url( get_permalink( $seq_id ) ); ?>"><?php echo esc_html( get_the_title( $seq_id ) ); ?></a>
                        </td>
                    </tr>
                    <?php
                }else if(!is_numeric($this->prequel) && is_numeric($this->sequel)){
                    $seq_id = (int) $this->sequel;
                    ?>
                    <tr>
                        <td>Sequel</td>
                        <td>
                            <a href="<?php echo esc_url( get_permalink( $seq_id ) ); ?>"><?php echo esc_html( get_the_title( $seq_id ) ); ?></a>
                        </td>
                    </tr>
                    <?php 
                }else if(is_numeric($this->prequel) && !is_numeric($this->sequel)){
                    $preq_id = (int) $this->prequel;
                    ?>
                    <tr>
                        <td>Prequel</td>
                        <td>
                            <a href="<?php echo esc_url( get_permalink( $preq_id ) ); ?>"><?php echo esc_html( get_the_title( $preq_id ) ); ?></a>
                        </td>
                    </tr>
                    <?php
                }
            }
            
         }
    
        if(in_array( 'movie_year', get_post_custom_keys($post_id))) {
            $year = get_post_meta( $post_id, 'movie_year', true);
        }
        
        if(in_array( 'movie_director', get_post_custom_keys($post_id))) {
            $director = get_post_meta( $post_id, 'movie_director', true);
        }
        
        if(in_array( 'movie_duration_hours', get_post_custom_keys($post_id))) {
            $hours = get_post_meta( $post_id, 'movie_duration_hours', true);
        }
        
        if(in_array( 'movie_duration_mins', get_post_custom_keys($post_id))) {
            $mins = get_post_meta( $post_id, 'movie_duration_mins', true);
        }
        
        if(in_array( 'movie_prequel', get_post_custom_keys($post_id))) {
            $prequel = get_post_meta( $post_id, 'movie_prequel', true);
        }
        
        if(in_array( 'movie_sequel', get_post_custom_keys($post_id))) {
            $sequel = get_post_meta( $post_id, 'movie_sequel', true);
        }

        $summary = apply_filters('mdb_get_movie_summary', $post_id);
        
        $duration['hours'] = $hours;
        $duration['mins'] = $mins;

        $specs_obj = new MDB_Movie_Specs($year, $director, $duration, $prequel, $sequel, $summary);
        
    }

    return $specs_obj;
}


/**
 *
 * Change query parameters so that search targets only movie reviews
 *
 */
add_action( 'pre_get_posts', function( $query ) {
    if( $query->is_main_query() && !is_admin() && $query->is_search() ) {
        $query->set('post_type', 'mdb_review');
    }
} );


add_filter('posts_where','mdb_search_where');
add_filter('posts_join', 'mdb_search_join');
add_filter('posts_groupby', 'mdb_search_groupby');

/**
 *
 * Include all custom taxonomies ( mdb_genres ) into custom post type ( mdb_reviews ) search
 * https://wordpress.stackexchange.com/questions/2623/include-custom-taxonomy-term-in-search
 *
 */
function mdb_search_where($where){
  global $wpdb;
  if (!is_admin() && is_search())
    $where .= "OR (t.name LIKE '%".get_search_query()."%' AND {$wpdb->posts}.post_status = 'publish')";
  return $where;
}

function mdb_search_join($join){
  global $wpdb;
  if (!is_admin() && is_search())
    $join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
  return $join;
}

function mdb_search_groupby($groupby){
  global $wpdb;

  // we need to group on post ID
  $groupby_id = "{$wpdb->posts}.ID";
  if(!is_search() || strpos($groupby, $groupby_id) !== false) return $groupby;

  // groupby was empty, use ours
  if(!strlen(trim($groupby))) return $groupby_id;

  // wasn't empty, append ours
  return $groupby.", ".$groupby_id;
}


/**
 * Halt the main query in the case of an empty search 
 */
add_filter( 'posts_search', function( $search, \WP_Query $q ) {
    if( ! is_admin() && empty( $search ) && $q->is_search() && $q->is_main_query() )
        $search .=" AND 0=1 ";

    return $search;
    
}, 10, 2 );



add_action( 'wp_head', 'mdb_generate_responsive_background_image_styles');

/**
*
* Generate responsive background image styles function -
* This function generates CSS media query breakpoints to serve different sized background images (460, 768, 1280 and full)
* based on the screen size of the client.
*
*/

function mdb_generate_responsive_background_image_styles() {
    if( in_category('news') ) {
        global $post;
        $image_id = get_post_thumbnail_id($post->ID); // set or grab your image id
        $img_srcset = wp_get_attachment_image_srcset( $image_id, 'full' );
        $sizes = explode( ", ", $img_srcset );
        asort($sizes, SORT_NATURAL | SORT_FLAG_CASE);
        $sizes = array_values($sizes);
        $css = '';
        $prev_size = '';
        foreach( $sizes as $size ) {
            // Split up the size string, into an array with [0]=>img_url, [1]=>size
            $split = explode( " ", $size );
            if( !isset( $split[0], $split[1] ) )
                continue;
            
            $background_css = '#single-post-header #single-thumb { background-image: url(' . esc_url( $split[0] ) . ') !important;}';
            
            // Grab the previous image size as the min-width and/or add the background css to the main css string
            if( !empty( $prev_size ) ) {
                $css .= '@media only screen and (min-width: ' . $prev_size . ') {';
                $css .= $background_css;
                $css .= "}\n";
            } else {
                $css .= $background_css;
            }
            // Set the current image size as the "previous image" size, for use with media queries
            $prev_size = str_replace( "w", "px", $split[1] );
        }
        // The final css, wrapped in a <style> tag
        $css = !empty( $css ) ? '<style type="text/css">' . $css . '</style>' : '';
        echo $css;
        
    }  
}




function mdb_pagination( $numpages = '', $pagerange = '', $paged = '' ) {

  if (empty($pagerange)) {
    $pagerange = 2;
  }

  /**
   * This first part of our function is a fallback
   * for custom pagination inside a regular loop that
   * uses the global $paged and global $wp_query variables.
   * 
   * It's good because we can now override default pagination
   * in our theme, and use this function in default queries
   * and custom queries.
   */
  global $paged;
  if (empty($paged)) {
    $paged = 1;
  }
  if ($numpages === '') {
    global $wp_query;
    $numpages = $wp_query->max_num_pages;
    if(!$numpages) {
        $numpages = 1;
    }
  }

  $pagination_args = array(
    'base'            => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
    'format'          => '/page/%#%',
    'total'           => $numpages,
    'current'         => $paged,
    'show_all'        => false,
    'end_size'        => 1,
    'mid_size'        => $pagerange,
    'prev_next'       => true,
    'prev_text'       => '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>',
    'next_text'       => '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>',
    'type'            => 'list',
    'add_args'        => false,
    'add_fragment'    => ''
  );

  $paginate_links = paginate_links($pagination_args);
    
  if ($paginate_links) {
    ?>
    <div class="pagination">
        <nav id='mdb-pagination'>
          <?php echo $paginate_links; ?>
        </nav>
    </div>
    <?php      
  }

}


add_action('mdb_get_comment_form', 'comment_form_output');

function comment_form_output() {
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    
    $fields = array(
            'author' => '<p class="comment-form-author"><label for="author">Name:</label>'
                        . ( $req ? '<span class="required">*</span>' : '' )
                        . '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] )
                        . '" size="30"' . $aria_req . ' />' 
                        . '</p>',
            'email' => '<p class="comment-form-email"><label for="email">Email:</label>'
                        . ( $req ? '<span class="required">*</span>' : '' )
                        . '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] )
                        . '" size="30"' . $aria_req . ' />'
                        . '</p>',
            'comment_field' => '<p class="comment-form-comment"><label for="comment">Comment:</label>'
                                . ( $req ? '<span class="required">*</span>' : '' )
                                . '<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">'
                                . '</textarea></p>'
            
        );
    
    
    $comment_form_args = array(
            'label_submit'      => __( 'Send', 'moviedb'),
            'format'            => 'html5',
            'fields'            => $fields,
            'comment_field'     => is_user_logged_in() ? '<p class="comment-form-comment"><label for="comment">Comment:</label>'
                                . ( $req ? '<span class="required">*</span>' : '' )
                                . '<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">'
                                . '</textarea></p>' : ''
        );
    

    comment_form($comment_form_args);
   
}


/**
 * This hook replaces the submission form with a custom one in your theme directory.
 * @return string
 */
add_filter( 'site-reviews/addon/views/file', function( $file, $view ) {
    $customFile = sprintf( '%s/site-reviews/submit-form.php', get_stylesheet_directory() );
    if( $view == 'submit/index' && file_exists( $customFile )) {
        return $customFile;
    }
    return $file;
}, 10, 2 );




/*
add_filter('mdb_get_latest_user_reviews', 'mdb_latest_user_reviews_output', 1);

function mdb_latest_user_reviews_output( $user_reviews ) {
    if(function_exists('glsr_get_reviews')){
        $user_reviews = glsr_get_reviews([
            "count"  => 3
        ]);
    }
    return $user_reviews;
}
*/


add_action('mdb_get_rating_stars', 'mdb_rating_stars_output', 1);

function mdb_rating_stars_output ( $rating ) {
    $rating = (int) $rating;
    ?>
    <span class="glsr-review-rating">
    <?php
    for($i = 1; $i < 6; $i++){
        if($i <= $rating){
        ?>
        <span class="glsr-star-full"></span>
        <?php
        }else{
        ?>
        <span class="glsr-star-empty"></span>
        <?php 
        }   
    }
    ?>
    </span>
    <?php 
}


add_action('mdb_get_user_reviews', 'mdb_user_reviews_output', 1);

function mdb_user_reviews_output( $post_id ) {
    $user_reviews = '';
    if(function_exists('glsr_get_reviews')){
        $user_reviews = glsr_get_reviews([
            'assigned_to'  => $post_id
        ]);
    }
    
    if(!empty($user_reviews)){
        foreach($user_reviews as $review){
        ?>
        <div class="glsr-review panel panel-primary">
            <p class="glsr-review-meta panel-heading">
                <?php do_action('mdb_get_rating_stars', $review->rating); ?>
                <span class="glsr-review-date"><?php echo $review->date; ?></span>
            </p>
            <div class="glsr-review-excerpt panel">
                <p>
                <?php
                $content_with_linebreaks = wpautop( $review->content, true );
                echo $content_with_linebreaks; 
                ?>
                </p>
            </div>
            <div class="single-review-author"><span class="en-dash">&ndash;</span><?php echo $review->author; ?></div>
        </div>
        <?php
        }
    }else{
    ?>
    <p><?php _e( 'No user reviews were found.' ); ?></p>
    <?php
    }
}


/*
add_filter( 'site-reviews/rendered/partial', function( $rendered ) {

    if(is_singular('mdb_review')){
        //$rendered = str_replace('class="glsr-reviews ', 'class="glsr-reviews row', $rendered);
        $rendered = str_replace('class="glsr-review">', 'class="glsr-review panel panel-primary">', $rendered);
        $rendered = str_replace('class="glsr-review-meta"', 'class="glsr-review-meta panel-heading"', $rendered);
        $rendered = str_replace('class="glsr-review-excerpt"', 'class="glsr-review-excerpt panel"', $rendered);  
    }
    
    return $rendered;
    
}, 10, 1 );

*/


/*
add_filter( 'site-reviews/rendered/partial', 'mdb_filter_user_reviews', 2); 



function mdb_filter_user_reviews ($rendered, $recent_user_reviews) {
    
    if(is_singular('mdb_review')){
        //$rendered = str_replace('class="glsr-reviews ', 'class="glsr-reviews row', $rendered);
        $rendered = str_replace('class="glsr-review">', 'class="glsr-review panel panel-primary">', $rendered);
        $rendered = str_replace('class="glsr-review-meta"', 'class="glsr-review-meta panel-heading"', $rendered);
        $rendered = str_replace('class="glsr-review-excerpt"', 'class="glsr-review-excerpt panel"', $rendered);  
    }elseif(is_home()){
        
        
    }
    
    return $rendered;
    
}
*/


/* -------------------------------------------------------- */
/* -------------------------------------------------------- */
/* --------- MDB THEME CUSTOMIZER SETTINGS START --------- */
/* -------------------------------------------------------- */
/* -------------------------------------------------------- */


add_action( 'customize_register', 'mdb_customize_register' );

function mdb_customize_register( $wp_customize ) {
    
    /* ----------------------------------- */
    /* ------------- SECTIONS ------------ */
    /* ----------------------------------- */
    
    /* ------ Site Background ------ */
    
    $wp_customize->add_section( 'mdb_background_section', array(
      'title' => __( 'Site background', 'moviedb' ),
      'capability' => 'edit_theme_options'
    ));
    
    
    /* ------ Contact Info ------ */
    
    $wp_customize->add_section( 'mdb_contact_section', array(
      'title' => __( 'Contact info', 'moviedb' ),
      'capability' => 'edit_theme_options'
    ));
    
    
    /* ------ Footer ------ */
    
    $wp_customize->add_section( 'mdb_footer_section', array(
      'title' => __( 'Footer content', 'moviedb' ),
      'capability' => 'edit_theme_options'
    ));
    

    /* ----------------------------------- */
    /* ------------- SETTINGS ------------ */
    /* ----------------------------------- */
    

    /* ------ Site Background ------ */
    
    $wp_customize->add_setting('mdb_background_img', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint'
    ));
    
    $wp_customize->add_setting('mdb_background_img_alt_text', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field'
    ));
    
    $wp_customize->add_setting('mdb_background_img_position_top', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'default' => '0',
            'sanitize_callback' => 'sanitize_text_field'
    ));
    
    $wp_customize->add_setting('mdb_background_img_position_right', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'default' => '0',
            'sanitize_callback' => 'sanitize_text_field'
    ));
    
    /*
    $wp_customize->add_setting('mdb_front_bg_img_position_y', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'default' => '50',
            'sanitize_callback' => 'absint'
    ));
    */
    
    
    
    
    /*
    
    $wp_customize->add_setting('mdb_bg_img_pos', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field'
    ));
    */
    
    
    /* ------ Contact Info ------ */
    
    
    $wp_customize->add_setting('mdb_contact_info_tel', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field'
    ));
    
    $wp_customize->add_setting('mdb_contact_info_email', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field'
    ));
    
    $wp_customize->add_setting('mdb_contact_form_shortcode', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field'
    ));
    
    
    /* ------ Footer ------ */
    
    $wp_customize->add_setting('mdb_footer_info', array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field'
    ));
    
    
    
    /* ----------------------------------- */
    /* ------------- CONTROLS ------------ */
    /* ----------------------------------- */
    
    
    /* ------ Front-Page Background Image ------ */
    
    /*
    
    $wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'mdb_site_bg_img', array(
        'section'     => 'mdb_site_bg_section',
        'label'       => __('Site background image', 'moviedb'),
        'description' => __('Insert the about us section header background image here.', 'moviedb'),
        'flex_width'  => false, 
        'flex_height' => false, 
        'width'       => 530,
        'height'      => 1000
    )));
    */
    
    
    $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'mdb_background_img', array(
        'label' => __('Site background image', 'moviedb'),
        'description' => __('Insert the site background image here.', 'moviedb'),
        'section' => 'mdb_background_section',
        'mime_type' => 'image'
    )));
    
    $wp_customize->add_control( 'mdb_background_img_alt_text', array(
        'label' => __( 'Background image alt text', 'moviedb'),
        'type' => 'text',
        'section' => 'mdb_background_section'
    ));
    
    $wp_customize->add_control( 'mdb_background_img_position_top', array(
        'label' => __( 'Background image top position', 'moviedb'),
        'description' => __('Insert the background image position top CSS value here.', 'moviedb'),
        'type' => 'text',
        'section' => 'mdb_background_section'
    ));
    
    $wp_customize->add_control( 'mdb_background_img_position_right', array(
        'label' => __( 'Background image right position', 'moviedb'),
        'description' => __('Insert the background image position right CSS value here.', 'moviedb'),
        'type' => 'text',
        'section' => 'mdb_background_section'
    ));
    
    /*
    $wp_customize->add_control( 'mdb_site_bg_img_position_x', array(
            'type' => 'range',
            'section' => 'mdb_site_bg_section',
            'label' => __( 'Site background image position', 'moviedb'),
            'description' => __( 'Adjust the background image horizontal position (default 50)', 'moviedb'),
            'input_attrs' => array(
            'min' => 0,
            'max' => 100,
            'step' => 1,
          )
    ));
    */
    
    /*
    $wp_customize->add_control( 'mdb_front_bg_img_position_y', array(
            'type' => 'range',
            'section' => 'mdb_front_bg_section',
            'label' => __( 'Front page background image position Y', 'moviedb'),
            'description' => __( 'Adjust the background image vertical position (default 50)', 'moviedb'),
            'input_attrs' => array(
            'min' => 0,
            'max' => 100,
            'step' => 1,
          ),
            'active_callback' => 'is_front_page'
    ));
    */
    
    
    /*
    $wp_customize->add_control( 'mdb_bg_img_pos', array(
        'label' => __( 'Background position', 'moviedb'),
        'description' => __('Adjust about us section background position. Use normal css units and values. The default is 50% 50%.', 'moviedb'),
        'type' => 'text',
        'section' => 'mdb_front_bg_section',
        'active_callback' => 'is_front_page'
    ));
    */
    
    
    /* ------ Contact Info ------ */
    
    $wp_customize->add_control( 'mdb_contact_info_tel', array(
        'label' => __( 'Phone', 'moviedb'),
        'type' => 'text',
        'section' => 'mdb_contact_section'
    ));
    
    $wp_customize->add_control( 'mdb_contact_info_email', array(
        'label' => __( 'Email', 'moviedb'),
        'type' => 'text',
        'section' => 'mdb_contact_section'
    ));
    
    $wp_customize->add_control( 'mdb_contact_form_shortcode', array(
        'label' => __( 'Contact form shortcode', 'moviedb'),
        'type' => 'text',
        'section' => 'mdb_contact_section'
    ));
    
    
    /* ------ Footer ------ */
    
    $wp_customize->add_control( 'mdb_footer_info', array(
        'label' => __( 'Footer info', 'moviedb'),
        'description' => __('Insert footer info here.', 'moviedb'),
        'type' => 'text',
        'section' => 'mdb_footer_section'
    ));
    
    
}


/* -------------------------------------------------------- */
/* -------------------------------------------------------- */
/* ---------- MDB THEME CUSTOMIZER SETTINGS END ----------- */
/* -------------------------------------------------------- */
/* -------------------------------------------------------- */


add_action( 'wp_head', 'mdb_site_background_styles');

function mdb_site_background_styles() {
    
        $site_bg_img = get_theme_mod('mdb_background_img');
    
        if(!empty($site_bg_img)){
            $css = array();
            $bg_img_pos_top = get_theme_mod('mdb_background_img_position_top');
            $bg_img_pos_right = get_theme_mod('mdb_background_img_position_right');
        
            if(!empty($bg_img_pos_top)){
                $css['#bg-img-container']['top'] = $bg_img_pos_top;
            }else{
                $css['#bg-img-container']['top'] =  "0";
            }

            if(!empty($bg_img_pos_right)){
                $css['#bg-img-container']['right'] = $bg_img_pos_right;
            }else{
                $css['#bg-img-container']['right'] =  "0";
            }
            
            $final_css = '<style type="text/css">';
            foreach ( $css as $style => $style_array ) {
                $final_css .= $style . '{';
                foreach ( $style_array as $property => $value ) {
                    $final_css .= $property . ':' . $value . ';';
                }
                $final_css .= '}';
            }
            
            $final_css .= '</style>';
            echo $final_css;
        }
    
}


add_action('mdb_get_background_image', 'mdb_background_image_output');

function mdb_background_image_output() {
    $site_bg_img = get_theme_mod('mdb_background_img');
    $src = wp_get_attachment_image_src($site_bg_img, 'full')[0];
    $alt = get_theme_mod('mdb_background_img_alt_text');
    $meta = wp_get_attachment_metadata( $site_bg_img );
    
    ob_start();
    require_once( get_template_directory() . '/template-parts/mdb-background-image.php' );
    $output = ob_get_clean();
    echo $output;
    
}



add_action('mdb_get_recent_reviews_home', 'mdb_reviews_home_page_output');

function mdb_reviews_home_page_output() {
    if(is_front_page()) {
        class MDB_Movie_Home {
             public $id;
             public $title;
             public $published;
             public $url;
             public function __construct($id, $title, $published, $url) {
                 $this->id = $id;
                 $this->title = $title;
                 $this->published = $published;
                 $this->url = $url;
             } 
         }
        
        $reviews = array();
        
        $mdb_reviews_query = new WP_Query( array( 'post_type' => 'mdb_review', 'order' => 'DESC', 'posts_per_page'=> 12) );
        $mdb_review_posts = $mdb_reviews_query->posts;
        
        
        
        $i = 0;
        foreach($mdb_review_posts as $post) { 
            //$this_review_thumb = esc_url(get_the_post_thumbnail_url($post->ID, 'cover-thumb'));
            $this_review_permalink = esc_url(get_permalink($post));
            $this_review_time = get_the_time( 'U', $post->ID );
            $published = human_time_diff( $this_review_time, current_time('timestamp') ) . ' ago';
            
            $this_review = new MDB_Movie_Home($post->ID, $post->post_title, $published, $this_review_permalink);
            $reviews[$i] = $this_review;
            $i++;
        }
        
        
        
        //print_r($mdb_review_posts);
        
        ob_start();
        require_once( get_template_directory() . '/template-parts/mdb-recent-reviews-home.php' );
        $output = ob_get_clean();
        echo $output;
        wp_reset_postdata();
        
    }   
}




/*
add_action( 'pre_get_posts', 'mdb_post_count_queries' );

function mdb_post_count_queries( $query ) {
  if (!is_admin() && $query->is_main_query()){
    if(is_page('reviews')){
       $query->set('posts_per_page', 1);
    }
  }
}
*/

add_action('mdb_get_contact_page_content', 'mdb_contact_page_content_output');

function mdb_contact_page_content_output() {
    if(is_page('contact')) {
        
        $contact_form_shortcode = get_theme_mod('mdb_contact_form_shortcode');
        $tel = get_theme_mod('mdb_contact_info_tel');
        $email = get_theme_mod('mdb_contact_info_email');
        
       
        
        ob_start();
        require_once( get_template_directory() . '/template-parts/mdb-contact-page-content.php' );
        $output = ob_get_clean();
        echo $output;
        
    }   
}



add_action('mdb_get_footer_content', 'mdb_footer_content_output');

function mdb_footer_content_output() {

        
        $footer_info = get_theme_mod('mdb_footer_info');
        
        
        //print_r($mdb_review_posts);
        
        ob_start();
        require_once( get_template_directory() . '/template-parts/mdb-footer-content.php' );
        $output = ob_get_clean();
        echo $output;
       
}




/*

add_action('mdb_get_recent_reviews_page', 'mdb_reviews_page_output');

function mdb_reviews_page_output() {
    if(is_page('reviews')) {
        class MDB_Movie {
            public $id;
            public $title;
            public $rating;
            public $summary;
            public $published;
            public $url;
            public function __construct($id, $args) {
                $this->id = $id;
                $this->title = $args['title'];
                $this->rating = $args['rating'];
                $this->summary = $args['summary'];
                $this->published = $args['published'];
                $this->url = $args['url'];
            } 
        }
        
        $reviews = array();
    
        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
        
        $mdb_reviews_query = new WP_Query( array( 'post_type' => 'mdb_review', 'order' => 'DESC', 'posts_per_page'=> 2, 'paged' => $paged) );
        
        $mdb_review_posts = $mdb_reviews_query->posts;
        
        $i = 0;
        foreach($mdb_review_posts as $post) { 
            
            $post_id = $post->ID;
            $this_review_permalink = esc_url(get_permalink($post));
            $published = get_the_date('d.m.Y', $post_id);
            
            $summary = '';
            $rating = 0;
            if(in_array( 'movie_rating', get_post_custom_keys($post_id))) {
                $rating = get_post_meta( $post_id, 'movie_rating', true);
            }
            
            if(in_array( 'movie_summary', get_post_custom_keys($post_id))) {
                $summary = get_post_meta( $post_id, 'movie_summary', true);
            }
            
            
            $args = array(
                'title' => $post->post_title,
                'rating' => $rating,
                'summary' => $summary, 
                'published' => $published,
                'url' => $this_review_permalink
            );
            
            
            $this_review = new MDB_Movie($post_id, $args);
            $reviews[$i] = $this_review;
            $i++;
        }
        
        
    $mdb_reviews_pagination = paginate_links( array(
        
            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
            'format'       => '/page/%#%',
            'total'        => $mdb_reviews_query->max_num_pages,
            'current'      => max( 1, $paged ),
            'show_all'     => false,
            'type'         => 'plain',
            'end_size'     => 1,
            'mid_size'     => 2,
            'prev_next'    => true,
            'prev_text'    => sprintf( '<i></i> %1$s', __( 'Newer Posts', 'moviedb' ) ),
            'next_text'    => sprintf( '%1$s <i></i>', __( 'Older Posts', 'moviedb' ) ),
            'add_args'     => false,
            'add_fragment' => '',
    ) );
        
    
        ob_start();
        require_once(get_template_directory() . '/template-parts/mdb-recent-reviews-page.php' );
        $output = ob_get_clean();
        echo $output;
        wp_reset_postdata();
        
    }   
}

*/