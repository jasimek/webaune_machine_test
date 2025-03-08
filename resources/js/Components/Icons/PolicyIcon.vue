<script setup>

defineProps({
	active: {
		type: Boolean,
	},
});
</script>

<template>
	<svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
		<path
			d="M17.0807 9.91405V6.36407C17.0807 3.00574 16.2974 2.16406 13.1474 2.16406H6.8474C3.6974 2.16406 2.91406 3.00574 2.91406 6.36407V15.7474C2.91406 17.9641 4.13074 18.4891 5.60574 16.9057L5.61405 16.8974C6.29739 16.1724 7.33905 16.2307 7.93072 17.0224L8.7724 18.1474"
			:stroke="active ? '#FFFFFF' : '#B2B2B2'" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
		<path d="M6.66406 6.33594H13.3307" :stroke="active ? '#FFFFFF' : '#B2B2B2'" stroke-width="1.5" stroke-linecap="round"
			stroke-linejoin="round" />
		<path d="M7.5 9.66406H12.5" :stroke="active ? '#FFFFFF' : '#B2B2B2'" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
		<path
			d="M15.1784 12.8056L12.2285 15.7556C12.1118 15.8723 12.0034 16.089 11.9784 16.2473L11.8201 17.3723C11.7618 17.7806 12.0451 18.064 12.4535 18.0057L13.5785 17.8473C13.7368 17.8223 13.9618 17.714 14.0701 17.5973L17.0201 14.6473C17.5285 14.139 17.7701 13.5473 17.0201 12.7973C16.2785 12.0557 15.6868 12.2973 15.1784 12.8056Z"
		:stroke="active ? '#FFFFFF' : '#B2B2B2'" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
	<path d="M14.75 13.2344C15 14.1344 15.7 14.8344 16.6 15.0844" :stroke="active ? '#FFFFFF' : '#B2B2B2'" stroke-width="1.5"
		stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
</svg></template>