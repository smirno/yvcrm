<template>
    <div id="contacts">
        <div class="content">
            <snippet-filters :filters="filters" size="small"></snippet-filters>
            <snippet-items :items="contacts" :search="search" :loading="loading" :preloader="preloader" link-name="contact">
                <template #title="{item: contact}">
                    {{ contact.fullname }}
                </template>
                <template #description="{item: contact}">
                    {{ leadsCountString(contact.leads) }}
                </template>
                <template #empty>
                    {{ I18N.get('Contacts not found!') }}
                </template>
            </snippet-items>
        </div>
    </div>
</template>

<script>
    import Filters from './../../components/snippets/Filters';
    import Items from './../../components/snippets/Items';

    export default {
        components: {
            'snippet-filters': Filters,
            'snippet-items': Items,
        },
        data() {
            return {
                filters: {},
                contacts: {},
                loading: true,
                preloader: 17
            }
        },
        computed: {
            search: function() {
                if (this.filters.search != undefined) {
                    return this.filters.search;
                }

                return false;
            }
        },
        watch: {
            filters: {
                handler: function() {
                    this.getContacts();
                    Functions.local.set('contacts-filters', this.filters);
                },
                deep: true
            },
        },
        methods: {
            getFilters: function() {
                var self = this,
                    local = Functions.local.get('contacts-filters');

                Functions.request.get('/app/contacts/filters', {}, function(responce) {
                    if (responce.filters) {
                        self.filters = responce.filters;
                        if (local) {
                            for (var filter in self.filters) {
                                if (local[filter]) {
                                    self.filters[filter].value = local[filter].value;
                                }
                            }
                        }
                    }
                }, function(responce) {
                    self.getContacts();
                });
            },
            getContacts: function() {
                var self = this,
                    filters = {};

                self.loading = true;

                for (var filter in self.filters) {
                    if (self.filters[filter].value) {
                        filters[filter] = self.filters[filter].value;
                    }
                }

                Functions.request.get('/app/contacts', filters, function(responce) {
                    if (responce.contacts) {
                        self.contacts = responce.contacts;
                        self.preloader = responce.contacts.length;
                        self.loading = false;
                    }
                }, function(responce) {
                    self.contacts = {};
                    self.loading = false;
                });
            },
            leadsCountString: function(count) {
                return I18N.get('{leads, plural, =0{No leads} =1{1 lead} other{# leads}}', {'leads': count});
            }
        },
        created: function() {
            this.getFilters();
        }
    }
</script>