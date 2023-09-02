// Mobile Menu Overlay
function showMenu() {
  $('body').css('height', '90vh');
  $('body').css('overflow', 'hidden');
  if (! $('#mob-cat-menu').hasClass('collapse'))
    $('#mob-cat-menu').toggleClass('collapse');
  $('#mob-nav').css('width', '100%');
}

function closeMenu(){
  $('body').css('height', 'auto');
  $('body').css('overflow', 'auto');
  $('#mob-nav').css('width', '0');
}

function menu() {
  $('#mob-cat-menu').toggleClass('collapse');

  if($('#shop-dropdown-icon').hasClass('bxs-down-arrow')) {
    $('#shop-dropdown-icon').addClass('bxs-up-arrow');
    $('#shop-dropdown-icon').removeClass('bxs-down-arrow');
  } else {
    $('#shop-dropdown-icon').addClass('bxs-down-arrow');
    $('#shop-dropdown-icon').removeClass('bxs-up-arrow');
  }
}

$(window).scroll(function(){
  let sticky = $('#header'),
    scroll = $(window).scrollTop();

  if (scroll >= 5) 
    sticky.addClass('sticky');
  else 
    sticky.removeClass('sticky');
});