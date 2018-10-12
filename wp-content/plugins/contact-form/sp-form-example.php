<?php
/*
Plugin Name: Testimonial Form Plugin
Plugin URI: -
Description: Simple Testimonial Customer Form
Version: 1.0
Author: Paska A
Author URI: http://paskaaa.me
*/
    include 'widget-v.php';

    function html_form_code() {
        echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
        echo '<p>';
        echo 'Your Name (required) <br />';
        echo '<input type="text" name="cf-name" pattern="[a-zA-Z0-9 ]+" size="40"/>';
        echo '</p>';
        echo 'Your Email (required) <br />';
        echo '<input type="email" name="cf-email" size="40" />';
        echo '</p>';
        echo '<p>';
        echo 'Phone Number (required) <br />';
        echo '<input type="text" name="cf-phone" size="40" />';
        echo '</p>';
        echo '<p>';
        echo 'Your Message (required) <br />';
        echo '<textarea rows="10" cols="50" name="cf-message" ></textarea>';
        echo '</p>';
        echo '<p><input type="submit" name="cf-submitted" value="Send"/></p>';
        echo '</form>';
    }

    function input_data() {

        global $wpdb;

        $name = $email = $phone = $message = '';
        $errors = [];
        
        // if the submit button is clicked, input the data
        if ( isset( $_POST['cf-submitted'] ) ) {
            
            $blog_id = get_current_blog_id();
            $name = isset( $_POST["cf-name"] ) ? sanitize_text_field( $_POST["cf-name"] ) : null;
            $email = isset( $_POST["cf-email"] ) ? sanitize_text_field( $_POST["cf-email"] ) : null;
            $phone = isset( $_POST["cf-phone"] ) ? sanitize_text_field( $_POST["cf-phone"] ) : null;
            $message = isset( $_POST["cf-message"] ) ? sanitize_text_field( $_POST["cf-message"] ) : null;

            if (empty($_POST["cf-name"])) {
                $errors[] = "Name is required! <br>";
            }
            
            if (empty($_POST["cf-email"])) {
                $errors[] = "Email is required! <br>";
            } 

            if (empty($_POST["cf-phone"])) {
                $errors[] = "Phone number is required! <br>";
            } 

            if (empty($_POST["cf-message"])) {
                $errors[] = "Message is required! <br>";
            } 

            foreach ($errors as $error) {
                echo "<strong>" . $error . "</strong>";
                echo "<br>";
            }

            if( empty($errors) ) {
                if ( $wpdb->insert(
                    'user_testimonial',
                    array(
                        'name'         => $name,
                        'email'        => $email,
                        'phone_number' => $phone,
                        'testimonial'  => $message,
                        'blog_id'      => $blog_id
                    )) == false ) {
                        return 'Maaf, pesan anda tidak terkirim. Tolong ulangi lagi!';
                };
            }

        }
    }

    function cf_shortcode() {
        html_form_code();
        input_data();
    }

    // add shortcode Testimonial Form
    add_shortcode( 'testimonial_form', 'cf_shortcode' );

    // add Admin Menu
    add_action( 'admin_menu', 'my_admin_menu' );

    function my_admin_menu() {
        add_menu_page( 'Admin Dashboard', 'Admin', 'manage_options', 'myplugin-admin-page.php', 'myplguin_admin_page', 'dashicons-admin-users', 10);
    }

    function myplguin_admin_page() {
        global $wpdb;

        echo '<div class="wrap">';
        echo '<h2>Welcome To Admin Dashboard</h2>';
        echo '</div>';
        echo '<div class="wrap">';

        // Get the current blog id with wp function
        $blog_id = get_current_blog_id();

        $datas = $wpdb->get_results( 
            "SELECT * FROM user_testimonial WHERE blog_id = $blog_id"
        );

        if (empty($datas)) {
            return 'Cannot get data';
        }
        
        echo '<table style="width:90%">';
        echo '<tr>';
            echo "<th> No </th>";
            echo "<th> Nama </th>";
            echo "<th> Email </th>";
            echo "<th> Phone Number </th>";
            echo "<th> Testimonial </th>";
            echo "<th> Action </th>";
        echo '</tr>';

        $i = 1;
        foreach ( $datas as $data ) 
        {
            echo '<tr>';
            echo '<td> '. $i++ . ' </td>';
            echo "<td> $data->name </td>";
            echo "<td> $data->email </td>";
            echo "<td> $data->phone_number </td>";
            echo "<td> $data->testimonial </td>";
            echo '<td> 
                <a href="' . esc_url( $_SERVER['REQUEST_URI'] ). '&id='. $data->id . '&delete=active"> delete </a>
            </td>';
            echo '</tr>';
        }
        echo '</table>';

        if ( isset( $_GET['delete'] ) ) {
            global $wpdb;
            
            $id = $_GET["id"];
    
                if ( $delete = $wpdb->delete(
                    'user_testimonial',
                    array(
                        'id'        => $id,
                        'blog_id'   => $blog_id
                    )
                ) == false ) {
                    return 'Cannot delete data!';
                };
            }

            echo '</div>';
        }
?>