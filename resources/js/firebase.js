import { initializeApp } from 'firebase/app';
import { getMessaging, getToken, onMessage  } from "firebase/messaging";
import { getAnalytics } from "firebase/analytics";
// let firebaseInit = {
//     methods: {
//         firebaseInit: function () {
//             const firebaseConfig = {
//                 apiKey: "AIzaSyAZW895vVsq-sGPPRm52fQI3V3j6yvylRc",
//                 authDomain: "push-project-e1ffa.firebaseapp.com",
//                 projectId: "push-project-e1ffa",
//                 storageBucket: "push-project-e1ffa.appspot.com",
//                 messagingSenderId: "237926722474",
//                 appId: "1:237926722474:web:46601acb7c7a30e8bc59d3",
//                 measurementId: "G-XQ36BHPE6Y"
//             };
//             firebase.initializeApp(firebaseConfig);
//
//         },
//         // isTokenSentToServer: function (currentToken) {
//         //     return (
//         //         window.localStorage.getItem("sentFirebaseMessagingToken") ===
//         //         currentToken
//         //     );
//         // },
//         // setTokenSentToServer: function (currentToken) {
//         //     window.localStorage.setItem(
//         //         "sentFirebaseMessagingToken",
//         //         currentToken ? currentToken : ""
//         //     );
//         // },
//         // sendTokenToServer: function (currentToken) {
//         //     if (!this.isTokenSentToServer(currentToken)) {
//         //         Vue.$store.dispatch('updateDeviceToken', { deviceToken: currentToken })
//         //             .then((data) => {
//         //                 this.setTokenSentToServer(currentToken);
//         //             });
//         //     }
//         // },
//     },
// };

export default async function firebaseInitialize (){
    var firebaseConfig = {
        apiKey: "AIzaSyD9i__2PHlSeMwqBPrttuOnaCHY5ghbd4c",
        authDomain: "lotofond-86a10.firebaseapp.com",
        projectId: "lotofond-86a10",
        storageBucket: "lotofond-86a10.appspot.com",
        messagingSenderId: "35580699392",
        appId: "1:35580699392:web:c65ca7ae5c9c5bf6a4c9e5",
        measurementId: "G-ZBYVKP0KNK"
    };

    // firebase.initializeApp(firebaseConfig)
    const app = initializeApp(firebaseConfig);
    const analytics = getAnalytics(app)
    if ( 'Notification' in window &&
        'serviceWorker' in navigator &&
        'localStorage' in window &&
        'fetch' in window &&
        'postMessage' in window
    ) {
        const messaging = getMessaging(app);
        try {
            console.log('try')
            getToken(messaging,{
                    vapidKey: "BI-LFBucwec4l41jhP58h9z-HT7KSRzRlh84LSM8LboYSm7ksGCz_Mu4WZQAyPa7ZRMOyIlLy7xcjACK9YSmmVE",
                })
                .then((currentToken) => {
                    console.log('currentToken', currentToken)
                    if (currentToken) {
                        sendTokenToServer(currentToken);
                    } else {
                        console.log("Failed to get token.");
                    }
                })
                .catch((err) => {
                    console.log(
                        "An error occurred while retrieving token. ",
                        err
                    );
                    setTokenSentToServer(false);
                });
        } catch (e) {
            console.log('catch')
            console.log(e);
        }
        onMessage(messaging, (payload) => {
            console.log("Message received. firebase.js ", payload);
            // new Notification(
            //     payload.notification.title,
            //     payload.notification
            // );
            navigator.serviceWorker.register("/firebase-messaging-sw.js");
            Notification.requestPermission(function(result) {
                if (result === "granted") {
                    navigator.serviceWorker.ready
                        .then(function(registration) {
                            const data = { ...payload.notification, ...payload.data };
                            const notificationTitle = data.title;
                            const notificationOptions = {
                                body: data.body,
                                icon: data.icon,
                                image: data.image,
                                click_action: data.click_action,
                                requireInteraction: true,
                                data
                            };
                            return registration.showNotification(
                                notificationTitle,
                                notificationOptions
                            );
                        })
                        .catch(function(error) {
                            console.log("ServiceWorker registration failed", error);
                        });
                }
            });
        });
    }
    else {

        console.log('This browser does not support desktop notification.');
        console.log('Is HTTPS', window.location.protocol === 'https:');
        console.log('Support Notification', 'Notification' in window);
        console.log('Support ServiceWorker', 'serviceWorker' in navigator);
        console.log('Support LocalStorage', 'localStorage' in window);
        console.log('Support fetch', 'fetch' in window);
        console.log('Support postMessage', 'postMessage' in window);
    }
    function isTokenSentToServer(currentToken) {
        return (
            window.localStorage.getItem("sentFirebaseMessagingToken") ===
            currentToken
        );
    }
    function setTokenSentToServer(currentToken) {
        window.localStorage.setItem(
            "sentFirebaseMessagingToken",
            currentToken ? currentToken : ""
        );
    }
    function sendTokenToServer(currentToken) {
        console.log('sendTokenToServer', currentToken)
        if (!isTokenSentToServer(currentToken)) {
            Vue.$store.dispatch('updateDeviceToken', { deviceToken: currentToken })
                .then((data) => {
                    console.log('updateDeviceToken', currentToken, data)
                   setTokenSentToServer(currentToken);
                });
        }
    }
};
// messaging.onMessage(function (payload) {
//     console.log("messaging.onMessage", payload)
//     if (Notification.permission !== 'granted')
//         Notification.requestPermission();
//     else {
//         const title = payload.notification.title;
//         const options = {
//             body: payload.notification.body,
//             icon: payload.notification.icon,
//         };
//         new Notification(title, options);
//         window.eventBus.emit("fcm_message_notification",JSON.parse(payload.notification.body))
//     }
// });
// messaging.onMessage(function(payload) {
//     navigator.serviceWorker.register("/firebase-messaging-sw.js");
//     Notification.requestPermission(function(result) {
//         if (result === "granted") {
//             navigator.serviceWorker.ready
//                 .then(function(registration) {
//                     const data = { ...payload.notification, ...payload.data };
//                     const notificationTitle = data.title;
//                     const notificationOptions = {
//                         body: data.body,
//                         icon: data.icon,
//                         image: data.image,
//                         click_action: data.click_action,
//                         requireInteraction: true,
//                         data
//                     };
//                     return registration.showNotification(
//                         notificationTitle,
//                         notificationOptions
//                     );
//                 })
//                 .catch(function(error) {
//                     console.log("ServiceWorker registration failed", error);
//                 });
//         }
//     });
// });

// export default firebase.messaging()
