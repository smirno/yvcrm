<template>
    <div id="contacts">
        <div class="content">
            <snippet-filters :filters="filters" key-press-focus="search" size="small"></snippet-filters>
            <snippet-items :items="contacts" :loading="loading" :preloader="preloader" link-name="contact">
                <template #title="{item: contact}">
                    {{ contact.fullname }}
                </template>
                <template #description="{item: contact}">
                    {{ leadsCountString(contact.leads) }}
                </template>
                <template #empty>
                    {{ Translation.get('app.contacts.items.not-found', 'Not found!') }}
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
                    if (responce) {
                        self.filters = responce;
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
                    if (responce) {
                        self.contacts = responce;
                        self.loading = false;
                        self.preloader = self.contacts.length;
                    }
                }, function(responce) {
                    self.contacts = {};
                    self.loading = false;
                });
            },
            leadsCountString: function(count) {
                var translation = Translation.get('app.contacts.items.item.leads', ['lead', 'leads', 'leads']),
                    declension = Functions.declension(count, translation);

                if (count > 0) {
                    return count + ' ' + declension;
                } else {
                    return Translation.get('app.contacts.items.item.no-leads', 'No {leads}', {'leads': declension});
                }
            }
        },
        created: function() {
            document.title = Translation.get('app.contacts.title', 'Contacts');
            this.getFilters();
        }
    }
</script>