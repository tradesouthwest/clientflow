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
        __( 'Email Address to Send Form Copy to.', 'clientflow' ),
        'clfl_text_field_0_render',
        'adminPage',
        'clfl_adminPage_section'
    );
    add_settings_field(
        'clfl_webmail_from',
        __( 'Email Address to Show in From Field of Received Emails.', 'clientflow' ),
        'clfl_webmail_from_render',
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
/*
function clfl_formsettings_formheader() {
    $option = get_option( 'clfl_settings' );
        return $option[clfl_text_field_1];
}
function clfl_formsettings_admin_email() {

    $option = get_option( 'clfl_settings' );
        return $option[clfl_text_field_0];
}
function clfl_formsettings_webmailfrom() {
    $option = get_option( 'clfl_settings' );
        return $option[clfl_webmail_from];
}
*/

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

//form processor
function clientflow_sendmail_formprocess()
{
    if ( $_POST['action'] && $_POST['action'] == 'add_transfer' )
    {
        $date_of = date('m-d-Y H:i:s');

        $options = get_option( 'clfl_settings' );
        //set string to options values
        $webmail_from = $options['clfl_webmail_from'];
        $clfl_admin_email = $options['clfl_text_field_0'];
        $clientflow_title = $options['clfl_text_field_1'];

    /**Get the info from the form.
     * Reference order of fields as follows:
     * client_name-a, client_email-b, refers-7,  messagex-4, domainx-2, urls-5,  hosts-6,
     * timeframe-3, password-8, radio1-9-live-site, 10-new-site, radio2-11-no-theme, 12-have-theme,
     * themename-15, webtype-13, webcat-14, uiux-16, brand-17, custz-18, pages-19
     */
         //start clean
        $clfl_text_field_a = '';
        $clfl_text_field_b = '';
        $clfl_text_field_2 = '';
        $clfl_text_field_3 = '';
        $clfl_textarea_field_4 = '';
        $clfl_text_field_5 = '';
        $clfl_text_field_6 = '';
        $clfl_text_field_7 = '';
        $clfl_text_field_8 = '';
        $clfl_radio_field_9 = '';
        $clfl_radio_field_10 = '';
        $clfl_radio_field_11 = '';
        $clfl_radio_field_12 = '';
        $clfl_select_field_13 = '';
        $clfl_select_field_14 = '';
        $clfl_text_field_15 = '';
        $clfl_text_field_16 = '';
        $clfl_text_field_17 = '';
        $clfl_text_field_18 = '';
        $clfl_text_field_19 = '';

    if( !empty( $_POST['clfl_text_field_a'] ) ) $clfl_text_field_a
                                 = trim( $_POST['clfl_text_field_a'] );
    if( !empty( $_POST['clfl_text_field_b'] ) ) $clfl_text_field_b
                           = filter_var( $_POST['clfl_text_field_b'], FILTER_SANITIZE_EMAIL );
    if( !empty( $_POST['clfl_text_field_2'] ) ) $clfl_text_field_2
                  = sanitize_text_field( $_POST['clfl_text_field_2'] );
    if( !empty( $_POST['clfl_text_field_3'] ) ) $clfl_text_field_3
                  = sanitize_text_field( $_POST['clfl_text_field_3'] );
    if( !empty( $_POST['clfl_textarea_field_4'] ) ) $clfl_textarea_field_4
                      = sanitize_text_field( $_POST['clfl_textarea_field_4']);
    if( !empty( $_POST['clfl_text_field_5'] ) ) $clfl_text_field_5
                  = sanitize_text_field( $_POST['clfl_text_field_5'] );
    if( !empty( $_POST['clfl_text_field_6'] ) ) $clfl_text_field_6
                  = sanitize_text_field( $_POST['clfl_text_field_6'] );
    if( !empty( $_POST['clfl_text_field_7'] ) ) $clfl_text_field_7
                  = sanitize_text_field( $_POST['clfl_text_field_7'] );
    if( !empty( $_POST['clfl_text_field_8'] ) ) $clfl_text_field_8
                  = sanitize_text_field( $_POST['clfl_text_field_8'] );

    if( !empty( $_POST['clfl_radio_field_9'] ) ) $clfl_radio_field_9
                                        = $_POST['clfl_radio_field_9'];
    if( !empty( $_POST['clfl_radio_field_10'] ) ) $clfl_radio_field_10
                                         = $_POST['clfl_radio_field_10'];
    if( !empty( $_POST['clfl_radio_field_11'] ) ) $clfl_radio_field_11
                                         = $_POST['clfl_radio_field_11'];
    if( !empty( $_POST['clfl_radio_field_12'] ) ) $clfl_radio_field_12
                                         = $_POST['clfl_radio_field_12'];

    if( !empty( $_POST['clfl_select_field_13'] ) ) $clfl_select_field_13
                                        =   $_POST['clfl_select_field_13'];
    if( !empty( $_POST['clfl_select_field_14'] ) ) $clfl_select_field_14
                                        =   $_POST['clfl_select_field_14'];

    if( !empty( $_POST['clfl_text_field_15'] ) ) $clfl_text_field_15
                   = sanitize_text_field( $_POST['clfl_text_field_15'] );
    if( !empty( $_POST['clfl_text_field_16'] ) ) $clfl_text_field_16
                   = sanitize_text_field( $_POST['clfl_text_field_16'] );
    if( !empty( $_POST['clfl_text_field_17'] ) ) $clfl_text_field_17
                   = sanitize_text_field( $_POST['clfl_text_field_17'] );
    if( !empty( $_POST['clfl_text_field_18'] ) ) $clfl_text_field_18
                   = sanitize_text_field( $_POST['clfl_text_field_18'] );
    if( !empty( $_POST['clfl_text_field_19'] ) ) $clfl_text_field_19
                   = sanitize_text_field( $_POST['clfl_text_field_19'] );

   /** wp_mail
     * @param string|array $to Array or comma-separated list of email addresses to send message.
     * @param string $subject Email subject
     * @param string $message Message contents
     * @param string|array $headers Optional. Additional headers.
     * @param string|array $attachments Optional. Files to attach.
     * @return bool Whether the email contents were sent successfully.
     */

    //add mail type in headers
    add_filter( 'wp_mail_content_type', 'clientflow_set_html_mail_content_type' );

    $to = $clfl_admin_email . ' <'.$clfl_admin_email.'>';

    $headers = '';
    $headers .= 'Cc:' . $clfl_text_field_a . ' <'.$clfl_text_field_b.'>'. "\n";
    $headers .= 'From:' . $clientflow_title . ' <'.$webmail_from.'>'. "\n";
    $headers .= $headers;

    $subject= trim($clientflow_title);
    $content = "<html><body><br><table><tbody><tr><td><span>name: </span>";
    $content .= $clfl_text_field_a;
    $content .= "</td><td><span>email: </span>";
    $content .= $clfl_text_field_b;
    $content .= "</td><td><span>domain: </span>";
    $content .= $clfl_text_field_2;
    $content .= "</td><td><span>referred: </span>";
    $content .= $clfl_text_field_7;
    $content .= "</td></tr><tr><td colspan=\"4\">";
    $content .= $clfl_textarea_field_4;
    $content .= "</td></tr><tr><td><span>dev url </span>";
    $content .= $clfl_text_field_5;
    $content .= "</td><td><span>host </span>";
    $content .= $clfl_text_field_6;
    $content .= "</td><td><span>timeframe </span>";
    $content .= $clfl_text_field_3;
    $content .= "</td><td><span>visitor exper: </span>";
    $content .= $clfl_text_field_16;
    $content .= "</td></tr><tr><td><span>branding: </span>";
    $content .= $clfl_text_field_17;
    $content .= "</td><td><span>customize: </span>";
    $content .= $clfl_text_field_18;
    $content .= "</td><td><span>pages: </span>";
    $content .= $clfl_text_field_19;
    $content .= "</td><td><span>type: </span>";
    $content .= $clfl_select_field_13;
    $content .= "</td></tr><tr><td><span>category: </span>";
    $content .= $clfl_select_field_14;
    $content .= "</td><td><span>live or new: </span>";
    $content .= $clfl_radio_field_9;
    $content .= $clfl_radio_field_10;
    $content .= "</td><td>has theme?: ";
    $content .= $clfl_radio_field_11;
    $content .= $clfl_radio_field_12;
    $content .= "</td><td>theme:  ";
    $content .= $clfl_text_field_15;
    $content .= "</td></tr></tbody></table><br>";
    $content .= $date_of;
    $content .= "<br></body></html>";

    $sendSuccess = wp_mail( $to, $subject, $content, $headers, '' );

    if ( $sendSuccess ) {
        ?>
            <div class="clflrow">
            <h4><?php esc_html_e('Your Information Was Sent Successfully.', 'clientflow' ); ?></h4>
            <p><?php esc_html_e( 'Please check your email', 'clientflow' ); ?></p>
            <p><?php //print($clfl_text_field_b); ?></p>
            </div>

            <?php
            } else {
            ?>

            <div class="clflrow">
            <h2><?php _e('Your Information was invalid. Please re-validate.', 'clientflow' ); ?></h2>
            <p><?php //echo $nameError; ?></p>
            </div>

            <?php
            }
        // Reset content-type to avoid conflicts -- https://core.trac.wordpress.org/ticket/23578
        remove_filter( 'wp_mail_content_type', 'clientflow_set_html_mail_content_type' );

         // ends if post[action]
    }
}
?>
