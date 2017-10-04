<div id="page-content" class="container">
    <div class="row">
        <div id="contact-info-wrapper" class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div id="contact-info-desc"><p>Give us a call, send a mail or a message via the contact form.</p><p>We appreciate feedback of all sorts!</p></div>
            <div id="contact-info-panel">
                <h3>Company info</h3>
                <div id="contact-info-company"><p>MDB Movie Database LTD Corp</p></div>
                <div id="contact-info-tel"><p><span>Tel: </span><?php echo $tel; ?></p></div>
                <div id="contact-info-email"><p><span>Email: </span><?php echo $email; ?></p></div>
            </div>
        </div>
        <div id="contact-form-wrapper" class="col-xs-12 col-sm-12 col-md-6 col-lg-6"><?php echo do_shortcode( $contact_form_shortcode ); ?></div>
    </div>
</div>