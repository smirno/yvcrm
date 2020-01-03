<template>
    <div id="contacts">
        <div class="content">
            <div class="filters">
                <div class="filters-item" :class="index" v-for="(filter, index) in filters" :key="index">
                    <template v-if="filter.type == 'radio'">
                        <div class="field small" :class="[{'not-label': !filter.label}, filter.type]">
                            <label v-if="false">{{ filter.label }}</label>
                            <div class="radio-buttons">
                                <button  
                                    @click="filter.value = index"
                                    v-for="(button, index) in filter.buttons" 
                                    :class="{'active': filter.value == index}" 
                                    :key="index">
                                    {{ button.label }}
                                </button>
                            </div>
                        </div>
                    </template>
                    <template v-else-if="filter.type == 'text'">
                        <field-text class="small" :clear="true" :placeholder="true" :field="filter"></field-text>
                    </template>
                </div>
                <div class="filters-item create">
                    <router-link class="button black small" tag="div" key="new" :to="{name: 'contact', params: { id: 'create' }}">
                        <button>Новый контакт</button>
                    </router-link>
                </div>
            </div>
            <contacts 
                :items="contacts" 
                :loading="loading"
                :preloader="preloader"
            ></contacts>
        </div>
    </div>
</template>

<script>
    import Text from './../../components/fields/Text';
    import Items from './../../components/snippets/Items';

    export default {
        components: {
            'field-text': Text,
            'contacts': Items,
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
                        label: 'Статус',
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
                        label: 'Поиск',
                    },
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
        computed: {
            
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
            if (local) {
                this.filters = local;
            } else {
                this.getContacts();            
            }
        }
    }
</script>