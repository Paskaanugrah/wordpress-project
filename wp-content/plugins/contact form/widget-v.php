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
            // $id = rand(1,10);

            $testi = $wpdb->get_results(
              "SELECT testimonial FROM user_testimonial where id=6"
            );

            $title = apply_filters( 'widget_title', $instance[ 'title' ] );
            $blog_title = get_bloginfo( 'name' );
            $tagline = get_bloginfo( 'description' );
            echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; ?>
            
            echo $testi['testimonial'];
          
            <?php echo $args['after_widget'];
          }

          public function form( $instance ) {
            $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
            <p>
              <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
              <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
            </p><?php 
          }

          public function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
            return $instance;
          }
    }
?>