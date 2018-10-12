<?php
    function testimonial() { 
      register_widget( 'testimonial_widget' );
    }
    add_action( 'widgets_init', 'testimonial' );

    class testimonial_widget extends WP_Widget {

        public function __construct() {
            $widget_options = array( 
              'classname' => 'testimonial_widget',
              'description' => 'This is an Testimonial Widget',
            );
            
            parent::__construct( 'testimonial_widget', 'Testimonial Widget', $widget_options );
          }

          public function widget( $args, $instance ) {
            global $wpdb;
            
            $blog_id = get_current_blog_id();

            $testi = $wpdb->get_row(
              "SELECT * FROM user_testimonial WHERE blog_id = $blog_id ORDER BY RAND() LIMIT 1"
            );

            $title = apply_filters( 'widget_title', $instance[ 'title' ] );

            echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title'];
            echo $testi->testimonial;
           
            echo $args['after_widget'];
          }

          public function form( $instance ) { 
            $title = ( ! empty( $instance['title'] ) ? $instance['title'] : 'Your title' ); ?>
           <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr( 'Title:'); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
           </p>
            <?php 
          }

          public function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance[ 'title' ] = ( !empty( strip_tags( $new_instance[ 'title' ] )) ? strip_tags( $new_instance[ 'title' ] ) : $old_instance['title'] ) ;
            return $instance;
          }
    }
?>