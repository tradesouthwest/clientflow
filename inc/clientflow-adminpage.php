<?php
// Clientflow 2017
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function clfl_add_admin_menu(  ) {

    add_submenu_page( 'tools.php', 'ClientFlow', 'ClientFlow', 'manage_options', 'clientflow', 'clfl_options_page' );

}
add_action( 'admin_menu', 'clfl_add_admin_menu' );

//settings and the two options for admin
function clfl_settings_init(  ) {

    register_setting( 'adminPage', 'clfl_settings' );

    add_settings_section(
        'clfl_adminPage_section',
        __( 'Settings for ClientFlow', 'clientflow' ),
        'clfl_settings_section_callback',
        'adminPage'
    );
    add_settings_field(
        'clfl_text_field_0',
        __( 'Email Address to Send Form Copy to', 'clientflow' ),
        'clfl_text_field_0_render',
        'adminPage',
        'clfl_adminPage_section'
    );
    add_settings_field(
        'clfl_text_field_1',
        __( 'Title of Form', 'clientflow' ),
        'clfl_text_field_1_render',
        'adminPage',
        'clfl_adminPage_section'
    );
    add_settings_field(
        'clfl_webmail_from',
        __( 'Email Address to Show in From Field of Received Emails', 'clientflow' ),
        'clfl_webmail_from_render',
        'adminPage',
        'clfl_adminPage_section'
    );
    add_option('clfl_text_field_0', 'name@example.com', '', 'yes' );
    add_option('clfl_webmail_from', 'wordpress@example.com', '', 'yes' );
    add_option('clfl_text_field_1', 'Website Development Form', '', 'yes' );

}
add_action( 'admin_init', 'clfl_settings_init' );

//create fileds to admin
function clfl_text_field_0_render()
{
    $options = get_option( 'clfl_settings' );
    ?>
    <input type="email" name="clfl_settings[clfl_text_field_0]" value="<?php echo $options['clfl_text_field_0']; ?>">
    <?php
}
function clfl_webmail_from_render()
{
    $options = get_option( 'clfl_settings' );
    ?>
    <input type="email" name="clfl_settings[clfl_webmail_from]" value="<?php echo $options['clfl_webmail_from']; ?>">
    <?php
}
function clfl_text_field_1_render(  )
{
    $options = get_option( 'clfl_settings' );
    ?>
    <input type="text" name="clfl_settings[clfl_text_field_1]" value="<?php echo $options['clfl_text_field_1']; ?>">
    <?php
}

//render section
function clfl_settings_section_callback()
{
    $html = '<p>';
    $html .= __( 'Form has a required field for the email of the person filling out the form.', 'clientflow' );
    $html .= '<br>';
    $html .= __( 'This is where the original will be sent if the receiving server does not reject it.', 'clientflow' );
    $html .= '<br><em>';
    $html .= __( 'Live and Outlook are very prone to this issue.', 'clientflow' );
    $html .= '</em></p>';
    echo $html;
}

//create page
function clfl_options_page() {

    ?>
    <div class="wrap">
    <form action="options.php" method="post">

        <h2><img src="<?php echo plugins_url( 'assets/tswlogo.png', dirname( __FILE__ ) ); ?>"
                 alt="TSW" height="40" title="Website Development by Tradesouthwest" /> ClientFlow Options</h2>

        <?php
        settings_fields( 'adminPage' );
        do_settings_sections( 'adminPage' );
        submit_button();
        ?>

    </form>
    <p><?php esc_html_e( 'The shortcode to add inside of your post or page is: ',
		'clientflow' ); ?><code> [clientflow-form] </code></p>
	<p><em>ClientFlow Website Dev Form by Tradesouthwest =|=</em> Donate at <a href="http://tradesouthwest.com/paystation.php"
	title="Paypal the safe way to pay online" target="_blank">tradesouthwest.com/paystation</a> <small>(Opens in new window.)</small></p>
    </div><hr>
    <?php

}

//Safe way to get options inside of our mail routine.
function clfl_formsettings_formheader() {
    $option = get_option( 'clfl_settings' );
        return $option[clfl_text_field_1];
}
function clfl_formsettings_adminemail() {
    $option = get_option( 'clfl_settings' );
        return $option[clfl_text_field_0];
}

/**
 * custom post type to handle form retrieval
 * register_post_type( $post_type, $args )
 * @usage for hidden labels
 * $obj = get_post_type_object( 'your_post_type_name' );
 * echo esc_html( $obj->description );
 * Link: http://codex.wordpress.org/Function_Reference/register_post_type
 */
