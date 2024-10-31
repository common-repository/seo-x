jQuery(document).ready(function($){
    let slug = $('#editable-post-name').text();
    $('.csf-field-text input[data-depend-id|="meta-slug"]').val(slug);
});

jQuery(document).on('keyup', "#new-post-slug", function(e){
    data = jQuery(this).val();
    jQuery('.csf-field-text input[data-depend-id|="meta-slug"]').val(data);
});

jQuery(document).on('keyup', '.csf-field-text input[data-depend-id|="meta-slug"]', function(e){
    data = jQuery(this).val();
    jQuery("#editable-post-name").text(data);
    jQuery("#editable-post-name-full").text(data);
    jQuery("#post_name").val(data);
});