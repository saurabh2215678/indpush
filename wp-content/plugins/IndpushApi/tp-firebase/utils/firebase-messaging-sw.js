importScripts('https://www.gstatic.com/firebasejs/10.3.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.3.1/firebase-messaging-compat.js');

const firebaseConfig = {
  apiKey: "AIzaSyBHE0b3Zgd79pttzD9miIUJlxinvo9jBfs",
  authDomain: "technical-pariwar.firebaseapp.com",
  databaseURL: "https://technical-pariwar.firebaseio.com",
  projectId: "technical-pariwar",
  storageBucket: "technical-pariwar.appspot.com",
  messagingSenderId: "547727670624",
  appId: "1:547727670624:web:dae741f80456ffa27bb205",
  measurementId: "G-F54YZE3EHY"
};

let clickUrl = '';
self.addEventListener('install', (event) => {
  firebase.initializeApp(firebaseConfig);
  const messaging = firebase.messaging();
});



self.addEventListener('push', (event) => {
  event.waitUntil(
    self.registration.getNotifications().then((notifications) => {
      let lastNotificationTimestamp = 0;
      if(notifications.length > 1){
        lastNotificationTimestamp = notifications[notifications.length - 2].timestamp;
      }
      notifications.forEach((notification) => {
        if (lastNotificationTimestamp - notification.timestamp < 1000 && lastNotificationTimestamp > 0) {
          if(notifications.length > 1){
            notifications[notifications.length - 2].close();
          }
        }
      });
    })
  );

  const data = event.data.json();
  console.log('eventpp>>', data);
  const options = {
    body: data.notification.body,
    icon: 'https://www.technicalpariwar.com/wp-content/uploads/2022/01/20220130_084544-300x300.jpg',
    image: data.notification.image,
    data: data.data
  };

  event.waitUntil(
    self.registration.showNotification(data.notification.title, options)
  );
});





self.addEventListener('notificationclick', function (event) {
  const clickedNotification = event.notification;
  console.log('clickedNotification', clickedNotification);
   
  clients.openWindow(clickedNotification.data.url);
  event.notification.close();

});

