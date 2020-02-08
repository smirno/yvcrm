import Vue from 'vue';

import Router from './Routes';
import Store from './Store';

import Functions from './helpers/Functions';
import Request from './helpers/Request';
import Local from './helpers/Local';
import I18N from './helpers/I18N';

window.Functions = Functions;

var Helpers = {
    install: function() {
        Vue.prototype.$functions = Functions;
        Vue.prototype.$request = Request;
        Vue.prototype.$local = Local;
        Vue.prototype.$i18n = I18N;
    }
};

Vue.use(Helpers);

var App = new Vue({
    el: '#app',
    router: Router,
    store: Store,
    data: {},
    methods: {
        isActive: function(name) {
            return this.$route.name == name;
        },
        toggleTheme: function() {
            var theme = this.$functions.theme();

            if (theme == 'dark-mode') {
                theme = 'light-mode';
            } else {
                theme = 'dark-mode';
            }

            this.$functions.theme(theme);
            this.$local.set('theme', theme);
        }
    },
    created: function() {
        var theme = this.$local.get('theme');

        if (theme) {
            this.$functions.theme(theme);
        }

        if (Render != undefined) {

            if (Render.translation) {
                this.$i18n.translation.set(Render.translation);
            }
        }
    }
});