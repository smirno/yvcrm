<template>
    <transition name="fade" mode="out-in">
        <div v-if="!loading" key="items" class="items">
            <template v-if="items.length">
                <router-link v-for="item in items" :key="item.id" :to="{name: linkName, params: { id: item.id }}" class="items-item">
                    <div class="items-item-title">
                        <slot name="title" :item="item"></slot>
                    </div>
                    <div class="items-item-description">
                        <slot name="description" :item="item"></slot>
                    </div>
                </router-link>
            </template>
            <template v-else>
                <slot name="empty"></slot>
            </template>
        </div>
        <div v-else key="loading" class="items">
            <div v-for="item in preloader" class="items-item loading">
                <span></span>
                <span></span>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        props: [
            'items',
            'loading',
            'preloader',
            'link-name'
        ]
    }
</script>