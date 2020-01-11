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
                    Ничего не найдено!
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
                                label: 'Все'
                            },
                            0: {
                                label: 'Архив'
                            }, 
                            1: {
                                label: 'Активные'
                            }
                        }
                    },
                    search: {
                        type: 'text',
                        value: '',
                        label: 'Поиск'
                    },
                    create: {
                        type: 'link',
                        label: 'Новый контакт',
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
                var declension = Functions.declension(count, ['сделка', 'сделки', 'сделок']);
                if (count > 0) {
                    return count + ' ' + declension;
                } else {
                    return 'Нет ' + declension;
                }
            }
        },
        created: function() {
            document.title = 'Контакты';
            var local = Functions.local.get('contacts-filters');
            // if (local) {
            //     this.filters = local;
            // } else {
            //     this.getContacts();
            // }
            this.getContacts();
        }
    }
</script>