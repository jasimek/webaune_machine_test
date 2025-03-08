<script setup>
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Modal } from 'flowbite-vue'

const props = defineProps(
	{
		selected_ids: Object,
		url: String
	}
);


defineExpose({
	showModal
})
const isShowModal = ref(false)
function closeModal() {
	isShowModal.value = false
}
function showModal() {
	isShowModal.value = true
}


const deleteUser = () => {
	if (props.selected_ids?.id) {
		router.delete(props.url, {
			onSuccess: (res) => {
				closeModal();
			},
			onError: (err) => {
			},
		})

	} else {
		let data = {}
		data['ids'] = props.selected_ids
		router.post(props.url, data, {
			onSuccess: (res) => {
				closeModal();
			},
			onError: (err) => {
			},
		})
	}
};

</script>
<template>
	<Modal size="md" v-if="isShowModal" @close="closeModal">

		<template #body>
			<div class="pt-0 text-center">
				<svg class="w-16 h-16 mx-auto text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
					xmlns="http://www.w3.org/2000/svg">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
						d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
				</svg>
				<h3 class="mt-5 mb-6 text-lg text-gray-500 dark:text-gray-400">Are you sure you want to delete ?</h3>
				<button @click="deleteUser"
					class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2 dark:focus:ring-red-800">
					Yes, I'm sure
				</button>
				<button @click="closeModal" type="button"
					class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 border border-gray-200 font-medium inline-flex items-center rounded-lg text-base px-3 py-2.5 text-center dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
					No Cancel
				</button>
			</div>

		</template>
	</Modal>
</template>