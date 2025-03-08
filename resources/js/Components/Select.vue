<script setup>
import { ref, useSlots } from 'vue';
const slots = useSlots()
const props = defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    options: {
        type: Object,
    },

    validation: {
        type: Boolean
    },
    label: {
        type: String
    },
    valueField: {
        type: String
    },
    height: {
        type: String
    },
    disabled: {
        type: Boolean
    },
    width: {
        type: String
    },
    allOption: {
        type: Boolean
    },
    severityOption: {
        type: Boolean
    },
    enable_select_item: {
        type: Boolean
    },



});

const errorClass = 'bg-red-50 border border-red-500 text-red-900 h-[40px] mt-[3.7px] px-[10px] py-[8px] shadow-sm text-sm rounded-[6px] focus:ring-blue-500 focus:border-blue-500 block w-full'
const classes = 'border border-[#E5E7EB] h-[40px] mt-[3.7px] px-[10px] py-[8px] shadow-sm text-sm rounded-[6px] focus:ring-blue-500 focus:border-blue-500 block w-full'


const emit = defineEmits(['update:modelValue', 'change']);
const input = ref(null);

function change(event) {
    emit('update:modelValue', event.target.value)
    emit('change', event.target.value)
}
function setLabel(item) {
    if (props.label) return item[props.label]
    else return item.name
}

function setValue(item) {
    if (props.valueField) return item[props.valueField]
    else return item.id
}
</script>

<template>
    <select id="type" :value="modelValue" @change="change($event)" ref="input" :disabled="disabled"
        :class="slots.validationMessage ? errorClass : classes" :style="'width:' + width ?? ''">
        <option v-if="allOption" value="all" selected>All</option>
        <option v-if="severityOption" disabled selected>No Severities</option>
        <option v-if="severityOption" disabled selected>No Severities</option>
        <option v-if="enable_select_item" value="">Select Item</option>
        <option v-if="!enable_select_item" selected disabled>Select Item</option>
        <option v-for="(item, item_index) in options" :value="setValue(item)" :key="item_index"
            :disabled="disabled && !item.status ? true : false">{{ setLabel(item) }}</option>
    </select>
    <p class="mt-1 text-sm text-red-600 font-jakarta-normal" v-if="slots?.validationMessage">
        <slot name="validationMessage" />
    </p>
</template>
