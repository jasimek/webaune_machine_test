<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import BreadCrumb from "@/Components/BreadCrumb.vue"
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import Textarea from 'primevue/textarea';
import VueMultiselect from 'vue-multiselect'

onMounted(() => {


});


const props = defineProps({
    customers: Object,
    products: Object
})

const form = useForm({
    customer: [],
    products: [],
});


const breadcrumb = ref([
    { 'value': 'Home', 'route': '#' },
    { 'value': 'Orders', 'route': route('orders.index') },
    { 'value': 'Create Order', 'route': '#' },
])


function store(data) {
    form.post(route('orders.store'), {
        preserveScroll: true,
        onSuccess: () => {
            // closeModal()
            router.get(route('orders.index'));
        },
        onError: (err) => {
            console.log(err);
        },

    });
}

</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<template>

    <Head title="Dashboard" />

    <AdminLayout>

        <div class="px-6 py-3 pb-0">
            <div class="flex justify-between mb-2">
                <div class="text-[19px] text-[#333] font-jakarta-semibold pl-2">
                    Create Order
                </div>
                <div>
                    <BreadCrumb :data='breadcrumb' />
                </div>
            </div>
            <div class="bg-white rounded-xl min-h-screen">


                <div class="px-[18px] space-y-6 py-5">
                    <div class="grid grid-cols-2 gap-5">
                        <div class="col-span-12 sm:col-span-3">
                            <InputLabel value="Customer" />
                            <VueMultiselect v-model="form.customer" :options="customers" label="name">
                            </VueMultiselect>
                        </div>
                        <div class="col-span-12 sm:col-span-3">
                            <InputLabel value="Products" />
                            <VueMultiselect v-model="form.products" :options="products" label="name" :multiple="true" :close-on-select="false" track-by="id">
                            </VueMultiselect>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button @click="store()" :disabled="form.processing"
                            class="text-white bg-[#0AAD97] hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-7 py-3 text-center"
                            type="submit">Submit</button>
                    </div>
                </div>

            </div>
        </div>
    </AdminLayout>
</template>