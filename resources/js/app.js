/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('Barangayinfo', require('./components/Admin/Barangayinfo.vue').default);
Vue.component('Login', require('./components/Auth/Login.vue').default);
Vue.component('Comittee', require('./components/Admin/Comittee.vue').default);
Vue.component('Position', require('./components/Admin/Position.vue').default);
Vue.component('User', require('./components/Admin/User.vue').default);
Vue.component('Purok', require('./components/Barangay/Purok.vue').default);
Vue.component('Barangayofficial', require('./components/Barangay/Barangayofficial.vue').default);
Vue.component('Household', require('./components/Barangay/Household.vue').default);
Vue.component('Createmember', require('./components/Barangay/Createmember.vue').default);
Vue.component('Edithousehold', require('./components/Barangay/Edithousehold.vue').default);
Vue.component('Viewhousehold', require('./components/Barangay/Viewhousehold.vue').default);
Vue.component('Blotter', require('./components/Barangay/Blotter.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
