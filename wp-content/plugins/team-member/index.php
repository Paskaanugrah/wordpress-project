<?php
    /*
    Plugin Name: Team Members Plugin
    Plugin URI: www.nothing.com
    Description: Describe your team project.
    Version: 1.0
    Author: Paska a
    License: GPLv2
    */

    add_action( 'init', 'create_team_member' );

    function create_team_member() {
        register_post_type( 'team_members',
            array(
                'labels' => array(
                    'name' => 'Team Members',
                    'singular_name' => 'Team Member',
                    'add_new' => 'Add New',
                    'add_new_item' => 'Add New Team Member',
                    'edit' => 'Edit',
                    'edit_item' => 'Edit Team Member',
                    'new_item' => 'New Team Member',
                    'view' => 'View',
                    'view_item' => 'View Team Member',
                    'search_items' => 'Search Team Member',
                    'not_found' => 'No Team Member found',
                    'not_found_in_trash' => 'No Team Member found in Trash',
                    'parent' => 'Parent Team Member'
                ),
     
                'public' => true,
                'menu_position' => 100,
                'supports' => array( 'title', 'editor', 'comments', 'thumbnail' ),
                'taxonomies' => array( '' ),
                'menu_icon' => 'dashicons-groups',
                'has_archive' => true
            )
        );
    }

    add_action( 'admin_init', 'my_admin' );

    function my_admin() {
        add_meta_box( 
            'team_member_metabox',
            'Team Member Details',
            'display_team_member_metabox',
            'team_members',
            'normal', 
            'high'
        );
    }

    add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );

    function display_team_member_metabox( $team_member ) {

        wp_enqueue_media( $team_member );
        
        $upload_link = esc_url( get_upload_iframe_src( 'image', $team_member->ID ) );

        // Retrieve current data based on ID
        $position = esc_html( get_post_meta( $team_member->ID, 'position', true ) );
        $email = esc_html( get_post_meta( $team_member->ID, 'email', true ) );
        $phone = esc_html( get_post_meta( $team_member->ID, 'phone', true ) );
        $website = esc_html( get_post_meta( $team_member->ID, 'website', true ) );
        $image_id = esc_html( get_post_meta( $team_member->ID, 'image_id', true ) );

        $attach_image = wp_get_attachment_image_src ($image_id, 'medium');

        var_dump($attach_image);

        $you_have_img = is_array( $attach_image );

        var_dump($you_have_img);
        ?>

        <script type="text/javascript" src="img.js"></script>
        <div class="meta-box-id.postbox">
        <table>
            <tr>
                <td style="width: 100px">Position </td>
                <td><input type="text" size="80" name="team_member_position" value="<?php echo $position; ?>" /></td>
            </tr>
             <tr>
                <td>Email</td>
                <td><input type="email" size="80" name="team_member_email" value="<?php echo $email; ?>" /></td>
            </tr>
            <tr>
                <td>Phone</td>
                <td><input type="text" size="80" name="team_member_phone" value="<?php echo $phone; ?>" /></td>
            </tr>
            <tr>
                <td>Website</td>
                <td><input type="text" size="80" name="team_member_website" value="<?php echo $website; ?>" /></td>
            </tr>
            </table>
                <p>Image</p>
                <div class="custom-img-container">
                    <?php if ( $you_have_img ) : ?>
                        <img src="<?php echo $attach_image ?>" alt="" style="max-width:100%;" />
                    <?php endif; ?>
                </div>
                <!-- Your add & remove image links -->
                <p class="hide-if-no-js">
                    <a class="upload-custom-img <?php if ( $you_have_img  ) { echo 'hidden'; } ?>" 
                    href="<?php echo $upload_link ?>">
                        <?php _e('Set custom image') ?>
                    </a>
                    <a class="delete-custom-img <?php if ( ! $you_have_img  ) { echo 'hidden'; } ?>" 
                    href="#">
                        <?php _e('Remove this image') ?>
                    </a>
                </p>

                <!-- A hidden input to set and post the chosen image id -->
                <input class="custom-img-id" name="custom-img-id" type="hidden" value="<?php echo esc_attr( $image_id ); ?>" />
            </div>
        <?php
    }

    add_action( 'save_post', 'add_team_members_field', 10, 2 );

    function add_team_members_field( $team_member_id, $team_member ) {
        // Check post type for movie reviews
        if ( $team_member->post_type == 'team_members' ) {
            // Store data in post meta table if present in post data
            if ( !empty( $_POST['team_member_position'] ) ) {
                update_post_meta( $team_member_id, 'position', $_POST['team_member_position'] );
            }
            if ( !empty( $_POST['team_member_email'] ) ) {
                update_post_meta( $team_member_id, 'email', $_POST['team_member_email'] );
            }
            if ( !empty( $_POST['team_member_phone'] ) ) {
                update_post_meta( $team_member_id, 'phone', $_POST['team_member_phone'] );
            }
            if ( !empty( $_POST['team_member_website'] ) ) {
                update_post_meta( $team_member_id, 'website', $_POST['team_member_website'] );
            }
            if ( !empty( $_POST['team_member_image'] ) ) {
                update_post_meta( $team_member_id, 'image_id', $_POST['team_member_image'] );
            }
        }
    }

    function display_team_member( $team_member ) {
        ?>
        <div> <?php
            $position = esc_html( get_post_meta( $team_member->ID, 'position', true ) );
            $email = esc_html( get_post_meta( $team_member->ID, 'email', true ) );
            $phone = esc_html( get_post_meta( $team_member->ID, 'phone', true ) );
            $website = esc_html( get_post_meta( $team_member->ID, 'website', true ) );
        ?>
        <table>
            <tr>
                <td><?php echo esc_html( $position ) ?></td>
            </tr>
            <tr>
                <td><?php echo esc_html( $email ) ?></td>
            </tr>
            <tr>
                <td><?php echo esc_html( $phone ) ?></td>
            </tr>
            <tr>
                <td><?php echo esc_html( $website ) ?></td>
            </tr>
        </table>
        </div>
        <?php
    }

    function sc_team_members() {
        display_team_member();
    }

    add_shortcode('team_member', 'sc_team_members');
?>