<script setup>
import { onMounted, ref, useSlots } from 'vue';
const slots = useSlots()

const props = defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        required: true
    },
    class: {
        type: String
    },
    ref: {
        type: String
    },
    placeholder: {
        type: String
    },
    disabled: {
        type: String
    },
    label: {
        type: String
    },
    required: {
        type: String
    },
    readonly: {
        type: String
    }

});
const classes = 'block border-[#E5E7EB] focus:border-indigo-500 focus:ring-indigo-500 rounded-[6px] shadow-sm text-[13px] placeholder:font-jakarta-normal placeholder:text-[#B2B2B2] placeholder:text-[13px] w-full';
const errorClass = 'block bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500  focus:border-red-500 block w-full placeholder:font-jakarta-normal placeholder:text-red-700  placeholder:text-[13px]';
const readonlyClass = 'block border-[#E5E7EB] focus:border-indigo-500 focus:ring-indigo-500 rounded-[6px] shadow-sm text-[13px] placeholder:font-jakarta-normal placeholder:text-[#B2B2B2] placeholder:text-[13px] w-full bg-[#E5E7EB] cursor-not-allowed';
defineEmits(['update:modelValue','enter_function']);
const input = ref(null);
onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});
defineExpose({ focus: () => input.value.focus() });

</script>
<template>
    <input :class="slots?.validationMessage ? errorClass : readonly ? readonlyClass :classes"  :placeholder="placeholder" :value="modelValue"
        :type="type" @keyup.enter="$emit('enter_function')" @input="$emit('update:modelValue', $event.target.value)" ref="input" :style="disabled?'--tw-text-opacity: 1;color: rgb(107 114 128 / var(--tw-text-opacity));':''"
        :disabled='disabled' :required="required" :readonly="readonly" />
    <p class="mt-1 text-sm text-red-600 font-jakarta-normal" v-if="slots.validationMessage">
        <slot name="validationMessage" />
    </p>
</template>