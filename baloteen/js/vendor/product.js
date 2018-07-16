$(document).ready(function () {
$("#product_image").elevateZoom({
  zoomWindowFadeIn : 500,
  zoomLensFadeIn: 500,
  gallery:'gallery', 
  cursor: 'pointer',
  galleryActiveClass: "active", 
  imageCrossfade: true, 
  zoomType: "inner",
  cursor: "crosshair",
  responsive: true 
 }); 

$("#product_image").bind("click", function(e) {  
  var ez =   $('#product_image').data('elevateZoom');
  ez.closeAll();
  $.fancybox(ez.getGalleryList());
  return false;
}); 
});

$('.related-slider').slick({
  dots: false,
  speed: 300,
  slidesToShow: 4,
  slidesToScroll: 4,
  responsive: [
  {
    breakpoint: 1024,
    settings: {
      slidesToShow: 3,
      slidesToScroll: 3,
      dots: false
    }
  },
  {
    breakpoint: 640,
    settings: {
      slidesToShow: 2,
      slidesToScroll: 2,
      dots: false
    }
  },
]
});
$('.product-slider').slick({
  centerMode: true,
  centerPadding: '120px',
  slidesToScroll: 1,
  slidesToShow: 1,
  dots: true,
  centerMode: true,
  focusOnSelect: true,
  arrows: true,
  lazyLoad: 'ondemand',
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: true,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: true,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    }
  ]
});
