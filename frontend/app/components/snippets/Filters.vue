<template>
    <div class="filters">
        <div class="filters-item" :class="filter.id" v-for="filter in filters" :key="filter.id">
            <template v-if="filter.type == 'radio'">
                <field-radio :ref="filter.id" :class="size" :field="filter"></field-radio>
            </template>
            <template v-else-if="filter.type == 'text'">
                <field-text :ref="filter.id" :class="size" clear="true" placeholder="true" :field="filter"></field-text>
            </template>
            <template v-else-if="filter.type == 'link'">
                <router-link class="button black" :class="size" tag="div" :to="filter.to">
                    <button>{{ filter.label }}</button>
                </router-link>
            </template>
        </div>
    </div>
</template>

<script>
    import Text from './../../components/fields/Text';
    import Radio from './../../components/fields/Radio';

    export default {
        components: {
            'field-text': Text,
            'field-radio': Radio,
        },
        props: ['filters', 'search', 'loading', 'size'],
        methods: {
            keyPress: function() {
                if (this.search) {
                    this.$refs[this.search.id][0].focus();
                }
            }
        },
        mounted: function() {
            window.addEventListener('keypress', this.keyPress);
        },
        beforeDestroy: function() {
            window.removeEventListener('keypress', this.keyPress);
        }
    }
</script>