import Request from './../helpers/Request';
import Local from './../helpers/Local';

var Contacts = {
    namespaced: true,
    state: {
        filters: {},
        contacts: {
            update: 0,
            loading: true,
            preloader: 20,
            items: false,
        }
    },
    mutations: {
        filters: function(state, filters) {
            state.filters = filters;
        },
        contacts: function(state, contacts) {
            var preloader = Object.keys(contacts).length;

            if (!preloader) {
                preloader = state.contacts.preloader;
            }

            state.contacts.loading = false;
            state.contacts.update = Date.now();
            state.contacts.items = contacts;
            state.contacts.preloader = preloader;
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
            Request.get('/app/contacts/filters', {}, function(responce) {
                if (responce.filters) {
                    var filters = responce.filters,
                        local = Local.get('contacts-filters');

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
};


export default Contacts;