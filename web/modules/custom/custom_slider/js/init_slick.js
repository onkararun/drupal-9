/**
 * @file
 * Helper JavaScript for initializing sliders.
 */
(function ($, Drupal) {
  $(document).ready(function() {
    const slider = $('.view-slideshow .view-content');
    slider.slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: false,
      arrows: true,
      infinite: true,
      speed: 700,
      autoplaySpeed: 5000,
      autoplay: true
    });
  });

})(jQuery, Drupal);