function clientflow_custom_post_type() {
$labels = array(
        'name'               => _x( 'Clients', 'post type general name', 'clientflow' ),
        'singular_name'      => _x( 'Client', 'post type singular name', 'clientflow' ),
        'menu_name'          => _x( 'Clients', 'admin menu',             'clientflow' ),
        'name_admin_bar'     => _x( 'Client', 'add new on admin bar',    'clientflow' ),
        'add_new'            => _x( 'Add New', 'clfl_client', 'clientflow' ),
        'add_new_item'       => __( 'Add New Client', 'clientflow' ),
        'new_item'           => __( 'New Client', 'clientflow' ),
        'edit_item'          => __( 'Edit Client', 'clientflow' ),
        'view_item'          => __( 'View Client', 'clientflow' ),
        'all_items'          => __( 'All Client', 'clientflow' ),
        'search_items'       => __( 'Search Client', 'clientflow' ),
        'parent_item_colon'  => __( 'Parent Client:', 'clientflow' ),
        'not_found'          => __( 'No Clients found.', 'clientflow' ),
        'not_found_in_trash' => __( 'No Clients found in Trash.', 'clientflow' )
    );
    $args = array(
      'labels'             => $labels,
        'description'        => __( 'Client Flow', 'clientflow' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'client' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail',
                                        'custom-fields', 'excerpt', 'comments' )
    );
    register_post_type( 'clfl_client', $args );
}
add_action( 'init', 'clientflow_custom_post_type', 0 );


//register_taxonomy( $taxonomy, $object_type, $args )
function clientflow_register_custom_taxonomies() {
      $labels = array(
        'name'                       => _x( 'taxonomies', 'Taxonomy General Name', 'clientflow' ),
        'singular_name'              => _x( 'taxonomy', 'Taxonomy Singular Name', 'clientflow' ),
        'menu_name'                  => __( 'Taxonomy', 'clientflow' ),
        'all_items'                  => __( 'All items', 'clientflow' ),
        'parent_item'                => __( 'Parent Item', 'clientflow' ),
        'parent_item_colon'          => __( 'Parent Item Colon:', 'clientflow' ),
        'new_item_name'              => __( 'New Item Name', 'clientflow' ),
        'add_new_item'               => __( 'Add New Item', 'clientflow' ),
        'edit_item'                  => __( 'Edit Item', 'clientflow' ),
        'update_item'                => __( 'Update Item', 'clientflow' ),
        'view_item'                  => __( 'View Item', 'clientflow' ),
        'separate_items_with_commas' => __( 'Separate Items With Commas', 'clientflow' ),
        'choose_from_most_used'      => __( 'Choose From Most Used', 'clientflow' ),
        'popular_items'              => __( 'Popular Items', 'clientflow' ),
        'search_items'               => __( 'Search Items', 'clientflow' ),
        'not_found'                  => __( 'Not Found', 'clientflow' ),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_in_menu'               => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_quick_edit'         => true,
    );

    register_taxonomy( 'taxonomy', array( 'clfl_client' ), $args );
}
add_action( 'init', 'clientflow_register_custom_taxonomies' );


//set wp_mail for HTML
if( ! function_exists( 'clientflow_set_html_mail_content_type' ) ) :
function clientflow_set_html_mail_content_type() {
    return 'text/html';
}
endif;

function clientflow_wp_mail_from( $original_email_address ) {
    $options = get_option( 'clfl_settings' );
    $admin_email = $options[clfl_text_field_0];
    //Make sure the email is from the same domain
    //as your website to avoid being marked as spam.
    return $admin_email;
}


