$('.home-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 4000,
    responsive: [
    {
        breakpoint: 1366,
        settings: {
            arrows: true,
            slidesToShow: 1
        }
    },
    {
        breakpoint: 1024,
        settings: {
            arrows: true,
            slidesToShow: 1
        }
    },
    {
        breakpoint: 768,
        settings: {
            arrows: true,
            slidesToShow: 1
        }
    },
    {
        breakpoint: 480,
        settings: {
          arrows: true,
          slidesToShow: 1
        }
    }
    ]
});
$('.featured-slide').slick({
    dots: true,
    slidesToShow: 4,
    slidesToScroll: 4,
    autoplay: true,
    autoplaySpeed: 4000,
    responsive: [
    {
        breakpoint: 1366,
        settings: {
            arrows: true,
            slidesToShow: 4
        }
    },
    {
        breakpoint: 1024,
        settings: {
            arrows: true,
            slidesToShow: 2
        }
    },
    {
        breakpoint: 640,
        settings: {
            arrows: true,
            slidesToShow: 2
        }
    },
    {
        breakpoint: 480,
        settings: {
          arrows: true,
          slidesToShow: 2
        }
    }
    ]
});