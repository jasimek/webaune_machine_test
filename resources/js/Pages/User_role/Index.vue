<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import { ref } from 'vue';
import { FilterMatchMode } from "primevue/api";
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import BreadCrumb from "@/Components/BreadCrumb.vue"
import DeleteModal from "@/Components/DeleteModal.vue"
import { useToast } from "primevue/usetoast";
import { usePage } from '@inertiajs/vue3'
import EditIcon from '@/Components/EditIcon.vue';
import DeleteIcon from '@/Components/DeleteIcon.vue';

const props = defineProps(
	{ roles: Object }
);

const datas = [
	{ title: 'Dashboard', icon: 'a' },
	{ title: 'User Management', icon: 'b' },
	{ title: 'Policy Management', icon: 'c' },
	{ title: 'Incident Management', icon: 'd' },
	{ title: 'Indicator Management', icon: 'e' },
]

const toast = useToast();
const page = usePage()

const breadcrumb = ref([
	{ 'value': 'Home', 'route': '#' },
	{ 'value': 'Roles', 'route': '#' },
])

const filters = ref();
const initFilters = () => {
	filters.value = {
		global: { value: null, matchMode: FilterMatchMode.CONTAINS },
	};
};
initFilters();

function create() {
	if (page.props.user.permissions.includes('create roles')) {
		router.visit(route('user-roles.create'))
	} else {
		toast.add({ severity: 'warn', summary: 'Permission', detail: 'Not permission', life: 3000 });
	}
}

function edit(data) {
	if (page.props.user.permissions.includes('edit roles')) {
		router.visit(route('user-roles.edit', [data]))
	} else {
		toast.add({ severity: 'warn', summary: 'Permission', detail: 'Not permission', life: 3000 });
	}
}

const deleteModal = ref()
const selected_ids = ref(null)
const delete_url = ref()
function deleteData(data) {
	if (page.props.user.permissions.includes('delete roles')) {
		selected_ids.value = data;
		delete_url.value = route('user-roles.destroy', [data.id]);
		deleteModal.value.showModal()
	} else {
		toast.add({ severity: 'warn', summary: 'Permission', detail: 'Not permission', life: 3000 });
	}


}

</script>

<template>
	<Head title="Dashboard" />

	<AdminLayout>

		<div class="px-6 py-3 pb-0">
			<div class="flex justify-between mb-2">
				<div class="text-[19px] text-[#333] font-jakarta-semibold pl-2">
					User Role
				</div>
				<div>
					<BreadCrumb :data='breadcrumb' />
				</div>
			</div>
			<div class="bg-white rounded-xl min-h-screen">
				<div class="items-center justify-between lg:flex px-3 pt-4">
					<div class="items-center sm:flex ml-3">
						<InputText size="medium" v-model="filters['global'].value" placeholder="Keyword Search" :pt="{
							root: { class: ' border !border-gray-300 !text-gray-900 sm:!text-sm rounded-lg focus:!ring-primary-500 focus:!border-primary-500 !block !w-full' }
						}" />
					</div>
					<div class="">
						<button type="button" @click="create()"
							class="text-white px-[40px] bg-[#0AAD97] hover:bg-[#050708]/90 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 font-medium rounded-lg text-sm px-5 py-1.5 text-center inline-flex items-center mr-2 mb-2">
							Add
						</button>
					</div>
				</div>

				<DataTable v-model:filters="filters" :value="roles" class="p-4" paginator :rows="10"
					tableStyle="min-width: 50rem" :globalFilterFields="['name']" :rowsPerPageOptions="[10, 100, 200, 500]">

					<template #empty>
						<div class="h-20 flex">
							<span class="m-auto font-bold">
								No record found.
							</span>
						</div>
					</template>
					<template #loading>
						<div class="h-20 flex">
							<span class="m-auto font-bold">
								Loading customers data. Please wait.
							</span>
						</div>
					</template>

					<Column header="SN" style="height: 55px;">
						<template #body="{ data, index }">
							<div class="ml-1">

								{{ index + 1 }}
							</div>

						</template>
					</Column>

					<Column field="name" header="Name" style="height: 55px;"></Column>
					<Column header="action">
						<template #body="{ data }">
							<div class="flex" v-if="data.name != 'Super Admin'">
								<EditIcon @click="edit(data)" />
								<DeleteIcon @click="deleteData(data)" />
							</div>
						</template>
					</Column>

				</DataTable>
			</div>
			<DeleteModal ref="deleteModal" :selected_ids="selected_ids" :url="delete_url" />
		</div>
	</AdminLayout>
</template>