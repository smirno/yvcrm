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
                    {{ Language.get('contacts.items.not-found', 'Not found!') }}
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
                contacts: {},
                loading: true,
                preloader: 17,
                filters: {
                    status: {
                        type: 'radio',
                        value: 1,
                        buttons: {
                            all: {
                                label: Language.get('contacts.filters.status.buttons.all', 'All')
                            },
                            0: {
                                label: Language.get('contacts.filters.status.buttons.archive', 'Archive')
                            }, 
                            1: {
                                label: Language.get('contacts.filters.status.buttons.active', 'Active')
                            }
                        }
                    },
                    search: {
                        type: 'text',
                        value: '',
                        label: Language.get('contacts.filters.search.label', 'Search')
                    },
                    create: {
                        type: 'link',
                        label: Language.get('contacts.filters.create.label', 'Create contact'),
                        to: {
                            name: 'contact',
                            params: {
                                id: 'create'
                            }
                        }
                    }
                }
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
                var declension = Functions.declension(count, Language.get('contacts.items.item.leads', ['lead', 'leads', 'leads'], true));
                if (count > 0) {
                    return count + ' ' + declension;
                } else {
                    return Language.get('contacts.items.item.no-leads', 'No') + ' ' + declension;
                }
            }
        },
        created: function() {
            document.title = Language.get('contacts.title', 'Contacts');
            // var local = Functions.local.get('contacts-filters');
            // if (local) {
            //     this.filters = local;
            // } else {
            //     this.getContacts();
            // }
            this.getContacts();
        }
    }
</script>