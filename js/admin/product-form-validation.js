/*force user to select a product category before saving the post*/
jQuery(function($){
    $('#publish, #save-post').click(function(e){
        var ttl=$('input#title');
        if($.trim(ttl.val())===''){
            Show_Notice('Please enter the product title');
            e.stopImmediatePropagation();
            ttl.val('').focus();
            return false;
        }
        else if($('#taxonomy-product-category').find('input:checked').length==0){
            Show_Notice('Please select a category first');
            e.stopImmediatePropagation();
            return false;
        }else {
          var m_box=$('#product_meta_box');
          if($.trim($('#prod_composition',m_box).val())===''){
              Show_Notice('Please enter product composition');
              e.stopImmediatePropagation();
              return false;
          }else if($.trim($('#prod_packaging',m_box).val())===''){
              Show_Notice('Please enter product packaging');
              e.stopImmediatePropagation();
              return false;
          }else{
              return true
          }
        }

    });
    function Show_Notice(msg){
        if(msg===''){ msg = 'Validation Error !'; }
        $('div#notice,div#message').remove();
        $('form#post').before('<div id="notice" class="notice notice-error is-dismissible" style="display: none"><p><i class="dashicons dashicons-no"> </i>'+msg+'</p></div>');
        $('div#notice').slideDown().delay(5000).slideUp("slow");
    }
});
