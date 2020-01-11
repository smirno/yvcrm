import Vue from 'vue';
import VueRouter from 'vue-router';
import Axios from 'axios';

import Functions from './Functions.js';
import Language from './Language.js';
import Router from './Routes.js';

var Helpers = {
    install: function(Vue, options) {
        Vue.prototype.Language = Language;
        Vue.prototype.Functions = Functions;
    }
};

Vue.use(VueRouter);
Vue.use(Helpers);

window.Functions = Functions;
window.Language = Language;
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