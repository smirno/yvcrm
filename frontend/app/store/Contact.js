import Request from './../helpers/Request';
import Local from './../helpers/Local';

var Contact = {
    namespaced: true,
    state: function() {
        return {
            update: 0,
            loading: true,
            preloader: 6,
            fields: false,
        }
    },
    mutations: {
        contact: function(state, contacts) {
            var preloader = Object.keys(contacts).length;

            if (!preloader) {
                preloader = state.preloader;
            }

            state.loading = false;
            state.update = Date.now();
            state.items = contacts;
            state.preloader = preloader;
        }
    },
    actions: {
        getContact: function(context) {
            if (context.state.filters) {
                var filters = {};

                for (var [index, filter] of Object.entries(context.state.filters)) {
                    if (filter.value) {
                        filters[filter.id] = filter.value;
                    }
                }

                Local.set('contacts-filters', filters);

                context.state.loading = true;

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


export default Contact;