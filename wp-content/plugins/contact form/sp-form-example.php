<?php
/*
Plugin Name: Example Contact Form Plugin
Plugin URI: http://example.com
Description: Simple non-bloated WordPress Contact Form
Version: 1.0
Author: Paska A
Author URI: http://fb.com
*/
    //
    // the plugin code will go here..
    //

    function html_form_code() {
        echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
        echo '<p>';
        echo 'Your Name (required) <br />';
        echo '<input type="text" name="cf-name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf-name"] ) ? esc_attr( $_POST["cf-name"] ) : '' ) . '" size="40" />';
        echo '</p>';
        echo '<p>';
        echo 'Your Email (required) <br />';
        echo '<input type="email" name="cf-email" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" size="40" />';
        echo '</p>';
        echo '<p>';
        echo 'Phone Number (required) <br />';
        echo '<input type="text" name="cf-phone" value="' . ( isset( $_POST["cf-phone"] ) ? esc_attr( $_POST["cf-phone"] ) : '' ) . '" size="40" />';
        echo '</p>';
        echo '<p>';
        echo 'Your Message (required) <br />';
        echo '<textarea rows="10" cols="35" name="cf-message">' . ( isset( $_POST["cf-message"] ) ? esc_attr( $_POST["cf-message"] ) : '' ) . '</textarea>';
        echo '</p>';
        echo '<p><input type="submit" name="cf-submitted" value="Send"/></p>';
        echo '</form>';
    }

    function input_data() {
        global $wpdb;

        // if the submit button is clicked, input the data
        if ( isset( $_POST['cf-submitted'] ) ) {
    
            // sanitize form values
            $name    = sanitize_text_field( $_POST["cf-name"] );
            $email   = sanitize_email( $_POST["cf-email"] );
            $phone = sanitize_text_field( $_POST["cf-phone"] );
            $message = esc_textarea( $_POST["cf-message"] );
    
            // get the blog administrator's email address
            // $to = get_option( 'admin_email' );
    
            // $headers = "From: $name <$email>" . "\r\n";
    
            // // If email has been process for sending, display a success message
            // if ( wp_mail( $to, $subject, $message, $headers ) ) {
            //     echo '<div>';
            //     echo '<p>Thanks for contacting me, expect a response soon.</p>';
            //     echo '</div>';
            // } else {
            //     echo 'An unexpected error occurred';
            // }
            
            if ( $wpdb->insert(
                'user_testimonial',
                array(
                    'name' => $name,
                    'email' => $email,
                    'phone_number' => $phone,
                    'testimonial' => $message
                )) == false ) {
                    echo 'error inserting data!';
                };
        }
    }

    function cf_shortcode() {
        ob_start();
        input_data();
        html_form_code();
    
        return ob_get_clean();
    }

    add_shortcode( 'sitepoint_contact_form', 'cf_shortcode' );

    echo '<style>';
    echo 'table {';
    echo '    border: 1px solid black;
        border-collapse: collapse;
    } </style>';

    add_action( 'admin_menu', 'my_admin_menu' );

    function my_admin_menu() {
        add_menu_page( 'Admin Dashboard', 'Admin', 'manage_options', 'myplugin/myplugin-admin-page.php', 'myplguin_admin_page', 'dashicons-admin-users', 10);
    }

    function myplguin_admin_page(){
        global $wpdb;

        echo '<div class="wrap">';
        echo '<h2>Welcome To Admin Dashboard</h2>';
        echo '</div>';

        $wpdb->show_errors(); 
        $datas = $wpdb->get_results( 
            "SELECT * FROM user_testimonial"
        );

        if (empty($datas)) {
            echo 'cannot get data';
            $wpdb->print_error();
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
                    $wpdb->show_errors;
                    $wpdb->print_error;
                };
            }
        }
?>