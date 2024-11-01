<?php
/*
Plugin Name: Widget Specific Posts
Description: The plugin widget Specific Posts. With this plugin you can put a post on widget.
Version: 1.0.0
Author: carlosramosweb
Author URI: https://criacaocriativa.com
Text Domain: widget-specific-posts
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/


// Register and load the widget
function wp_widget_specific_posts_load() {
    register_widget( 'wp_widget_specific_posts' );
}
add_action( 'widgets_init', 'wp_widget_specific_posts_load' );
 
// Creating the widget 
class wp_widget_specific_posts extends WP_Widget {
 
	function __construct() {
		parent::__construct( 'wp_widget_specific_posts', __('Widget Specific Posts', 'widget-specific-posts'),  
			// Widget description
			array( 'description' => __( 'The plugin widget Specific Posts.', 'widget-specific-posts' ), ) 
		);
	}
 
	// Creating widget front-end
	 
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$description_1 = $instance['description_1'];
		$post_number = $instance['post_number'];
		 
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
			
			// The Query
			query_posts('p='.$post_number.'&post_type=post&posts_per_page=1'); 
 
			// The Loop
			while ( have_posts() ) : the_post();
			?>
            <article id="post-87" class="is-loop post-87 post type-post status-publish format-standard has-post-thumbnail hentry">
                <figure class="entry-thumbnail"><?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?></figure>
                <header class="entry-header">
                    <h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
                    <div class="entry-meta"> <span class="entry-meta-item author"><span class="author"><a href="#"><?php the_author(); ?></a></span></span>
                    <span class="entry-meta-item posted-on"><time class="entry-date published updated"><a href="#"><?php the_time('j \d\e F \d\e Y') ?></a></time></span></div>
                    <!-- .entry-meta --> 
                </header>
                <!-- .entry-header -->
                <div class="entry-content">
                <?php 
				$get_the_content = get_the_content();
				echo substr($get_the_content, 0, 150)." ...";
				?></div>
                <!-- .entry-content -->
                
            </article>
            <?php
		endwhile;
 
		// Reset Query
		wp_reset_query();
		echo $args['after_widget'];
	}
         
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'Novo Título');
		}
		// Widget admin form
        if ($instance) $description_1 = esc_attr($instance['description_1']);
        if ($instance) $post_number = esc_attr($instance['post_number']);
		// Widget admin form
		?>

    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>">
            <?php _e( 'Title:', 'widget-specific-posts' ); ?>
        </label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        <br/><br />
        <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php _e( 'Post Specific (ID):', 'widget-specific-posts' );?> </label>
        <br />
        <input class="widefat" name="<?php echo $this->get_field_name('post_number'); ?>" id="<?php echo $this->get_field_id('post_number'); ?>" type="text" value="<?php echo $post_number; ?>">
        
    </p>
    <?php 
	}
     
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['post_number'] = $new_instance['post_number'];
		return $instance;
	}
} // Class wpb_widget ends here
