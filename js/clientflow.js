/* ver 0.1 */

var options = {
        url: clflFormJSObject.ajaxUrl,  // this is part of the JS object you pass in from wp_localize_scripts.
        type: 'post',        // 'get' or 'post', override for form's 'method' attribute
        dataType:  json ,       // 'xml', 'script', or 'json' (expected server response type)
        dataType: 'json',
        success : function(responseText, statusText, xhr, $form) {
            $('#clientflow-form').html('Your form has been submitted successfully');
        },
        // use beforeSubmit to add your nonce to the form data before submitting.
    };

    // you should probably use an id more unique than "form"
    $('#clientflow-form').ajaxForm(options);


jQuery(document).ready(function() {
   jQuery('#name').on('focusout', function(event){
     var name = jQuery('#name');
     if( name.val() === '' ){
       name.addClass('required');
     } else {
       name.removeClass('required');
     }
   });


   jQuery('#email').on('focusout', function(event){
     var email = jQuery('#email');
     var vEmail = email.val();
     var cEmail = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}$/i;
     if( vEmail === '' ){
       email.addClass('required');
     } else if( !cEmail.test(vEmail) ){
       email.removeClass('required');
       email.addClass('error-email');
     } else {
       email.removeClass('required error-email');
     }
   });

   jQuery("#clientflow-form").click( function(e) {
     e.preventDefault();
     var post_data = jQuery('#clientflow-form').serialize();
     var form_action = '/wp-admin/admin-ajax.php'; //Directory and file name to save poses
     var form_method = jQuery('#clientflow-form').attr("method");
     var name = jQuery('#name');
     var email = jQuery('#email');
     if( name.val() !== '' && email.val() !== '' ){
       $.ajax({
         type: form_method,
         url: form_action,
         cache: false,
         data: post_data,
         success: function(response) {
           jQuery('#node').html(response);
           alert('Message has been sent!');
             $('#clientflow-form').trigger("reset");
         }
       });
     } else {
    jQuery("#node").fadeIn("slow");
       jQuery('#node').html('<span class="error">Please Fill all field to Submit data!</span>');
       if(name.val() === ''){
         name.addClass('required');
       }
       if(email.val() === ''){
         email.addClass('required');
       }
     }
   });
 });

