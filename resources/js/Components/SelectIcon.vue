<script setup>
import { ref, useSlots } from 'vue';
const slots = useSlots()
defineProps({
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
	enable_select_item: {
		type: Boolean,
	}

});

const errorClass = 'pl-9 bg-red-50 border border-red-500 text-red-900 h-[40px] mt-[3.7px] px-[10px] py-[8px] shadow-sm text-sm rounded-[6px] focus:ring-blue-500 focus:border-blue-500 block w-full'
const classes = 'pl-9 border border-[#E5E7EB] h-[40px] mt-[3.7px] px-[10px] py-[8px] shadow-sm text-sm rounded-[6px] focus:ring-blue-500 focus:border-blue-500 block w-full'

const emit = defineEmits(['update:modelValue', 'change']);
const input = ref(null);

function change(event) {
	emit('update:modelValue', event.target.value)
	emit('change', event.target.value)
}

</script>

<template>
	<div class="relative">
		<div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
			<slot name="prefixIcon" />
		</div>
		<select id="type" :value="modelValue" @change="change($event)" ref="input"
			:class="slots.validationMessage ? errorClass : classes">
			<option v-if="enable_select_item" value="">Select Item</option>
			<option v-if="!enable_select_item" selected disabled>Select Item</option>
			<option v-for="item in options" :value="item.id">{{ item.name }}</option>
		</select>
		<p class="mt-1 text-sm text-red-600 font-jakarta-normal" v-if="slots?.validationMessage">
			<slot name="validationMessage" />
		</p>
	</div>
</template>
