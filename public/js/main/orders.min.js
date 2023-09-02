$('.order-detail').on('click', function() {
  let order = $(this).attr('data-order');
  window.location.href = "/order-detail?order_no=" + order;
});

$('#order-detail-btn').on('click', function() {
  let order = $('#order-input').val().toUpperCase();
  window.location.href = "/order-detail?order_no=" + order;
});

$('#all-checkbox').on('change', function() {
  if(this.checked) {
    $('.item-checkbox').prop('checked', true);
    $('#action').removeAttr('disabled');
  }
  else {
    $('.item-checkbox').prop('checked', false);
    $('#action').attr('disabled', true);
  }
});

$('.item-checkbox').on('change', function() {
  if(! this.checked) {
    $('#all-checkbox').prop('checked', false);
  } else {
    $('#action').removeAttr('disabled');
  }

  if($('.item-checkbox:checked').length == $('.item-checkbox').length)
    $('#all-checkbox').prop('checked', true);

  if($('.item-checkbox:not(:checked)').length == $('.item-checkbox').length) {
    $('#action').attr('disabled', true);
  }
});

$('#action').on('click', function() {
  let total = Number($('#total').val()) + Number($('#tax').val());
  if($('#all-checkbox').prop('checked')) {
    total = 0;
  }
  else {
    $('input:checkbox[name=item_checkbox]:checked').each(function() {
      total = total - $(this).attr('data-total');
    });
  }

  if(total < 100) {
    if($(this).hasClass('item-cancel') && total == 0) {
      $('#reason-popup').css('width', '100%');
      $('#reason-popup').css('height', '100%');
      $('#reason-div').css('transform', 'scale(1)');
      $(body).css('height', '90vh');
      $(body).css('overflow', 'hidden');
    } else {
      $('#warning-popup').css('width', '100%');
      $('#warning-popup').css('height', '100%');
      $('#warning-div').css('transform', 'scale(1)');
      $(body).css('height', '90vh');
      $(body).css('overflow', 'hidden');

      $('#continue').on('click', function() {
        removePopup();
        $('#reason-popup').css('width', '100%');
        $('#reason-popup').css('height', '100%');
        $('#reason-div').css('transform', 'scale(1)');
        $(body).css('height', '90vh');
        $(body).css('overflow', 'hidden');
      })
    }
  } else {
    $('#reason-popup').css('width', '100%');
    $('#reason-popup').css('height', '100%');
    $('#reason-div').css('transform', 'scale(1)');
    $(body).css('height', '90vh');
    $(body).css('overflow', 'hidden');
  }
});

$('.reason-item').on('click', function() {
  $('.reason-item').css('color', '#7c8e7b'),
  $('.reason-item').css('background-color', '#f2f4e6');
  $(this).css('color', '#fff');
  $(this).css('background-color', '#7c8e7b');
  $('#reason').val($(this).attr('id'));

  $('.pop-btn').removeAttr('disabled');

  if($(this).attr('id') == 'other')
    $('#other-text').removeClass('collapse');
  else
    $('#other-text').addClass('collapse');
});

$('#continue-cancel').on('click', function() {
  let order_id = $('#order').val();
  let all = 0;
  let items = new Array();
  let reason = $('#reason').val();
  if(reason == 'other') {
    if($('#other-text').val() != '')
      reason = $('#other-text').val();
  }

  if($('#all-checkbox').prop('checked')) {
    all = 1;
  }
  else {
    $('input[name=item_checkbox]:checked').each(function() {
      items.push($(this).val());
    });
  }

  /* AJAX request to cancel items from order */
  $.ajax({
    type: 'get',
    url: '/order-cancel',
    data: {
      id: order_id,
      all: all,
      items: items,
      reason: reason
    },
    success: function(response) {
      location.reload();
    },
    error: function() {
      alert("An error occured while cancel operation");
    }                
  }); 
});

$('#continue-return').on('click', function() {
  let order_id = $('#order').val();
  let all = 0;
  let items = new Array();
  let reason = $('#reason').val();
  if(reason == 'other') {
    if($('#other-text').val() != '')
      reason = $('#other-text').val();
  }

  if($('#all-checkbox').prop('checked')) {
    all = 1;
  }
  else {
    $('input[name=item_checkbox]:checked').each(function() {
      items.push($(this).val());
    });
  }

  /* AJAX request to return items from order */
  $.ajax({
    type: 'get',
    url: '/order-return',
    data: {
      id: order_id,
      all: all,
      items: items,
      reason: reason
    },
    success: function(response) {
      location.reload();
    },
    error: function() {
      alert("An error occured while return operation");
    }                
  }); 
});

function removePopup() {
  $('.popup-div').css('transform', 'scale(0)');
  $('.popup').css('width', '0');
  $('.popup').css('height', '0');
  $(body).css('height', 'auto');
  $(body).css('overflow', 'auto');
}