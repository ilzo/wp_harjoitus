jQuery(function() {
    var isMobile = false;
    var search_field = jQuery('#searchform input[type="text"]');
    jQuery('#search-submit').click(function(){
        if(!isMobile)
            search_field.css('width', '500px');
    });
    
    search_field.focus(function(){
        if(!isMobile)
           search_field.css('width', '500px');
    });
    
    search_field.blur(function(e){
        if(e.relatedTarget === null && !isMobile)
           search_field.css('width', '200px');
    });
    
    resizer();
    
    function resizer() {
        var w = jQuery(window).width();
        if(w < 768){
            isMobile = true;
        }else{ 
            isMobile = false;
        }  
    }

    jQuery(window).on('resize', function(){ 
        resizer();
    });   
});