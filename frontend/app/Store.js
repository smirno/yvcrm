import Vue from 'vue';
import Vuex from 'vuex';

import Contacts from './store/Contacts';

Vue.use(Vuex);

var Store = new Vuex.Store({
    state: {
        filters: {
            test: 1000
        },
    },
    modules: {
        contacts: Contacts
    },
    actions: {
        init: function(context) {
            
        }
    }
});


export default Store;