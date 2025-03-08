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
			d="M17.4281 9.26561C17.4281 13.3406 14.4698 17.1573 10.4281 18.2739C10.1531 18.3489 9.85312 18.3489 9.57812 18.2739C5.53645 17.1573 2.57812 13.3406 2.57812 9.26561V5.60726C2.57812 4.92393 3.0948 4.14893 3.73647 3.8906L8.37812 1.99062C9.41978 1.56563 10.5948 1.56563 11.6365 1.99062L16.2781 3.8906C16.9115 4.14893 17.4365 4.92393 17.4365 5.60726L17.4281 9.26561Z"
			:stroke="active ? '#FFFFFF' : '#B2B2B2'" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
		<path
			d="M10.0026 10.4193C10.9231 10.4193 11.6693 9.67308 11.6693 8.7526C11.6693 7.83213 10.9231 7.08594 10.0026 7.08594C9.08213 7.08594 8.33594 7.83213 8.33594 8.7526C8.33594 9.67308 9.08213 10.4193 10.0026 10.4193Z"
			:stroke="active ? '#FFFFFF' : '#B2B2B2'" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
		<path d="M10 10.4219V12.9219" :stroke="active ? '#FFFFFF' : '#B2B2B2'" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
			stroke-linejoin="round" />
	</svg>
</template>