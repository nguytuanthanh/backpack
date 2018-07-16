$(document).ready(function () {
	$(function(){
		var boxThumbHeight =  $("#gallery").height();
		var obHeight = $("#gallery_track").height();
		if(obHeight <= boxThumbHeight) $(".gallery-btn.next").addClass("disabled");
		$(".gallery-btn.next").click(function(){
			if(obHeight <= boxThumbHeight) return false;

			var offset_top = $("#gallery_track").css('top');
			offset_top     = parseInt(offset_top);
			$("#gallery_track").animate({top: offset_top - boxThumbHeight}, 500);

			obHeight = obHeight - boxThumbHeight;
			if(obHeight <= boxThumbHeight){
				$(".gallery-btn.next").addClass("disabled");
				$(".gallery-btn.prev").removeClass("disabled");
			}
		});
		$(".gallery-btn.prev").click(function(){
			var offset_top = $("#gallery_track").css('top');
			offset_top     = parseInt(offset_top);

			if(offset_top >= 0) return false;

			$("#gallery_track").animate({top: offset_top + boxThumbHeight}, 500);
			$(".gallery-btn.next").removeClass("disabled");

			obHeight = obHeight + boxThumbHeight;
			if(offset_top <= 0){
				$(".gallery-btn.prev").addClass("disabled");
			}

		});
	});
}); 