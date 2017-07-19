self.addEventListener('push', function(event) {
  if (event.data) {
    var data = event.data.json();
    self.registration.showNotification(data.title,{
      id: data.id,
      body: data.body,
      badge: 'https://payments.jyroneparker.com/push.png',
      icon: data.icon,
      vibrate: [300],
      actions: data.actions,
      data: {id:data.id,test:data.test}
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
  var test = event.notification.data.test;
  console.log(eventId);
  event.notification.close();

  if (event.action === 'view_details') {
    
      clients.openWindow("/view-details?event_id=" + eventId+"&test="+test);

  }

}, false);
