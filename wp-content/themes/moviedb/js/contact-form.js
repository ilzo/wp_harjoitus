jQuery(function() { 
var wpcf7 = document.querySelector('#contact-form-wrapper .wpcf7');
var contact_form = document.querySelector('#contact-form-wrapper .wpcf7').childNodes[3];
var form_submit_value = jQuery('#contact-form-wrapper .wpcf7 .wpcf7-submit').val();
var form_ajaxloader = contact_form.childNodes[10];
    
jQuery('#contact-form-wrapper .wpcf7 .wpcf7-submit').addClass('submit-hover');
 
jQuery(contact_form).submit(function() {
    jQuery('#contact-form-wrapper .wpcf7 .wpcf7-submit').toggleClass('submit-hover').toggleClass('submit-loading');
    this.childNodes[9].childNodes[0].disabled = true;
    this.childNodes[9].childNodes[0].value = '';
});

wpcf7.addEventListener('wpcf7invalid', revertSubmitButton, false);
wpcf7.addEventListener('wpcf7mailfailed', revertSubmitButton, false);
wpcf7.addEventListener('wpcf7mailsent', revertSubmitButton, false);
    
function revertSubmitButton () {
    jQuery('#contact-form-wrapper .wpcf7 .wpcf7-submit').toggleClass('submit-hover').toggleClass('submit-loading');
    contact_form.childNodes[9].childNodes[0].disabled = false;
    contact_form.childNodes[9].childNodes[0].value = form_submit_value;
}
       
});