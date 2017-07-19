self.addEventListener('push', function(event) {
  if (event.data) {
    var data = event.data.json();
    console.log(data);
    self.registration.showNotification(data.title,{
      id: data.id,
      body: data.body,
      badge: 'https://payments.jyroneparker.com/push.png',
      icon: data.icon,
      vibrate: [300],
      actions: data.actions,
      data: data
    });
    console.log(data.id);
    console.log('This push event has data: ', event.data.text());
  } else {
    console.log('This push event has no data.');
  }
});
self.addEventListener('notificationclick', function(event) {
  console.log(event.notification);
  var eventId = event.notification.data.id;
  console.log(eventId);
  event.notification.close();

  if (event.action === 'view_details') {

      clients.openWindow("/view-details?event_id=" + eventId+"&test=false");

  }
  else if(event.action === 'view_details_test'){

          clients.openWindow("/view-details?event_id=" + eventId+"&test=true");
  }

}, false);
