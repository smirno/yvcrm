import Vue from 'vue';
import VueRouter from 'vue-router';
import Axios from 'axios';

import Functions from './Functions.js';
import Translation from './Translation.js';
import Router from './Routes.js';

window.Functions = Functions;
window.Translation = Translation;
window.Vue = Vue;
window.Axios = Axios;

var Helpers = {
    install: function() {
        Vue.prototype.Translation = Translation;
        Vue.prototype.Functions = Functions;
    }
};

Vue.use(Helpers);
Vue.use(VueRouter);

var App = new Vue({
    el: '#app',
    router: Router,
    data: {},
    methods: {
        isActive: function(name) {
            return this.$route.name == name;
        }
    },
    created: function() {
        if (Translation.language === false) {
            Translation.translation.get();
        }
    }
});