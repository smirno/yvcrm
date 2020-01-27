<template>
    <div id="contacts">
        <div class="content">
            <snippet-filters :filters="filters" :search="search" size="small"></snippet-filters>
            <snippet-items :items="contacts.items" :search="search" :loading="contacts.loading" :preloader="contacts.preloader" link-name="contact">
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
            ...mapState({
                filters: 'filters',
                contacts: 'contacts'
            }),
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
            ...mapActions({
                initContacts: 'init',
                getContacts: 'getContacts'
            }),
            leadsCountString: function(count) {
                return this.$i18n.get('{leads, plural, =0{No leads} =1{1 lead} other{# leads}}', {'leads': count});
            }
        },
        created: function() {
            if (!this.filters.length) {
                this.initContacts();
            }
            if (this.contacts.update < Date.now() - 30000) {
                this.getContacts()
            }
        }
    }
</script>