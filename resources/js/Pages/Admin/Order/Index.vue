<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import { onMounted, ref } from 'vue';
import { FilterMatchMode } from "primevue/api";
import InputText from 'primevue/inputtext';
import BreadCrumb from "@/Components/BreadCrumb.vue"
import DeleteModal from "@/Components/DeleteModal.vue"
import DeleteIcon from '@/Components/DeleteIcon.vue';
import EditIcon from '@/Components/EditIcon.vue';
import DetailsModal from "@/Pages/Admin/Order/Details.vue"
import EyeIcon from '@/Components/Icons/EyeIcon.vue';


const props = defineProps(
    { orders: Object }
);

onMounted(() => {





});


const detailsModal = ref(false)

const breadcrumb = ref([
    { 'value': 'Home', 'route': '#' },
    { 'value': 'Orders', 'route': '#' },
])

const filters = ref();
const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    };
};
initFilters();

function create() {
    router.visit(route('orders.create'))

}

function edit(data) {
    router.visit(route('orders.edit', [data]))
}



const deleteModal = ref()
const selected_ids = ref();
const delete_url = ref()
function deleteData(data) {
    selected_ids.value = data;
    delete_url.value = route('orders.destroy', [data.id]);
    deleteModal.value.showModal()
}

const global_filter_fields = [
    'name',
    'description',
    'price',
    'stock_quantity',
]


function showDetails(data) {
    detailsModal.value.showModal(data)
}


</script>

<template>

    <Head title="Orders" />

    <AdminLayout>

        <div class="px-6 py-3 pb-0">
            <div class="flex justify-between mb-2">
                <div class="text-[19px] text-[#333] font-jakarta-semibold pl-2">
                    Orders
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
                            Create Order
                        </button>
                    </div>
                </div>
                <Toggle1 />

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
                    <!-- <Column field="product_name" header="Product Name">
                        <template #body="{ data }">
                            <template v-for="(order_item, order_item_index) in data.order_items">
                                {{ order_item.product?.name }}
                            </template>
                        </template>
                    </Column> -->

                    <Column header="Action">
                        <template #body="{ data }">
                            <div class="flex">
                                <EyeIcon class="mr-2" @click="showDetails(data)" />
                            </div>
                        </template>
                    </Column>

                </DataTable>
            </div>
            <DeleteModal ref="deleteModal" :selected_ids="selected_ids" :url="delete_url" />
            <DetailsModal ref="detailsModal" />
        </div>
    </AdminLayout>
</template>