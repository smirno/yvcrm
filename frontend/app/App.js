import Vue from 'vue';
import VueRouter from 'vue-router';
import Axios from 'axios';

import Functions from './Functions.js';
import Router from './Routes.js';

Axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.use(VueRouter);

window.Functions = Functions;
window.Vue = Vue;
window.Axios = Axios;

var App = new Vue({
    el: '#app',
    router: Router,
    data: {},
    methods: {
        isActive: function(name) {
            return this.$route.name == name;
        }
    }
});