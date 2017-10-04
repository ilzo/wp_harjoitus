jQuery(function() {
    



//jQuery('.wpcf7-form span.ajax-loader').replaceWith('<div class="ajax-loader">Loading...</div>');

var wpcf7 = document.querySelector('#contact-form-wrapper .wpcf7');
var contact_form = document.querySelector('#contact-form-wrapper .wpcf7').childNodes[3];
var form_submit_value = jQuery('#contact-form-wrapper .wpcf7 .wpcf7-submit').val();
var form_ajaxloader = contact_form.childNodes[10];
    
jQuery('#contact-form-wrapper .wpcf7 .wpcf7-submit').addClass('submit-hover');

    /*
console.log(contact_form);    
console.log(form_submit_value);
console.log(form_ajaxloader);
*/
    
//jQuery(form_ajaxloader).empty();

    
jQuery(contact_form).submit(function() {
    jQuery('#contact-form-wrapper .wpcf7 .wpcf7-submit').toggleClass('submit-hover').toggleClass('submit-loading');
    this.childNodes[9].childNodes[0].disabled = true;
    this.childNodes[9].childNodes[0].value = '';
    
    //this.childNodes[9].childNodes[0].style.backgroundColor = 'rgb(211, 16, 246)';
});

wpcf7.addEventListener('wpcf7invalid', revertSubmitButton, false);
    
wpcf7.addEventListener('wpcf7mailfailed', revertSubmitButton, false);
    
wpcf7.addEventListener('wpcf7mailsent', revertSubmitButton, false);
    
    
    
function revertSubmitButton () {
    jQuery('#contact-form-wrapper .wpcf7 .wpcf7-submit').toggleClass('submit-hover').toggleClass('submit-loading');
    contact_form.childNodes[9].childNodes[0].disabled = false;
    contact_form.childNodes[9].childNodes[0].value = form_submit_value;
    //contact_form.childNodes[9].childNodes[0].style.backgroundColor = '#f5aa21';
}
    
/*
var newsletter_form = newsletter_forms[i].childNodes[3];
var newsletter_form_ajaxloader = newsletter_form.childNodes[8];
jQuery(newsletter_form_ajaxloader).empty();
jQuery(newsletter_form).submit(function() {
    this.childNodes[7].disabled = true;
    this.childNodes[7].value = '';
});

newsletter_forms[i].addEventListener('wpcf7invalid', function(e){
    this.childNodes[3].childNodes[7].disabled = false;
    this.childNodes[3].childNodes[7].value = newsletter_form_submit_value;
}, false);

newsletter_forms[i].addEventListener('wpcf7mailsent', function(e){
    var theme_path = WPURLS.theme_path;
    var email = this.childNodes[3].childNodes[5].childNodes[0].childNodes[0].value;
    jQuery.ajax({ 
        url: theme_path + '/inc/smoy-simple-crypt.php',
        data: { 'user_email' : email},
        type: 'post',
        success: function(output) {
            var result = jQuery.parseJSON(output);
            var encrypted = result['enc'];
            location = '/uutiskirje/?email='+email+'&n='+encrypted;
        }
    }); 
}, false);

newsletter_forms[i].addEventListener('wpcf7mailfailed', function(e){
    var responseOutput = e.target.childNodes[3].childNodes[9];
    jQuery(responseOutput).one('DOMSubtreeModified', function(){
      alert(this.textContent);
    });
    this.childNodes[3].childNodes[7].disabled = false;
    this.childNodes[3].childNodes[7].value = newsletter_form_submit_value;
}, false);
    
*/
    
});