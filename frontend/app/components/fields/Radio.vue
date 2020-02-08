<template>
    <div class="field radio" :class="{'not-label': !field.label}">
        <label v-if="field.label">{{ field.label }}</label>
        <div class="radio-buttons">
            <button  
                @click="field.value = index"
                v-for="(button, index) in field.buttons" 
                :class="{'active': field.value == index}" 
                :key="index">
                {{ $i18n.get(button.label) }}
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'field',
        ],
        name: 'field-radio',
        data() {
            return {}
        }
    }
</script>