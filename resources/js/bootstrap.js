window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

/* Sweet Alert 2 */
window.Swal = require('sweetalert2');

/* Laravel Echo */
import Echo from "laravel-echo"

window.io = require('socket.io-client');

if (window.location.hostname === 'localhost' || window.location.hostname === 'sdn.test')
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: window.location.hostname + ':6001',
    });
else
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: window.location.hostname,
        path: '/ws/socket.io',
    });
