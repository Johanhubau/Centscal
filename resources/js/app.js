/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
import Vuetify from 'vuetify';

window.Vue = require('vue');
require('./bootstrap');

const vuetifyOptions = {
    icons: {
        iconfont: 'mdi',
    },
};
Vue.use(Vuetify);

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

//MAIN COMPONENTS
Vue.component('home-calendar-component', require('./components/HomeCalendarComponent.vue').default);
Vue.component('room-material-manager', require('./components/RoomMaterialManagerComponent.vue').default);

//ASSOCIATION COMPONENTS
Vue.component('public-association-card', require('./components/associations/publicCardComponent.vue').default);
Vue.component('private-association-card', require('./components/associations/privateCardComponent.vue').default);
Vue.component('create-association-card', require('./components/associations/createCardComponent.vue').default);
Vue.component('association-dashboard', require('./components/associations/dashboardComponent.vue').default);

//EVENT COMPONENTS
Vue.component('create-event-card', require('./components/events/createCardComponent.vue').default);
Vue.component('private-event-card', require('./components/events/privateCardComponent.vue').default);
Vue.component('update-event-card', require('./components/events/updateCardComponent.vue').default);

//MATERIAL COMPONENTS
Vue.component('create-material-card', require('./components/materials/CreateCardComponent.vue').default);
Vue.component('material-card', require('./components/materials/CardComponent.vue').default);
Vue.component('update-material-card', require('./components/materials/updateCardComponent.vue').default);

//RENT COMPONENTS
Vue.component('update-rent-card', require('./components/rents/AdminUpdateComponent.vue').default);

//ROOM COMPONENTS
Vue.component('create-room-card', require('./components/rooms/CreateCardComponent.vue').default);
Vue.component('room-card', require('./components/rooms/CardComponent.vue').default);
Vue.component('update-room-card', require('./components/rooms/updateCardComponent.vue').default);

//OCCUPATION COMPONENTS
Vue.component('update-occupation-card', require('./components/occupations/AdminUpdateComponent.vue').default);


//USER COMPONENTS
Vue.component('private-user-card', require('./components/users/privateCardComponent.vue').default);
Vue.component('update-user-card', require('./components/users/UpdateAdminCardComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(vuetifyOptions)
});
