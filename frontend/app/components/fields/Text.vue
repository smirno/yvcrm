<template>
	<div class="field text" :class="{'not-label': !field.label}">
        <input 
            v-model="field.value" 
            :type="field.type" 
            :class="{'not-empty': field.value != ''}"
            :placeholder="placeholder ? field.label : false"
        >
        <div v-if="clear && field.value" @click="field.value = ''" class="field-clear"></div>
        <label v-if="label">{{field.label}}</label>
        
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
        }
    }
</script>