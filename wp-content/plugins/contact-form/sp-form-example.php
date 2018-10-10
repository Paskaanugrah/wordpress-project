<?php
/*
Plugin Name: Contact Form Plugin
Plugin URI: http://example.com
Description: Simple non-bloated WordPress Contact Form
Version: 1.0
Author: Paska A
Author URI: http://fb.com
*/
    //
    // the plugin code will go here..
    //
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
            if (empty($_POST["cf-name"])){
                $errors[] = "Name is required! <br>";
            } elseif( isset( $_POST['cf-name'])) {
                $name = sanitize_text_field( $_POST["cf-name"] );
            }
            
            if (empty($_POST["cf-email"])){
                $errors[] = " Email is required! <br>";
            } elseif( isset( $_POST['cf-email'])) {
                $email = sanitize_text_field( $_POST["cf-email"] );
            }

            if (empty($_POST["cf-phone"])){
                $errors[] = " Phone number is required! <br>";
            } elseif( isset( $_POST['cf-phone'])) {
                $phone = sanitize_text_field( $_POST["cf-phone"] );
            }

            if (empty($_POST["cf-message"])){
                $errors[] = " Message is required! <br>";
            } elseif( isset( $_POST['cf-message'])) {
                $message = sanitize_text_field( $_POST["cf-message"] );
            }
            
            foreach ($errors as $error) {
                echo $error;
                echo "<br>";
            }

            if( !empty($_POST['cf-name']) && !empty($_POST['cf-email']) && !empty($_POST['cf-phone']) && !empty($_POST['cf-message'])) {
                if ( $wpdb->insert(
                    'user_testimonial',
                    array(
                        'name' => $name,
                        'email' => $email,
                        'phone_number' => $phone,
                        'testimonial' => $message
                    )) == false ) {
                        echo 'Maaf, pesan anda tidak terkirim. Tolong ulangi lagi!';
                };
            }
        }
    }

    function cf_shortcode() {
        ob_start();
        html_form_code();
        input_data();
    
        return ob_get_clean();
    }

    add_shortcode( 'sitepoint_contact_form', 'cf_shortcode' );

    add_action( 'admin_menu', 'my_admin_menu' );

    function my_admin_menu() {
        add_menu_page( 'Admin Dashboard', 'Admin', 'manage_options', 'myplugin-admin-page.php', 'myplguin_admin_page', 'dashicons-admin-users', 10);
    }

    function myplguin_admin_page(){
        global $wpdb;

        echo '<div class="wrap">';
        echo '<h2>Welcome To Admin Dashboard</h2>';
        echo '</div>';
        echo '<div class="wrap">';

        $datas = $wpdb->get_results( 
            "SELECT * FROM user_testimonial"
        );

        if (empty($datas)) {
            return 'cannot get data';
        }
        
        echo '<table style="width:90%">';
        echo '<tr>';
            echo "<th> ID </th>";
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
        // echo '<input type="submit" class="button button-primary">';
        echo '</table>';

        if ( isset( $_GET['delete'] ) ) {
            global $wpdb;

            $id = $_GET["id"];
    
                if ( $delete = $wpdb->delete(
                    'user_testimonial',
                    array(
                        'id' => $id
                    )
                ) == false ) {
                    return 'Cannot delete data!';
                };
            }

            echo '</div>';
        }
?>