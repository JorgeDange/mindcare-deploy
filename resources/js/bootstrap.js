import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Echo (Laravel Reverb WebSocket) desactivado para InfinityFree.
// import './echo';
