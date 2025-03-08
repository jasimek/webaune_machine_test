<script setup>
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue'
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

const form = useForm({
    id: '',
    password: '',
    confirm_password: '',
});


const order_items = ref([])

const isShowModal = ref(false)
const departments = ref([])
function closeModal() {
    isShowModal.value = false
    form.reset()
    departments.value = []
}
function showModal(data) {


    order_items.value = data.order_items

    isShowModal.value = true
    // form.id = data.id
}

defineExpose({
    showModal
})


function store() {
    form.post(route('users.change-password', [form.id]), {
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
                    Order Items
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

        <!-- <div class="px-[18px] space-y-6 py-5"> -->
        <!-- <div class="grid grid-cols-2 gap-5"> -->
        <DataTable v-model:filters="filters" :value="order_items" class="p-4" paginator :rows="10"
             :globalFilterFields="global_filter_fields"
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

            <Column field="name" header="Name">

                <template #body="{ data }">
                    {{ data.product?.name }}
                </template>
            </Column>
            <Column field="quantity" header="Quantity">
                <template #body="{ data }">
                    {{ data.quantity }}
                </template>
            </Column>
            <Column field="total" header="Total">

                <template #body="{ data }">
                    {{ data.subtotal }}
                </template>
            </Column>

        </DataTable>
        <!-- </div> -->
        <!-- </div> -->
    </Modal>
</template>