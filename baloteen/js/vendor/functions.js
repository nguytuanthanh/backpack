(function($){
function keypress(e){
    var keypressed = null;
    if (window.event)
    {
        keypressed = window.event.keyCode; //IE
    }
    else {
    
        keypressed = e.which; //NON-IE, Standard
        }
    if (keypressed < 48 || keypressed > 57)
        {
        if (keypressed == 8 || keypressed == 127)
        {
            return;
        }
    return false;
    }
}
$(document).ready(function(){   
    $('.btn-number').click(function(e){
        e.preventDefault();
        fieldName = $(this).attr('data-field');
        type      = $(this).attr('data-type');
        var input = $("input[name='"+fieldName+"']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if(type == 'minus') {
                
                if(currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                } 
                if(parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if(type == 'plus') {
                var max;
                if(input.attr('max') == ""){
                  max = 20;
                }else{
                  max = input.attr('max');
                }
                if(currentVal < max) {
                    input.val(currentVal + 1).change();
                  }
                if(parseInt(input.val()) == max) {
                    $(this).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
    });
    $('.input-number').change(function() {
        minValue =  parseInt($(this).attr('min'));
        maxValue =  parseInt($(this).attr('max'));
        maxValue = 20;
        valueCurrent = parseInt($(this).val());
        
        name = $(this).attr('name');
        if(valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
        }
        if(valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        }   
    });
    $(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });   
    /*$("img.lazy").each(function(){
        $(this).attr("data-original", $(this).attr("src"));
        $(this).attr("src", "data:image/gif;base64,R0lGODlhAQABAPAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==");
      });
      (function () {
        new LazyLoad({
          data_src: 'original',
          data_srcset: 'original-set'
        });
    }());*/
    var cart = $(".cart-dropdown .cart-dropdown-inner");
    var optionHeight = cart.actual('outerHeight');
    if(optionHeight >= 280){
        cart.css('overflow-y', 'scroll');
    }
});
})(jQuery);