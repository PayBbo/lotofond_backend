// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
// importScripts('https://www.gstatic.com/firebasejs/9.15.0/firebase-app.js');
// importScripts('https://www.gstatic.com/firebasejs/9.15.0/firebase-messaging.js');
import { initializeApp } from 'firebase/app';
import { getMessaging } from "firebase/messaging";
import { onBackgroundMessage } from "firebase/messaging/sw";
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
const app = initializeApp({
    apiKey: "AIzaSyD9i__2PHlSeMwqBPrttuOnaCHY5ghbd4c",
    authDomain: "lotofond-86a10.firebaseapp.com",
    projectId: "lotofond-86a10",
    storageBucket: "lotofond-86a10.appspot.com",
    messagingSenderId: "35580699392",
    appId: "1:35580699392:web:c65ca7ae5c9c5bf6a4c9e5",
    measurementId: "G-ZBYVKP0KNK"
});
// firebase.initializeApp({
//     apiKey: "AIzaSyD9i__2PHlSeMwqBPrttuOnaCHY5ghbd4c",
//     authDomain: "lotofond-86a10.firebaseapp.com",
//     projectId: "lotofond-86a10",
//     storageBucket: "lotofond-86a10.appspot.com",
//     messagingSenderId: "35580699392",
//     appId: "1:35580699392:web:c65ca7ae5c9c5bf6a4c9e5",
//     measurementId: "G-ZBYVKP0KNK"
// });

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
// const messaging = firebase.messaging();
const messaging = getMessaging(app);

// messaging.setBackgroundMessageHandler(function (payload) {
//     const title = "Lotofond";
//     const notificationOptions = {
//         body: payload.data.body || 'У вас новое уведомление!',
//         icon: payload.data.image || '/images/favicon/android-chrome-256x256.png',
//     };
//     return self.registration.showNotification(
//         title,
//         notificationOptions,
//     );
// });
onBackgroundMessage(messaging, (payload) => {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationTitle = 'Lotofond';
    const notificationOptions = {
        body: payload.data.body || 'У вас новое уведомление!',
        icon: payload.data.image || '/images/favicon/android-chrome-256x256.png',
    };

    return self.registration.showNotification(notificationTitle,
        notificationOptions);
});

// свой обработчик клика по уведомлению
self.addEventListener('notificationclick', function(event) {
    // извлекаем адрес перехода из параметров уведомления
    const target = event.notification.data.click_action || '/';
    event.notification.close();

    // этот код должен проверять список открытых вкладок и переключатся на открытую
    // вкладку с ссылкой если такая есть, иначе открывает новую вкладку
    event.waitUntil(clients.matchAll({
        type: 'window',
        includeUncontrolled: true
    }).then(function(clientList) {
        for (var i = 0; i < clientList.length; i++) {
            var client = clientList[i];
            if (client.url === target && 'focus' in client) {
                return client.focus();
            }
        }

        // Открываем новое окно
        return clients.openWindow(target);
    }));
});
