<template>
    <div id="leads">
        <transition name="fade" mode="out-in">
            <div v-if="!loading" key="leads" class="content">
                <div class="leads">
                    <router-link v-for="lead in leads" :key="lead.id" :to="{name: 'lead', params: { id: lead.id }}" class="leads-item">
                        <div class="leads-item-name">
                            {{ lead.name }}
                        </div>
                        <div class="leads-item-contact">{{ lead.contact }}</div>
                    </router-link>
                    <router-link key="new" :to="{name: 'lead', params: { id: 'create' }}" class="leads-item new">
                        <span>
                            <i class="glyphicon glyphicon-plus"></i> Новая сделка
                        </span>
                    </router-link>
                </div>
            </div>
            <div v-else key="loading" class="content">
                <div class="leads">
                    <div v-for="item in preloader" class="leads-item loading">
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
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