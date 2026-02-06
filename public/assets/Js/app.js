$('.sign-btn-next').on('click',function(){
    $('.sign-up-step-1').css('display','none');
    $('.sign-up-step-2').css('display','flex');
})

$('.menu-icon').on('click',function(){
    $('.sidebar').css('left','0px');
    $('.overlay').css('display','block');
})

$('.overlay').on('click',function(){
    $('.sidebar').css('left','-300px');
    $('.overlay').css('display','none');
})
// ================================================filter btns
$(document).ready(function() {
    $('.filter-row button').click(function() {
      // Remove the "active" class from all buttons
      $('.filter-row button').removeClass('applied-filter');
      // Add the "applied-filter" class to the clicked button
      $(this).addClass('applied-filter');
    });
  });