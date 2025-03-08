<script setup>
defineProps({
    value: {
        type: String,
    },

    validation:{
        type: Boolean
    }
    
});

const errorClass =  'block mb-1 text-red-700 font-jakarta-semibold text-sm'
const classes =  'block mb-1 text-[#333333] font-jakarta-semibold text-sm'
</script>

<template>
    <label :class="validation? errorClass: classes">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
