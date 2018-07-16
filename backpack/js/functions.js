(function($){
$(document).ready(function () {
    //var cat = $('#more_posts').data('category');
    var ppp = 8;
    var pageNumber = 1;
    function load_posts(){
        pageNumber++;
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: ajax_object.ajax_url,
            data: {
                //'cat': cat,
                'ppp': ppp,
                'pageNumber': pageNumber,
                'action': 'more_post_ajax'
            },
            success: function(data){
                var $data = $(data);
                if($data.length){
                    $("#ajax-posts").append(data);
                    $("#more_posts").attr("disabled",false);
                } else{
                    $("#more_posts").hide();
                    $("#ajax-posts").append('<p class="no-post">Không còn sản phẩm để hiển thị.</p>');
                }
            },
            error : function(jqXHR, textStatus, errorThrown) {
                $loader.html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
        return false;
    }
    $("#more_posts").on("click",function(){ 
        $("#more_posts").attr("disabled",true);
        load_posts();
    });
});
})(jQuery);