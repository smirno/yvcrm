<template>
    <div id="contacts">
        <div class="content">
            <snippet-filters :filters="filters" :search="search" :loading="loading.contacts" size="small"></snippet-filters>
            <snippet-items :items="contacts" :search="search" :loading="loading.contacts" :preloader="preloader" link-name="contact">
                <template #title="{item: contact}">
                    {{ contact.fullname }}
                </template>
                <template #description="{item: contact}">
                    {{ leadsCountString(contact.leads) }}
                </template>
                <template #empty>
                    {{ $i18n.get('Contacts not found!') }}
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
                loading: {
                    contacts: true,
                    filters: true
                },
                preloader: 17
            }
        },
        computed: {
            search: function() {
                var search = false;

                if (this.filters.length) {
                    this.filters.map(function(filter) {
                        if (filter.id == 'search') {
                            search = filter;
                        }
                    });
                }

                return search;
            }
        },
        watch: {
            filters: {
                handler: function() {
                    this.$local.set('contacts-filters', this.filters);
                    this.getContacts();
                },
                deep: true
            },
        },
        methods: {
            getFilters: function() {
                var self = this,
                    local = self.$local.get('contacts-filters');

                self.loading.filters = true;

                self.$request.get('/app/contacts/filters', {}, function(responce) {
                    if (responce.filters) {
                        self.filters = responce.filters;

                        if (local) {
                            for (var filter in self.filters) {
                                if (local[filter]) {
                                    self.filters[filter].value = local[filter].value;
                                }
                            }
                        }

                        self.loading.filters = false;
                    }
                }, function(responce) {
                    self.getContacts();
                    self.loading.filters = false;
                });
            },
            getContacts: function() {
                var self = this,
                    filters = {};

                self.loading.contacts = true;

                if (self.filters.length) {
                    self.filters.map(function(filter) {
                        if (filter.value) {
                            filters[filter.id] = filter.value;
                        }
                    });
                }

                self.$request.get('/app/contacts', filters, function(responce) {
                    if (responce.contacts) {
                        self.contacts = responce.contacts;
                        self.preloader = responce.contacts.length;
                        self.loading.contacts = false;
                    }
                }, function(responce) {
                    self.contacts = {};
                    self.loading.contacts = false;
                });
            },
            leadsCountString: function(count) {
                return this.$i18n.get('{leads, plural, =0{No leads} =1{1 lead} other{# leads}}', {'leads': count});
            }
        },
        created: function() {
            this.getFilters();
        }
    }
</script>