//remove_action("wp_ajax_nopriv_clientflow_nonce_action", "clientflow_sendmail_formprocess");
//remove_action("wp_ajax_clientflow_nonce_action", "clientflow_sendmail_formprocess");
//remove_action( 'init', 'clientflow_sendmail_formprocess' );
function clientflow_sendmail_formprocess()
{
    if ( $_POST['action'] && $_POST['action'] == 'add_transfer' )
    {
    // ERROR or SUCCESS messages
    $notice = __( 'Would you please try again. There seems to be trouble with sending this form.', 'clientflow' );
    $message = __( 'Your requests went through.', 'clientflow' );

    $date_of = date('m-d-Y');
        $options = get_option( 'clfl_settings' );
        $admin_email = $options[clfl_text_field_0];
	$webmail_from = $options[clfl_webmail_from];

    /**Get the info from the form.
     * Reference order of fields as follows:
     * client_name-a, client_email-b, refers-7,  messagex-4, domainx-2, urls-5,  hosts-6,
     * timeframe-3, password-8, radio1-9-live-site, 10-new-site, radio2-11-no-theme, 12-have-theme,
     * themename-15, webtype-13, webcat-14, uiux-16, brand-17, custz-18, pages-19
     */
    if(trim($_POST['clfl_text_field_a']) === '') {
        $nameError = 'Please enter your name.';
        $hasError = true;
    } else {
        $clfl_text_field_a = trim($_POST['clfl_text_field_a']);
        }
    $clfl_text_field_b      = filter_var( $_POST['clfl_text_field_b'], FILTER_SANITIZE_EMAIL );
    $clfl_text_field_2      = sanitize_text_field( $_POST['clfl_text_field_2'] );
    $clfl_text_field_3      = sanitize_text_field( $_POST['clfl_text_field_3'] );
    $clfl_textarea_field_4  = sanitize_text_field( $_POST['clfl_textarea_field_4']);
    $clfl_text_field_5      = sanitize_text_field( $_POST['clfl_text_field_5'] );
    $clfl_text_field_6      = sanitize_text_field( $_POST['clfl_text_field_6'] );
    $clfl_text_field_7      = sanitize_text_field( $_POST['clfl_text_field_7'] );
    $clfl_text_field_8      = sanitize_text_field( $_POST['clfl_text_field_8'] );

    $clfl_radio_field_9     = sanitize_text_field( $_POST['clfl_radio_field_9'] );
    $clfl_radio_field_10    = sanitize_text_field( $_POST['clfl_radio_field_10'] );
    $clfl_radio_field_11    = sanitize_text_field( $_POST['clfl_radio_field_11'] );
    $clfl_radio_field_12    = sanitize_text_field( $_POST['clfl_radio_field_12'] );

    $clfl_select_field_13   = sanitize_text_field( $_POST['clfl_select_field_13'] );
    $clfl_select_field_14   = sanitize_text_field( $_POST['clfl_select_field_14'] );
    $clfl_text_field_15     = sanitize_text_field( $_POST['clfl_text_field_15'] );
    $clfl_text_field_16     = sanitize_text_field( $_POST['clfl_text_field_16'] );
    $clfl_text_field_17     = sanitize_text_field( $_POST['clfl_text_field_17'] );
    $clfl_text_field_18     = sanitize_text_field( $_POST['clfl_text_field_18'] );
    $clfl_text_field_19     = sanitize_text_field( $_POST['clfl_text_field_19'] );

    //add mail type and then change From: header
    add_filter( 'wp_mail_content_type', 'clientflow_set_html_mail_content_type' );
    add_filter( 'wp_mail_from', 'clientflow_wp_mail_from');
	    
       /** wp_mail
     * @param string|array $to Array or comma-separated list of email addresses to send message.
     * @param string $subject Email subject
     * @param string $message Message contents
     * @param string|array $headers Optional. Additional headers.
     * @param string|array $attachments Optional. Files to attach.
     * @return bool Whether the email contents were sent successfully.
     */

    $sendto = array( $clfl_text_field_b, $admin_email  );
    $headers = array(
    'Reply-To' => $admin_email . "<websiteform@fromus.net>",
    'From' => $webmail_from,
    'Cc' => $clfl_text_field_b . "<websiteform@fromyou.net>"
    );
    $sentSuccess =
        wp_mail(
            $sendto,
            "Request From $clfl_text_field_b",
            "This is the message from Website Project
    <br>
    <table><tbody>
    <tr>
    <td><span>name: </span> $clfl_text_field_a</td>
    <td><span>email: </span> $clfl_text_field_b</td>
    <td><span>domain: </span> $clfl_text_field_2 </td>
    <td><span>referred: </span>$clfl_text_field_7 </td></tr>
    <tr>
    <td colspan=\"4\">$clfl_textarea_field_4 </td></tr>
    <tr>
    <td><span>dev url </span>    $clfl_text_field_5 </td>
    <td><span>host </span>        $clfl_text_field_6  </td>
    <td><span>timeframe </span>    $clfl_text_field_3 </td>
    <td><span>visitor exper: </span>$clfl_text_field_16  </td></tr>
    <tr>
    <td><span>branding: </span>  $clfl_text_field_17 </td>
    <td><span>customize: </span>$clfl_text_field_18 </td>
    <td><span>pages: </span>   $clfl_text_field_19  </td>
    <td><span>type: </span>   $clfl_select_field_13</td></tr>
    <tr>
    <td><span>category: </span>   $clfl_select_field_14</td>
    <td><span>live or new: </span> $clfl_radio_field_9 $clfl_radio_field_10</td>
    <td>has theme?: $clfl_radio_field_11 $clfl_radio_field_12 </td>
    <td>theme:     $clfl_text_field_15</td></tr></tbody></table>
    <br>Date: $date_of",
            "$headers"
        );

        if ( $sentSuccess )
        {
        // wp_redirect( get_permalink( $post ) );
        ?>

        <div class="clflrow">
            <h2><?php _e('Your Information Was Sent Successfully. Please check your email', 'clientflow'); ?></h2>
            <div id="message" class="updated"><p><?php echo $message; ?></p></div>
        </div>

        <?php
        } else {
        ?>

        <div class="clflrow">
            <h2><?php _e('Your Information was invalid. Please re-validate.', 'clientflow' ); ?></h2>
            <div id="notice" class="error"><p><?php echo $notice; ?></p></div>
        </div>

        <?php
        }
    //if( $hasError == true )  echo esc_attr( $nameError $emailError );
    }
    // Reset content-type to avoid conflicts -- https://core.trac.wordpress.org/ticket/23578
    remove_filter( 'wp_mail_content_type', 'clientflow_set_html_mail_content_type' );
    remove_filter( 'wp_mail_from', 'clientflow_wp_mail_from' );
}

?>
