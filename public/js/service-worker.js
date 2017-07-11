self.addEventListener('push', function(event) {
  if (event.data) {
    var data = event.data.json();
    self.registration.showNotification(data.title,{
      body: data.body,
      badge: 'https://payments.jyroneparker.com/push.png',
      icon: data.icon,
      vibrate: [300]
    });
    console.log('This push event has data: ', event.data.text());
  } else {
    console.log('This push event has no data.');
  }
});
