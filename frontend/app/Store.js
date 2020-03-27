import Vue from 'vue';
import Vuex from 'vuex';

import Contacts from './store/Contacts';

Vue.use(Vuex);

var Store = new Vuex.Store({
    modules: {
        contacts: Contacts
    },
    actions: {
        init: function(context) {
            
        }
    }
});


export default Store;