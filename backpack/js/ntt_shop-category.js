$(document).ready(function(){
	$('.chkbox').change(function() {
		var chkBoxPrice = [];
		var chkBoxColor = [];
	    var cat_id = $('#cat_id').val();
	    $('.chkprice:checked').each(function() {
            chkBoxPrice = $(this).val();
        });
        $('.chkcolor:checked').each(function() {
            chkBoxColor.push($(this).val());
        });
        $.ajax ({
			url: ntt_shop_ajax_category.ajax_url,
			type:'POST',
			data:'action=category_ajax&price='+chkBoxPrice+'&cat_id='+cat_id+'&color='+chkBoxColor,
			beforeSend: function() {
				jQuery('.cat_content').empty();
				jQuery('.cat_content').append('<div class="loading"><div class="loading-bar"></div><div class="loading-bar"></div><div class="loading-bar"></div><div class="loading-bar"></div></div>');
			},
			success:function(results) {
				jQuery('.cat_content').empty();
				jQuery('.cat_content').append(results);
			}
		});
	});
});