<template>
    <div id="items">
        <transition name="fade" mode="out-in">
            <div v-if="!loading" key="contacts" class="contacts">
                <template v-if="items.length">
                    <router-link v-for="contact in items" :key="contact.id" :to="{name: 'contact', params: { id: contact.id }}" class="contacts-item">
                        <div class="contacts-item-name">
                            {{ contact.fullname }}
                        </div>
                        <div class="contacts-item-leads">{{ leadsCountString(contact.leads) }}</div>
                    </router-link>
                </template>
                <template v-else>
                    Ничего не найдено!
                </template>
            </div>
            <div v-else key="loading" class="contacts">
                <div v-for="item in preloader" class="contacts-item loading">
                    <span></span>
                    <span></span>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        props: [
            'items',
            'loading',
            'preloader'
        ],
        methods: {
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

        }
    }
</script>