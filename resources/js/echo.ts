import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

const echoConfig = {
  broadcaster: 'pusher',
  key: process.env.MIX_PUSHER_APP_KEY, // Replace with your Pusher key
  cluster: process.env.MIX_PUSHER_APP_CLUSTER, // Replace with your Pusher cluster
  encrypted: true, // If your WebSocket server uses HTTPS
};

const echo = new Echo(echoConfig);

export default echo;
