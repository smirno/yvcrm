<template>
    <div id="contacts">
        <div class="content">
            <snippet-filters :filters="filters" :search="search" size="small"></snippet-filters>
            <snippet-items :items="items" :search="search" :loading="loading" :preloader="preloader" link-name="contact">
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
    import { mapState, mapActions } from 'vuex';

    import Filters from './../../components/snippets/Filters';
    import Items from './../../components/snippets/Items';

    export default {
        components: {
            'snippet-filters': Filters,
            'snippet-items': Items,
        },
        computed: {
            ...mapState('contacts', [
                'update',
                'loading',
                'preloader',
                'filters',
                'items'
            ]),
            search: function() {
                var search = false;

                if (this.filters) {
                    for (var [index, filter] of Object.entries(this.filters)) {
                        if (filter.id == 'search') {
                            search = filter;
                        }
                    }
                }

                return search;
            }
        },
        watch: {
            filters: {
                handler: function() {
                    this.getContacts();
                },
                deep: true
            },
        },
        methods: {
            ...mapActions('contacts', {
                getContacts: 'getContacts'
            }),
            leadsCountString: function(count) {
                return this.$i18n.get('{leads, plural, =0{No leads} =1{1 lead} other{# leads}}', {'leads': count});
            }
        },
        created: function() {
            if (this.update < Date.now() - 30000) {
                this.getContacts();
            }
        }
    }
</script>