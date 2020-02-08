<template>
    <div class="field text" :class="{'not-label': !label}">
        <input
            v-model="field.value"
            ref="input"
            :type="field.type"
            :class="{'not-empty': field.value != ''}"
            :placeholder="placeholder ? $i18n.get(field.label) : false"
        >
        <div v-if="clear && field.value" @click="field.value = ''" class="field-clear"></div>
        <label v-if="label">
            {{ $i18n.get(field.label) }}
        </label>
    </div>
</template>

<script>
    export default {
        props: [
            'field',
            'placeholder',
            'clear'
        ],
        name: 'field-text',
        data() {
            return {}
        },
        computed: {
            label: function() {
                if (this.placeholder) {
                    return false;
                } else {
                    return true;
                }
            }
        },
        methods: {
            focus: function() {
                this.$refs.input.focus();
            }
        },
        created: function() {}
    }
</script>