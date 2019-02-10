require('./bootstrap');

window.Vue = require('vue');

// window.events = new Vue();

window.flash = function(message) {
    window.events.$emit('flash',message);
};

let axios = require('axios');

Vue.component('users', require('./components/UsersComponent.vue').default);

const app = new Vue({
    el: '#app'
});
