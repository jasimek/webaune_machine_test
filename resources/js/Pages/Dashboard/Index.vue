<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import { onMounted, ref } from 'vue';
import DetailsModal from "@/Pages/Admin/Order/Details.vue"
import EditIcon from '@/Components/EditIcon.vue';
import DeleteIcon from '@/Components/DeleteIcon.vue';
import EyeIcon from '@/Components/Icons/EyeIcon.vue';


onMounted(() => {

});

const props = defineProps({

	order_count: String,
	customer_count: String,
	product_count: String,
	customers: Object,
	products: Object,
	orders: Object,
})

const detailsModal = ref(false)

function showDetails(data) {
	detailsModal.value.showModal(data);
}
</script>

<template>

	<Head title="Dashboard" />

	<AdminLayout>
		<div class="px-6 py-3 pb-0">


			<div class="flex gap-3">
				<Link :href="route('customers.index')"
					class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

				<h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Customers</h5>
				<p class="font-normal text-gray-700 dark:text-gray-400">{{ customer_count }}</p>
				</Link>

				<Link :href="route('products.index')"
					class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

				<h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Products</h5>
				<p class="font-normal text-gray-700 dark:text-gray-400">{{ product_count }}</p>
				</Link>

				<Link :href="route('products.index')"
					class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

				<h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Orders</h5>
				<p class="font-normal text-gray-700 dark:text-gray-400">{{ order_count }}</p>
				</Link>
			</div>

			<div class="p-5 bg-white mt-5">

				<h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Customers</h5>

				<DataTable v-model:filters="filters" :value="customers" class="" paginator :rows="10"
					tableStyle="min-width: 50rem" :globalFilterFields="global_filter_fields"
					:rowsPerPageOptions="[10, 100, 200, 500]">

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
								Loading Products data. Please wait.
							</span>
						</div>
					</template>

					<Column header="SN">
						<template #body="{ data, index }">
							<div class="ml-1">

								{{ index + 1 }}
							</div>

						</template>
					</Column>

					<Column field="name" header="Name"></Column>
					<Column field="email" header="Email"></Column>
					<Column field="phone" header="Phone"></Column>
					<Column field="address" header="Address">
						<template #body="{ data }">
							{{ data.address ?? 'N/A' }}
						</template>
					</Column>

				</DataTable>

			</div>
			<div class="p-5 bg-white mt-5">

				<h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Products</h5>

				<DataTable v-model:filters="filters" :value="products" class="p-4" paginator :rows="10"
					tableStyle="min-width: 50rem" :globalFilterFields="global_filter_fields"
					:rowsPerPageOptions="[10, 100, 200, 500]">

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
								Loading Products data. Please wait.
							</span>
						</div>
					</template>

					<Column header="SN">
						<template #body="{ data, index }">
							<div class="ml-1">

								{{ index + 1 }}
							</div>

						</template>
					</Column>

					<Column field="name" header="Name"></Column>

					<Column field="description" header="Description"></Column>
					<Column field="price" header="Price"></Column>
					<Column field="stock_quantity" header="Stock Quantity"></Column>

				</DataTable>

			</div>
			<div class="p-5 bg-white mt-5">

				<h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Orders</h5>

				<DataTable v-model:filters="filters" :value="orders" class="p-4" paginator :rows="10"
					tableStyle="min-width: 50rem" :globalFilterFields="global_filter_fields"
					:rowsPerPageOptions="[10, 100, 200, 500]">

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
								Loading Products data. Please wait.
							</span>
						</div>
					</template>

					<Column header="SN">
						<template #body="{ data, index }">
							<div class="ml-1">

								{{ index + 1 }}
							</div>

						</template>
					</Column>

					<Column field="customer_name" header="Customer Name">

						<template #body="{ data }">
							{{ data.customer?.name }}
						</template>
					</Column>
					<Column field="phone" header="Phone">

						<template #body="{ data }">
							{{ data.customer?.phone }}
						</template>
					</Column>
					<Column field="email" header="Email">

						<template #body="{ data }">
							{{ data.customer?.email }}
						</template>
					</Column>
					<Column field="Address" header="Address">
						<template #body="{ data }">
							{{ data.customer?.address ?? 'N/A' }}
						</template>
					</Column>
					<Column header="Action">
						<template #body="{ data }">
							<div class="flex">
								<EyeIcon class="mr-2" @click="showDetails(data)" />
							</div>
						</template>
					</Column>
				</DataTable>

			</div>
		</div>




		<DetailsModal ref="detailsModal" />

	</AdminLayout>
</template>
