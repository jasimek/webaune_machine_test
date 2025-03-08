<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import BreadCrumb from "@/Components/BreadCrumb.vue"
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';



const props = defineProps({
    product: Object
});


onMounted(() => {


});




const form = useForm({
    name: props.product?.name,
    description: props.product?.description,
    price: props.product?.price,
    stock_quantity: props.product?.stock_quantity
});


const breadcrumb = ref([
    { 'value': 'Home', 'route': '#' },
    { 'value': 'Products', 'route': route('products.index') },
    { 'value': 'Create Product', 'route': '#' },
])


function update(data) {
    form.put(route('products.update', [props.product]), {
        preserveScroll: true,
        onSuccess: () => {
            // closeModal()
        },
        onError: (err) => {
            console.log(err);
        },

    });
}

</script>

<template>

    <Head title="Dashboard" />

    <AdminLayout>

        <div class="px-6 py-3 pb-0">
            <div class="flex justify-between mb-2">
                <div class="text-[19px] text-[#333] font-jakarta-semibold pl-2">
                    Create Product
                </div>
                <div>
                    <BreadCrumb :data='breadcrumb' />
                </div>
            </div>
            <div class="bg-white rounded-xl min-h-screen">


                <div class="px-[18px] space-y-6 py-5">
                    <div class="grid grid-cols-2 gap-5">
                        <div class="col-span-12 sm:col-span-3">
                            <InputLabel value="Name" />
                            <TextInput type="text" required v-model="form.name" placeholder="Enter Name" />
                            <InputError :message="form.errors.name" />
                        </div>
                        <div class="col-span-12 sm:col-span-3">
                            <InputLabel value="Description" />

                            <TextInput type="text" required v-model="form.description"
                                placeholder="Enter Description" />
                            <InputError :message="form.errors.description" />
                        </div>
                        <div class="col-span-12 sm:col-span-3">
                            <InputLabel value="Price" />

                            <TextInput type="text" required v-model="form.price" placeholder="Enter Price" />
                            <InputError :message="form.errors.price" />
                        </div>
                        <div class="col-span-12 sm:col-span-3">
                            <InputLabel value="Stock Quantity" />

                            <TextInput type="text" required v-model="form.stock_quantity"
                                placeholder="Enter Stock Quantity" />
                            <InputError :message="form.errors.stock_quantity" />
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button @click="update()" :disabled="form.processing"
                            class="text-white bg-[#0AAD97] hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-7 py-3 text-center"
                            type="submit">Update</button>
                    </div>
                </div>

            </div>
        </div>
    </AdminLayout>
</template>