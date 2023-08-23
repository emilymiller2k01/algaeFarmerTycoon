import Echo from 'laravel-echo';

declare global {
    interface Window {
        Pusher: any;
        Echo: any;
    }
}

import Pusher from 'pusher-js';



window.Pusher = Pusher;
const initWebSocket = (): void => {
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: process.env.VITE_PUSHER_APP_KEY,
        wsHost: window.location.hostname,
        wsPort: process.env.VITE_PUSHER_PORT || 6001,
        forceTLS: false,
        disableStats: true,
        enabledTransports: ['ws'],
        disabledTransports: ['wss'],
    });

    // Example listener
    window.Echo.channel('some-channel')
        .listen('.SomeEvent', (data: any) => {  // Define the type of data if known
            console.log(data);
        });
}

export default initWebSocket;
