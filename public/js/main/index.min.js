/*==================== Image Slider ====================*/
let responsiveSlider = function() {
  let sliderInterval;
  let sliderWidth = $('#slider').width();
  let items = $('#slider li').length;
  let count = 1;

  $(window).on('resize', function() {
    sliderWidth = $('#slider').width();
  });
  
  let prevSlide = function() {
    if(count > 1) {
      count -= 2;
      $('#carousel-wrap').css('left', '-' + count * sliderWidth + 'px');
      count++;
    }
    
    else if(count == 1) {
      count = items - 1;
      $('#carousel-wrap').css('left', '-' + count * sliderWidth + 'px');
      count++;
    }
  };

  let nextSlide = function() {
    if(count < items) {
      $('#carousel-wrap').css('left', '-' + count * sliderWidth + 'px');
      count++;
    }
    
    else if (count == items) {
      $('#carousel-wrap').css('left', '0');
      count = 1;
    }
  };

  $('#slide-next').on('click', function() {
    nextSlide();
    clearInterval(sliderInterval);
    startInt();
  });

  $('#slide-prev').on('click', function() {
    prevSlide();
    clearInterval(sliderInterval);
    startInt();
  });

  let startInt = function(){
    sliderInterval = setInterval(function() {
      nextSlide();
    }, 6e3);
  };

  startInt();
};

$(window).on('load', function() {
  responsiveSlider();
});
