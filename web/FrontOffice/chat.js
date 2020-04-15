var $messages = $('.messages-content'),
    d, h, m,
    i = 0;

$(window).load(function() {
  $messages.mCustomScrollbar();
  setTimeout(function() {
    fakeMessage();
  }, 100);
});

function updateScrollbar() {
  $messages.mCustomScrollbar("update").mCustomScrollbar('scrollTo', 'bottom', {
    scrollInertia: 10,
    timeout: 0
  });
}

function setDate(){
  d = new Date()
  if (m != d.getMinutes()) {
    m = d.getMinutes();
    $('<div class="timestamp">' + d.getHours() + ':' + m + '</div>').appendTo($('.message:last'));
  }
}

function insertMessage() {

  msg = $('.message-input').val();

  if ($.trim(msg) == '') {
    return false;
  }

  if(msg == 'no'){
    setTimeout(function(){  $('.message.loading').remove();
      $('<div class="message new"><figure class="avatar"><img src="https://thumbs.dreamstime.com/b/le-robot-de-sourire-mignon-bot-causerie-indiquent-salut-illustration-plate-moderne-personnage-dessin-anim%C3%A9-vecteur-130663707.jpg" /></figure>' + 'We Are Verry Happy For That' + '</div>').appendTo($('.mCSB_container')).addClass('new');
      setDate();
      updateScrollbar();
      document.getElementById('redirect').click();
      }, 1000 + (Math.random() * 20) * 100);
  

  }
  $('<div class="message message-personal" id="message" data-action='+ msg +' >' + msg + '</div>').appendTo($('.mCSB_container')).addClass('new');
  $('<input style="display: none" data-tag-id='+ msg +'  value='+ msg +' >' ).appendTo($('.mCSB_container'));
  setDate();
  $('.message-input').val(null);
  updateScrollbar();
  setTimeout(function() {
    fakeMessage();
  }, 1000 + (Math.random() * 20) * 100);
}

$('.message-submit').click(function() {
  insertMessage();
});

$(window).on('keydown', function(e) {
  if (e.which == 13) {
    insertMessage();
    return false;
  }
})

var Fake = [
  'Hi there, Im Taland Bot and you?',
  'Nice to meet you',
  'Do you have a problem with something in the website ?',
  'All you Have To Do is typing report',
  'Please Type The Problem Example (Sexual-content/Violent-content/Child-abuse/Failure to respect my rights)',
  'Now Type The Method that you want to receive your response on (SMS/Mail)? ',
  'Wait For Our Response For Maximum 48 Hours',
  'thank You  for helping us to improve our website ❤',
  'Bye',
  ':)'
]

function fakeMessage() {
 if(Fake[i] == 'thank You  for helping us to improve our website ❤'){
     setTimeout(function(){  $('.message.loading').remove();
         $('<div class="message new"><figure class="avatar"><img src="https://thumbs.dreamstime.com/b/le-robot-de-sourire-mignon-bot-causerie-indiquent-salut-illustration-plate-moderne-personnage-dessin-anim%C3%A9-vecteur-130663707.jpg" /></figure>' + 'thank You  for helping us to improve our website ❤' + '</div>').appendTo($('.mCSB_container')).addClass('new');
         setDate();
         updateScrollbar();
         document.getElementById('confirm').click();
     }, 1000 + (Math.random() * 20) * 100);

 }
  if ($('.message-input').val() != '') {
    return false;
  }
  $('<div class="message loading new"><figure class="avatar"><img src="https://thumbs.dreamstime.com/b/le-robot-de-sourire-mignon-bot-causerie-indiquent-salut-illustration-plate-moderne-personnage-dessin-anim%C3%A9-vecteur-130663707.jpg" /></figure><span></span></div>').appendTo($('.mCSB_container'));
  updateScrollbar();
  var tags = []
  $('[data-tag-id]').each(function () {
    tags.push($(this).val())
  })
  $('#responsetype').val(tags[5]);
  $('#reason').val(tags[4]);
  setTimeout(function() {
  $
    $('.message.loading').remove();
    $('<div class="message new"><figure class="avatar"><img src="https://thumbs.dreamstime.com/b/le-robot-de-sourire-mignon-bot-causerie-indiquent-salut-illustration-plate-moderne-personnage-dessin-anim%C3%A9-vecteur-130663707.jpg" /></figure>' + Fake[i] + '</div>').appendTo($('.mCSB_container')).addClass('new');
    setDate();
    updateScrollbar();
    i++;
  }, 1000 + (Math.random() * 20) * 100);



}