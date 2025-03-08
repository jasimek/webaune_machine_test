<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Head, useForm } from '@inertiajs/vue3';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import { onMounted, ref } from 'vue';
import { useToast } from 'primevue/usetoast';
import { Accordion, AccordionPanel, AccordionHeader, AccordionContent, Checkbox } from 'flowbite-vue'

const props = defineProps(
	{ permissions: Object }
);

const toast = useToast()

const breadcrumb = ref([
	{ 'value': 'Home', 'route': '' },
	{ 'value': 'Roles', 'route': '#' },
])

const form = useForm({
	name: '',
	permissions: [],
});


onMounted(() => {
})

const isCheckAll = ref(false)
const selected_permissions = ref([]);
function selectAll() {
	isCheckAll.value = !isCheckAll.value
	selected_permissions.value = []
	if (isCheckAll.value) {
		for (var permissions in props.permissions['permission']) {
			for (var permission in props.permissions['permission'][permissions]) {
				selected_permissions.value.push(props.permissions['permission'][permissions][permission]?.name)
			}
			document.getElementById('permission_' + permissions).checked = true
		}
	} else {
		for (var permissions in props.permissions['permission']) {
			document.getElementById('permission_' + permissions).checked = false
		}
	}
}

function updateSelectAll(key) {

	if (selected_permissions.value.length == props.permissions['count']) {
		isCheckAll.value = true
	} else {
		isCheckAll.value = false
	}

	var checked_checkbox = document.getElementById('module_' + key).querySelectorAll('input[name=checkbox]:checked')
	if (checked_checkbox.length > 0) {
		if (props.permissions['permission'][key].length == checked_checkbox.length) {
			document.getElementById('permission_' + key).checked = true
		} else {
			document.getElementById('permission_' + key).checked = false
		}
	}

}

function selectPermissionAll(value, event) {
	for (var key in props.permissions['permission'][value]) {
		if (!event.target.checked) {
			let index = selected_permissions.value.indexOf(props.permissions['permission'][value][key].name);
			if (index > -1) {
				selected_permissions.value.splice(index, 1)
			}
			event.target.checked = false
		} else {
			let index = selected_permissions.value.indexOf(props.permissions['permission'][value][key].name);
			if (index > -1) {
				selected_permissions.value.splice(index, 1)
			}
			selected_permissions.value.push(props.permissions['permission'][value][key].name)
			event.target.checked = true
		}
	}
	// updateSelectAll(value)
	updateSelectAllInPermission()
}

function updateSelectAllInPermission() {
	if (selected_permissions.value.length == props.permissions['count']) {
		isCheckAll.value = true
	} else {
		isCheckAll.value = false
	}
}

function store() {
	if (selected_permissions.value.length > 0) {
		form.permissions = selected_permissions.value;
		form.permissions = selected_permissions.value;
		form.post(route('user-roles.store'), {
			preserveScroll: true,
			onSuccess: () => {
			},
			onError: () => {

			},

		});
	} else {
		toast.add({ severity: 'warn', summary: 'Please select one', detail: 'Please Select atleast one', life: 3000 });
	}

}



</script>

<template>
	<Head title="Dashboard" />

	<AdminLayout>

		<div class="px-6 py-3">
			<div class="flex justify-between mb-2">
				<div class="text-[19px] text-[#333] font-jakarta-semibold pl-2">
					User Role
				</div>
				<div>
					<BreadCrumb :data='breadcrumb' />
				</div>
			</div>
			<div class="bg-white rounded-xl mt-4 min-h-screen">
				<div class="pt-9 pl-[27px] pr-[22px]">
					<div class="grid gap-4 grid-cols-9 mt-4">
						<div class="col-span-8" style="width: 60%;">
							<InputLabel value="Name" :validation="form.errors.name ? true : false" />

							<TextInput type="text" required v-model="form.name" placeholder="Enter Name">
								<template v-if="form.errors.name" #validationMessage>
									{{ form.errors.name }}
								</template>
							</TextInput>
						</div>
						<div class="mt-8 my-6 text-right">
							<div class="flex items-center mb-4">
								<Checkbox label="Check Alll" @click="selectAll()" v-model="isCheckAll" />
							</div>
						</div>
					</div>
					<Accordion v-for="(permission, permission_index) in permissions['permission']"
						class="mb-3 border-b dark:border-gray-700" :key="permission_index">
						<accordion-panel>
							<accordion-header>{{ permission_index }}</accordion-header>
							<accordion-content>
								<div class="grid gap-1 grid-cols-4 mt-4" :id="'module_' + permission_index">
									<div class="flex items-center mb-4 col-span-full">
										<input type="checkbox" :id="'permission_' + permission_index"
											@change="selectPermissionAll(permission_index, $event)"
											class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
										<label for="default-checkbox"
											class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Select
											All</label>
									</div>
									<div class="flex items-center mb-4" v-for="(item, item_index) in permission"
										:key="item_index">
										<input type="checkbox" v-model="selected_permissions" :value="item.name"
											@change="updateSelectAll(key)" name="checkbox"
											class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
										<label for="default-checkbox"
											class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
											{{ item.name }}</label>
									</div>
								</div>
							</accordion-content>
						</accordion-panel>
					</Accordion>

					<div class="flex justify-center">
						<button type="button" @click="store()" :disabled="form.processing"
							class="text-white bg-[#171F4C] hover:bg-[#130b29] py-[13px] px-[28px] focus:ring-4 focus:ring-blue-300 font-medium rounded-[10px] text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none">
							Save</button>
					</div>
				</div>
			</div>
		</div>
	</AdminLayout>
</template>
