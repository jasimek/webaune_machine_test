<script setup>
import { computed, onMounted, ref,useSlots } from 'vue';
const slots = useSlots()

defineProps({
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
    },
    style : {
        type: String
    }

});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
    
});

defineExpose({ focus: () => input.value.focus() });

const labelClass = 'block mb-1 text-[#333333] font-jakarta-semibold text-sm';
const labelErroClass = 'block mb-1 text-red-700 font-jakarta-semibold text-sm';
const inputClass = 'border border-[#E5E7EB] text-gray-900 text-[13px] rounded-md font-jakarta-normal focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 placeholder:font-jakarta-normal placeholder:text-[#B2B2B2] placeholder:text-[13px]';
const inputErrorClass = 'border border-red-500  text-[13px] rounded-md font-jakarta-normal focus:ring-red-500  focus:border-red-500 block w-full pl-10  placeholder:font-jakarta-normal placeholder:text-red-700  placeholder:text-[13px]';

</script>
<template>
    <div>
        <label :class='slots.validationMessage ? labelErroClass : labelClass'>{{ label }}</label>

        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                <slot name="prefixIcon" />
            </div>
            <input :style="style"
            :class='slots.validationMessage ? inputErrorClass : inputClass' :type="type"
                :placeholder="placeholder" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
                ref="input" :disabled='disabled' :required="required" :readonly="readonly">
        </div>
        <slot name="helper" v-if="slots.helper" />
        <p class="text-sm text-red-600 font-jakarta-normal" v-if="slots.validationMessage">
            <slot name="validationMessage" />
        </p>
    </div>
</template>
