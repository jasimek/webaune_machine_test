<script setup>

defineProps({
	active: {
		type: Boolean,
	},
});
</script>


<template>
	<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
		<path
			d="M10.1302 9.05573C10.0469 9.0474 9.94687 9.0474 9.85521 9.05573C7.87187 8.98906 6.29688 7.36406 6.29688 5.36406C6.29687 3.3224 7.94687 1.66406 9.99687 1.66406C12.0385 1.66406 13.6969 3.3224 13.6969 5.36406C13.6885 7.36406 12.1135 8.98906 10.1302 9.05573Z"
			:stroke="active ? '#FFFFFF' : '#B2B2B2'" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
		<path
			d="M5.96563 12.1359C3.94896 13.4859 3.94896 15.6859 5.96563 17.0276C8.25729 18.5609 12.0156 18.5609 14.3073 17.0276C16.324 15.6776 16.324 13.4776 14.3073 12.1359C12.024 10.6109 8.26562 10.6109 5.96563 12.1359Z"
			:stroke="active ? '#FFFFFF' : '#B2B2B2'" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
	</svg>
</template>