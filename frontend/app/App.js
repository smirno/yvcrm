import Vue from 'vue';
import VueRouter from 'vue-router';

import Functions from './Functions.js';
import I18N from './I18N.js';
import Router from './Routes.js';

window.Functions = Functions;
window.I18N = I18N;

var Helpers = {
    install: function() {
        Vue.prototype.Functions = Functions;
        Vue.prototype.I18N = I18N;
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
        },
        toggleTheme: function() {
            var theme = Functions.theme();

            if (theme == 'dark-mode') {
                theme = 'light-mode';
            } else {
                theme = 'dark-mode';
            }

            Functions.theme(theme);
        }
    },
    created: function() {

        // Включить темную тему
        Functions.theme('dark-mode');

        if (I18N.language === false) {
            I18N.translation.get();
        }
    }
});