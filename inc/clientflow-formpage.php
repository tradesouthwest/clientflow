<?php
// ClientFlow 2017

function clfl_formsettings_init(  ) {

    register_setting( 'pluginPage', 'clfl_settings' );

    add_settings_field(
        'clfl_text_field_a',
        __( 'Settings field description', 'clientflow' ),
        'clfl_text_field_a_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );

    add_settings_field(
        'clfl_text_field_b',
        __( 'Settings field description', 'clientflow' ),
        'clfl_text_field_b_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );
/** not using options API since form is POST only 
    add_settings_field(
        'clfl_text_field_2',
        __( 'Settings field description', 'clientflow' ),
        'clfl_text_field_2_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );

    add_settings_field(
        'clfl_text_field_3',
        __( 'Settings field description', 'clientflow' ),
        'clfl_text_field_3_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );

    add_settings_field(
        'clfl_textarea_field_4',
        __( 'Settings field description', 'clientflow' ),
        'clfl_textarea_field_4_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );

    add_settings_field(
        'clfl_text_field_5',
        __( 'Settings field description', 'clientflow' ),
        'clfl_text_field_5_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );

    add_settings_field(
        'clfl_text_field_6',
        __( 'Settings field description', 'clientflow' ),
        'clfl_text_field_6_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );

    add_settings_field(
        'clfl_text_field_7',
        __( 'Settings field description', 'clientflow' ),
        'clfl_text_field_7_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );

    add_settings_field(
        'clfl_text_field_8',
        __( 'Settings field description', 'clientflow' ),
        'clfl_text_field_8_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );

    add_settings_field(
        'clfl_radio_field_9',
        __( 'Settings field description', 'clientflow' ),
        'clfl_radio_field_9_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );

    add_settings_field(
        'clfl_radio_field_10',
        __( 'Settings field description', 'clientflow' ),
        'clfl_radio_field_10_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );

    add_settings_field(
        'clfl_radio_field_11',
        __( 'Settings field description', 'clientflow' ),
        'clfl_radio_field_11_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );

    add_settings_field(
        'clfl_radio_field_12',
        __( 'Settings field description', 'clientflow' ),
        'clfl_radio_field_12_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );

    add_settings_field(
        'clfl_select_field_13',
        __( 'Settings field description', 'clientflow' ),
        'clfl_select_field_13_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );

    add_settings_field(
        'clfl_select_field_14',
        __( 'Settings field description', 'clientflow' ),
        'clfl_select_field_14_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );

    add_settings_field(
        'clfl_text_field_15',
        __( 'Settings field description', 'clientflow' ),
        'clfl_text_field_15_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );

    add_settings_field(
        'clfl_text_field_16',
        __( 'Settings field description', 'clientflow' ),
        'clfl_text_field_16_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );

    add_settings_field(
        'clfl_text_field_17',
        __( 'Settings field description', 'clientflow' ),
        'clfl_text_field_17_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );

    add_settings_field(
        'clfl_text_field_18',
        __( 'Settings field description', 'clientflow' ),
        'clfl_text_field_18_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );
        add_settings_field(
        'clfl_text_field_19',
        __( 'Settings field description', 'clientflow' ),
        'clfl_text_field_19_render',
        'pluginPage',
        'clfl_pluginPage_section'
    );
*/
}
add_action( 'admin_init', 'clfl_formsettings_init' );


//create shortcoded page
function clientflow_shortcode_wrapper_callback()
{

    if( isset( $_POST['clientflow-submitted'] ))
    {
    $nonce = $_REQUEST['clientflow_verify'];
    if ( ! wp_verify_nonce( $nonce, 'clientflow_nonce' ) ) {
       die ( 'Security check' ); }
    clientflow_sendmail_formprocess(); }
    else
    {
/**Doing the form
 * client_name-a, client_email-b, refers-7,  messagex-4, domainx-2, urls-5,  hosts-6, timeframe-3, password-8,
 * radio1-9-live-site, 10-new-site, radio2-11-no-theme, 12-have-theme, themename-15, webtype-13, webcat-14,
 * uiux-16, brand-17, custz-18, pages-19
 */
?>
<div class="clientflowwrap">
<header><h3><?php $option = get_option( 'clfl_settings' );
        esc_attr_e(  $option['clfl_text_field_1'] ); ?></h3></header>

    <form id="clientflow-form" method="post" class="form" action="">
        <section class="inner-form">
    <p><label for="name"><i class="fa fa-user"></i> project manager <span class="req">*</span></label></p>
    <p><input type='text' name='clfl_text_field_a' placeholder='Your name'></p>
    <p><label for="email"><i class="fa fa-envelope-o"></i> contact email <span class="req">*</span></p>
    <p><input type='text' name='clfl_text_field_b'></p>
    <p><label for="domainx"><i class="fa fa-globe"></i> domain name</label></p>
    <p><input type='text' name='clfl_text_field_2'></p>
    <p><label for="timeframe"><i class="fa fa-calendar"></i> timeframe</label></p>
    <p><input type='text' name='clfl_text_field_3'></p>

    <div class="clflrow">
    <p><label for="messagex"><i class="fa fa-bullseye"></i> general overview <small>only write in what has not been discussed from any earlier entries</small></label></p>
    <p><textarea cols='40' rows='5' name='clfl_textarea_field_4'></textarea></p>
    </div>

    <p><label for="urls"><i class="fa fa-cog"></i> development url <small>optional</small></label></p>
    <p><input type='text' name='clfl_text_field_5'></p>
    <p><label for="hosts"><i class="fa fa-cloud"></i> host</label></p>
    <p><input type='text' name='clfl_text_field_6'></p>
    <p><label for="refer"><i class="fa fa-"></i> referred from</label></p>
    <p><input type='text' name='clfl_text_field_7'></p>
    <p><label for="password"><i class="fa fa-user"></i> credentials <small>only if asked for please</small></label></p>
    <p><input type='text' name='clfl_text_field_8'></p>

    <div class="clflrow">
        <h3 class="page-header text-center">Site Specific Questions</h3>
             <h4>Questions below can be answered as generalizations and are subject to discussion. This is only a way of getting all parties connected with the ideas you have for your project.</h4>
             <p><small>Note that there are many questions that we <strong>do not need to ask you</strong> that you may have concerns about. For example, A website that is reponsive and works on mobile, tablet and various devices is a given. All our work is done with this in mind unless you have a really old site that can not be adapted. Other inherit design concepts are cross-browser friendly or content privacy. We have been doing this for a long time so you can always ask and we will have an answer.</small></p>
    </div>

    <p><label for="radio1info"><i class="fa fa-info-circle"></i> 1. Is this a refactoring of an existing site?</label></p>
    <p><input type="radio" name="clfl_radio_field_9" id="rad9" <?php //checked( 'clfl_radio_field_9', 'live-site' );  ?> value="live-site"><span> Yes </span>
    <input type="radio"    name="clfl_radio_field_9" id="rad10" <?php //checked( 'clfl_radio_field_10', 'new-site' ); ?>    value="new-site"><span> No - Site is new </span></p>
    <p><label for="havetheme"><i class="fa fa-info-circle"></i> 2. Are you using an existing theme or do you need help selecting one?</label></p>
    <p><input type="radio" name="clfl_radio_field_11" id="rad11" <?php //checked( 'clfl_radio_field_11', 'no-theme' ); ?>    value="no-theme"><span>No Theme Yet </span>
    <input type="radio"    name="clfl_radio_field_11" id="rad12" <?php //checked( 'clfl_radio_field_12', 'have-theme' ); ?>  value="have-theme"><span> Have Theme </span></p>
    <p><label for="themename"> theme name</label></p>
    <p><input type="text"  name="clfl_text_fields_15" placeholder="theme name"></p>
    
    <p><label for="themename"> theme name</label></p><p>
    <input type='text'     name='clfl_text_fields_15'></p>
    <p><label for="select1"><i class="fa fa-info-circle"></i> 3. Type of Website?</label></p>
                   <select name='clfl_select_field_13'>
        <option selected="selected">Select Type</option>
            <option value="static">Non-editable brochure website</option>
            <option value="editable">Editable brochure website </option>
            <option value="userengage">Editable, dynamic website, with more user engagement</option>
            <option value="ecomm">E-commerce site – integrated with a payment gateway </option>
            <option value="applctn">A web application </option>
    </select>
    <p><label for="select2"><i class="fa fa-info-circle"></i> 4. What Category would your website fit into?</label></p>
    <select name='clfl_select_field_14'>
        <option selected="selected">Select Category</option>
            <option value="0">Not Sure Yet</option>
            <option value="auction">Auction Websites</option>
            <option value="blog">Blog or Personal Website</option>
            <option value="bizdir">Business Directory</option>
            <option value="bizsite">Business Website</option>
            <option value="coupon">Coupon Website</option>
            <option value="ecomd">eCommerce - Digital</option>
            <option value="ecomg">eCommerce - Goods</option>
            <option value="ecomv">eCommerce - MutiVendor</option>
            <option value="arts">Entertainment Venues</option>
            <option value="family">Family or Community Blog</option>
            <option value="health">Health and Wellbeing</option>
            <option value="job">Job Board</option>
            <option value="know">Knowledgebase or Wiki Website</option>
            <option value="lang">Multilingual Websites</option>
            <option value="niche">Niche Affiliate Website</option>
            <option value="nonprofit">NonProfits and Religious Website</option>
            <option value="social">Online Communities</option>
            <option value="photo">Photography Websites</option>
            <option value="pods">Podcasting Websites</option>
            <option value="porfolio">Portfolio Website</option>
            <option value="priv">Private Blogs</option>
            <option value="qa">Question &amp; Answer Website</option>
            <option value="educ">School or College Website</option>
            <option value="educ">Service or Industry Craft</option>
            <option value="travel">Travel Directory or Blog</option>
            <option value="adult">Adult Materials</option>
    </select>
    <p> <label for="uiux"><i class="fa fa-users"></i>5. What would you like to see your visitors or members do on your website?</label></p>
    <p><input type='text' name='clfl_text_field_16'></p>
    <p><label for="brand"><i class="fa fa-"></i>6. What colors and what layout do you have in mind? <small>This is known as Branding. Any company colors (mostly applies to a NEW website)</small></label></p>
    <p><input type='text' name='clfl_text_field_17'></p>
    <p><label for="custz"><i class="fa fa-bug"></i>7. What kind of rework do you need? <small>is this a plugin or an design change only? If large project then skip.</small></label></p>
    <p><input type='text' name='clfl_text_field_18'></p>
    <p><label for="pages"><i class="fa fa-chain-broken"></i>8. What pages need work? <small>list all separated by spaces. If this is a large project then skip.</small></label></p>
    <p><input type='text' name='clfl_text_field_19'></p>

    <input type="hidden" name="clientflow_verify" value="<?php echo wp_create_nonce( 'clientflow_nonce' ); ?>">
    <input name="action" value="add_transfer" type="hidden">
    <input type="hidden" name="clientflow-fauxnonce" value="12345">
    <input type="submit" class="button-primary" name="clientflow-submitted" value="Save and Send"></form>
    </div><p><?php  $option = get_option( 'clfl_settings' );
    esc_attr_e( $option['clfl_text_field_0'] ); ?></p>

<?php
    }
}
add_shortcode('clientflow-form','clientflow_shortcode_wrapper_callback');

?>
