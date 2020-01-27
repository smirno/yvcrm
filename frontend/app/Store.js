import Vue from 'vue';
import Vuex from 'vuex';

import Request from './helpers/Request';
import Local from './helpers/Local';
import { time } from 'format-message';

Vue.use(Vuex);

var Store = new Vuex.Store({
    state: {
        filters: {},
        contacts: {
            update: 0,
            loading: true,
            preloader: 17,
            items: false,
        }
    },
    mutations: {
        filters: function(state, filters) {
            state.filters = filters;
        },
        contacts: function(state, contacts) {
            state.contacts.loading = false;
            state.contacts.update = Date.now();
            state.contacts.items = contacts;
            state.contacts.preloader = contacts.length;
        }
    },
    getters: {
        contacts: function(state) {
            return state.contacts;
        },
        filters: function(state) {
            return state.filters;
        }
    },
    actions: {
        init: function(context) {
            context.dispatch('getFilters');
            context.dispatch('getContacts');
        },
        getFilters: async function(context) {
            var local = Local.get('contacts-filters');

            Request.get('/app/contacts/filters', {}, function(responce) {
                if (responce.filters) {
                    var filters = responce.filters;

                    if (local) {
                        for (var filter in filters) {
                            if (local[filter]) {
                                filters[filter].value = local[filter].value;
                            }
                        }
                    }

                    context.commit('filters', filters);
                }
            }, function() {
                context.commit('filters', {});
            });
        },
        getContacts: function(context) {
            if (context.state.filters.length) {
                var filters = {};

                context.state.filters.map(function(filter) {
                    if (filter.value) {
                        filters[filter.id] = filter.value;
                    }
                });

                context.state.contacts.loading = true;

                Request.get('/app/contacts', filters, function(responce) {
                    if (responce.contacts) {
                        context.commit('contacts', responce.contacts);
                    }
                }, function() {
                    context.commit('contacts', false);
                });
            }
        }
    }
});


export default Store;