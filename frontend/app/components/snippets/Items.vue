<template>
    <transition name="fade" mode="out-in">
        <div v-if="!loading" key="items" class="items">
            <template v-if="items">
                <router-link v-for="item in items" :key="item.id" :to="{name: linkName, params: { id: item.id }}" class="item">
                    <div class="title">
                        <slot name="title" :item="item"></slot>
                    </div>
                    <div class="description">
                        <slot name="description" :item="item"></slot>
                    </div>
                </router-link>
            </template>
            <template v-else>
                <div v-for="item in 5" :key="'empty-top-' + item" class="item loading">
                    <span></span>
                    <span></span>
                </div>
                <div class="item not-found">
                    <div class="title">
                        <slot name="empty"></slot>
                    </div>
                    <div class="description">
                        {{ $i18n.get('Change your search terms and try again.') }}
                    </div>
                    <div v-if="search" class="action">
                        <div class="button black small">
                            <button @click="clearSearch()">{{ $i18n.get('Clear search field') }}</button>                        
                        </div>
                    </div>
                </div>
                <div v-for="item in 13" :key="'empty-bottom-' + item" class="item loading">
                    <span></span>
                    <span></span>
                </div>
            </template>
        </div>
        <div v-else key="loading" class="items">
            <div v-for="item in preloader" :key="'loading-' + item" class="item loading">
                <span></span>
                <span></span>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        props: ['items', 'search', 'loading', 'preloader', 'link-name'],
        methods: {
            clearSearch: function() {
                if (this.search) {
                    this.search.value = '';
                }
            }
        }
    }
</script>