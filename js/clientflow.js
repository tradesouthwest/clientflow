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
