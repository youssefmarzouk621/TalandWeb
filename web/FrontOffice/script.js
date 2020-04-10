
$('.flipBtn').on('click', function() {
  var itemNum = $('.pane.one .active');  // get an active item in a stack
  var crnt = $('.pane.one .card').index( itemNum );  // find out the index of an active card
  var end = $('.pane.one .card').length-1;  // find out how many cards are in a stack
  
  ($(this).val() == 'Next') ? crnt++ : crnt--; // next / previous
  
  if (crnt > end) {  // at the end, so start over
    crnt = 0;
  } else if (crnt < 0) {  // at the front, so go to the end
    crnt = end;
  }
  
  $('.pane .active').removeClass('active');
  $('.pane .card:nth-child('+ (crnt+1) +')').addClass('active');
})
$('.rating ul li').on('click', function() {

  let li = $(this),
      ul = li.parent(),
      rating = ul.parent(),
      last = ul.find('.current');

  if(!rating.hasClass('animate-left') && !rating.hasClass('animate-right')) {

    last.removeClass('current');

    ul.children('li').each(function() {
      let current = $(this);
      current.toggleClass('active', li.index() > current.index());
    });

    rating.addClass(li.index() > last.index() ? 'animate-right' : 'animate-left');
    rating.css({
      '--x': li.position().left + 'px'
    });
    li.addClass('move-to');
    last.addClass('move-from');

    setTimeout(() => {
      li.addClass('current');
      li.removeClass('move-to');
      last.removeClass('move-from');
      rating.removeClass('animate-left animate-right');
    }, 800);

  }

})

$('.flipBtntheny').on('click', function() {
  var itemNum = $('.pane.one .active');  // get an active item in a stack
  var crnt = $('.pane.one .card').index( itemNum );  // find out the index of an active card
  var end = $('.pane.one .card').length-1;  // find out how many cards are in a stack

  ($(this).val() == 'Next') ? crnt++ : crnt--; // next / previous


  if (crnt == end-1) {  // at the end, so start over
    crnt = -2;
  }

    $('.pane .active').removeClass('active');
    $('.pane .card:nth-child('+ (crnt+3) +')').addClass('active');



})