<template>
    <div class="filters">
        <div class="filters-item" :class="index" v-for="(filter, index) in filters" :key="index">
            <template v-if="filter.type == 'radio'">
                <field-radio :ref="index" :class="size" :field="filter"></field-radio>
            </template>
            <template v-else-if="filter.type == 'text'">
                <field-text :ref="index" :class="size" clear="true" placeholder="true" :field="filter"></field-text>
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
        props: [
            'filters',
            'key-press-focus',
            'size'
        ],
        methods: {
            keyPress: function() {
                this.$refs[this.keyPressFocus][0].focus();
            }
        },
        mounted: function() {
            if (this.keyPressFocus != undefined) {
                window.addEventListener('keypress', this.keyPress);
            }
        },
        beforeDestroy: function() {
            if (this.keyPressFocus != undefined) {
                window.removeEventListener('keypress', this.keyPress);
            }
        }
    }
</script>