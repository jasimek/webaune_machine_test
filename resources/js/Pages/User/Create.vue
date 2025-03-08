<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Head, useForm } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import { onMounted, ref } from 'vue';
import TextInputIcon from '@/Components/TextInputIcon.vue';
import Select from '@/Components/Select.vue';
import VueMultiselect from 'vue-multiselect'
import RolesIcon from '@/Components/Icons/RolesIcon.vue';
import EmailIcon from '@/Components/Icons/EmailIcon.vue';
import DepartmentIcon from '@/Components/Icons/DepartmentIcon.vue';
import PhoneIcon from '@/Components/Icons/PhoneIcon.vue';
import UserIcon from '@/Components/Icons/UsersIcon.vue';
import SelectIcon from '@/Components/SelectIcon.vue';
import { Checkbox } from 'flowbite-vue';
import InputError from '@/Components/InputError.vue';
import { useToast } from 'primevue/usetoast';

const props = defineProps(
	{ roles: Object }
);

const breadcrumb = ref([
	{ 'value': 'Home', 'route': '' },
	{ 'value': 'Create User', 'route': '#' },
])

const toast = useToast();
onMounted(() => {
	// addNoneToFacilites();
	// addNoneToDepartments();
});

const units = ref([])

// const facilities_data = ref([])
// const departments_data = ref([])
const selected_departments = ref([])

const form = useForm({
	first_name: '',
	last_name: '',
	role: '',
	email: '',
	phone: '',
});



function store() {
	form.post(route('users.store'), {
		preserveScroll: true,
		onSuccess: () => {
		},
		onError: (error) => {
			if (error.code == 101) {
				toast.add({ severity: 'warn', summary: 'Error', detail: error.message, life: 3000 });
			} 
		},
	});
}



</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<template>

	<Head title="Dashboard" />

	<AdminLayout>
		<div class="px-6 py-3">
			<div class="flex justify-between mb-2">
				<div class="text-[19px] text-[#333] font-jakarta-semibold pl-2">
					Create User
				</div>
				<div>
					<BreadCrumb :data='breadcrumb' />
				</div>
			</div>
			<div class="bg-white rounded-xl mt-4 min-h-screen">
				<div class="pt-9 pl-[27px] pr-[22px]">
					<div class="grid grid-cols-2 gap-5">
						<div>
							<TextInputIcon ref="name" v-model="form.first_name" type="text" placeholder="Enter First Name"
								label="First Name*">
								<template #prefixIcon>
									<UserIcon></UserIcon>
								</template>
								<template v-if="form.errors.first_name" #validationMessage>
									{{ form.errors.first_name }}
								</template>
							</TextInputIcon>
						</div>
						<div>
							<TextInputIcon ref="last_name" v-model="form.last_name" type="text"
								placeholder="Enter Last Name" label="Last Name*">
								<template #prefixIcon>
									<UserIcon></UserIcon>
								</template>
								<template v-if="form.errors.last_name" #validationMessage>
									{{ form.errors.last_name }}
								</template>
							</TextInputIcon>
						</div>

					</div>
					<div class="grid grid-cols-3 gap-5 mt-4">
						<div>
							<InputLabel for="role" value="Role*" :validation="form.errors.role ? true : false"
								class="font-jakarata-semibold text-[14px] text-[#333333]" />
							<SelectIcon :options="roles" v-model="form.role">
								<template v-if="form.errors.role" #validationMessage>
									{{ form.errors.role }}
								</template>
								<template #prefixIcon>
									<RolesIcon></RolesIcon>
								</template>
							</SelectIcon>
						</div>

						<div>
							<TextInputIcon ref="email" v-model="form.email" type="email" placeholder="Enter Email"
								label="Email*">
								<template #prefixIcon>
									<EmailIcon></EmailIcon>
								</template>
								<template v-if="form.errors.email" #validationMessage>
									{{ form.errors.email }}
								</template>
							</TextInputIcon>

						</div>
						<div>
							<TextInputIcon ref="phone" v-model="form.phone" type="number" placeholder="Enter Phone"
								label="Phone*">
								<template #prefixIcon>
									<PhoneIcon></PhoneIcon>
								</template>
								<template v-if="form.errors.phone" #validationMessage>
									{{ form.errors.phone }}
								</template>
							</TextInputIcon>
						</div>

					</div>

					<div class="flex justify-center py-10">
						<button type="button" @click="store()" :disabled="form.processing"
							class="text-white bg-[#171F4C] hover:bg-[#130b29] py-[13px] px-[28px] focus:ring-4 focus:ring-blue-300 font-medium rounded-[10px] text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none">Submit</button>
					</div>
				</div>
			</div>
		</div>
	</AdminLayout>
</template>
