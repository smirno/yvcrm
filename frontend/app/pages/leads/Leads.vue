<template>
    <div id="leads">
        <div class="content">
            <snippet-items :items="leads" :loading="loading" :preloader="preloader" link-name="lead">
                <template #title="{item: lead}">
                    {{ lead.name }}
                </template>
                <template #description="{item: lead}">
                    {{ lead.contact }}
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
                leads: {},
                loading: true,
                preloader: 10,
            }
        },
        watch: {
            // $route: function(to, from) {
            //     console.log(to, from);
            // }
        },
        created: function() {
            var self = this;
            Functions.request.get('/app/leads', null, function(responce) {
                if (responce) {
                    self.leads = responce;
                    self.loading = false;
                    if (!self.$route.hash) {
                        self.$router.push({name: 'leads', hash: '#1000'});
                    }
                }
            });
        }
    }
</script>