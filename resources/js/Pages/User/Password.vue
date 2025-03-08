<script setup>
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue'
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

const form = useForm({
	id: '',
	password: '',
	confirm_password: '',
});

const isShowModal = ref(false)
const departments = ref([])
function closeModal() {
	isShowModal.value = false
	form.reset()
	departments.value = []
}
function showModal(data) {
	isShowModal.value = true
	form.id = data.id
}

defineExpose({
	showModal
})


function store() {
	form.post(route('users.change-password',[form.id]), {
		preserveScroll: true,
		onSuccess: () => {
			closeModal()
		},
		onError: () => {

		},

	});
};

</script>

<template>
	<Modal :show="isShowModal">
		<div class="text-lg font-medium text-gray-900 bg-[#F5F6FA] w-full h-[60px]">
			<div class="p-4 flex justify-between">
				<div class="text-[18px] font-jakarta-semibold">
					Change Password
				</div>
				<div @click="closeModal()" class="cursor-pointer">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<path d="M13.9922 10.0119L14.8322 9.17188" stroke="#292D32" stroke-width="1.5"
							stroke-linecap="round" stroke-linejoin="round" />
						<path d="M9.17188 14.8281L11.9219 12.0781" stroke="#292D32" stroke-width="1.5"
							stroke-linecap="round" stroke-linejoin="round" />
						<path d="M14.8319 14.8319L9.17188 9.17188" stroke="#292D32" stroke-width="1.5"
							stroke-linecap="round" stroke-linejoin="round" />
						<path d="M2 12.96V15C2 20 4 22 9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9"
							stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</div>
			</div>
		</div>

		<div class="px-[18px] space-y-6 py-5">
			<div class="grid grid-cols-2 gap-5">
				<div class="col-span-2">

					<InputLabel value="Password" :validation="form.errors.password ? true : false" />

					<TextInput type="password" required v-model="form.password" placeholder="Enter Password">
						<template v-if="form.errors.password" #validationMessage>
							{{ form.errors.password }}
						</template>
					</TextInput>
				</div>
				<div class="col-span-2">

					<InputLabel value="Confirm Password" :validation="form.errors.confirm_password ? true : false" />

					<TextInput type="password" required v-model="form.confirm_password" placeholder="Enter Confirm Password">
						<template v-if="form.errors.confirm_password" #validationMessage>
							{{ form.errors.confirm_password }}
						</template>
					</TextInput>
				</div>
			</div>

			<div class="mt-6 flex justify-end">
				<button @click="closeModal()"
					class="mr-[14px] bg-[#0AAD97] bg-opacity-10 text-[#0AAD97] hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-3 text-center"
					type="submit">Close</button>
				<button @click="store()"
					class="text-white bg-[#0AAD97] hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-7 py-3 text-center"
					type="submit">Save</button>
			</div>
		</div>
	</Modal>
</template>