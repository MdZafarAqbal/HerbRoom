function trackOrder(order) {
  let shipping = order['shipping'];
  let status = shipping['status'];
  if(order['status'] == 'cancelled') {
    $('#status-line').html('Your order is cancelled.');
  } else if (order['status'] == 'returned') {
    $('#status-line').html('Your order is returned.');
  } else {
    let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    let orderDate = new Date(shipping['ordered']);
    let processDate = new Date(shipping['processed']);
    let shipDate = new Date(shipping['shipped']);
    let deliverDate = new Date(shipping['delivered']);

    if(status == 'ordered') {
      $('#status-line').html('Your order has been confirmed. We are processing your order.');
      $('#order-icon').addClass('bx-burst');
      $('#process-icon').removeClass('bx-burst');
      $('#ship-icon').removeClass('bx-burst');
      $('#deliver-icon').removeClass('bx-burst');
      $('#order-date').html(orderDate.toLocaleDateString('en-US', options));
      $('#process-date').html('-- ------- ----');
      $('#ship-date').html('-- ------- ----');
      $('#deliver-date').html('-- ------- ----');
      $('#status-img').attr('src', '/images/ordered_track.png');
    } else if (status == 'processed') {
      $('#status-line').html('Your order has been processed. Soon It will be shipped to you.');
      $('#order-icon').removeClass('bx-burst');
      $('#process-icon').addClass('bx-burst');
      $('#ship-icon').removeClass('bx-burst');
      $('#deliver-icon').removeClass('bx-burst');
      $('#order-date').html(orderDate.toLocaleDateString('en-US', options));
      $('#process-date').html(processDate.toLocaleDateString('en-US', options));
      $('#ship-date').html('-- ------- ----');
      $('#deliver-date').html('-- ------- ----');
      $('#status-img').attr('src', '/images/processed_track.png');
    } else if (status == 'shipped') {
      $('#status-line').html('Your order has been shipped. Soon you will receive your package.');
      $('#order-icon').removeClass('bx-burst');
      $('#process-icon').removeClass('bx-burst');
      $('#ship-icon').addClass('bx-burst');
      $('#deliver-icon').removeClass('bx-burst');
      $('#order-date').html(orderDate.toLocaleDateString('en-US', options));
      $('#process-date').html(processDate.toLocaleDateString('en-US', options));
      $('#ship-date').html(shipDate.toLocaleDateString('en-US', options));
      $('#deliver-date').html('-- ------- ----');
      $('#status-img').attr('src', '/images/shipped_track.png');
    } else {
      $('#status-line').html('Your order has been delivered');
      $('#order-icon').removeClass('bx-burst');
      $('#process-icon').removeClass('bx-burst');
      $('#ship-icon').removeClass('bx-burst');
      $('#deliver-icon').addClass('bx-burst');
      $('#order-date').html(orderDate.toLocaleDateString('en-US', options));
      $('#process-date').html(processDate.toLocaleDateString('en-US', options));
      $('#ship-date').html(shipDate.toLocaleDateString('en-US', options));
      $('#deliver-date').html(deliverDate.toLocaleDateString('en-US', options));
      $('#status-img').attr('src', '/images/delivered_track.png');
    }
  }
}