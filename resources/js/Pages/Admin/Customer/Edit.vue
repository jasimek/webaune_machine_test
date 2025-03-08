<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import BreadCrumb from "@/Components/BreadCrumb.vue"
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import Textarea from 'primevue/textarea';

onMounted(() => {


});

const props = defineProps({
    customer: Object
})

const form = useForm({
    id: props.customer?.id,
    name: props.customer?.name,
    email: props.customer?.email,
    phone: props.customer?.phone,
    address: props.customer?.address,
});


const breadcrumb = ref([
    { 'value': 'Home', 'route': '#' },
    { 'value': 'Customers', 'route': route('customers.index') },
    { 'value': 'Edit Customer', 'route': '#' },
])


function store(data) {
    form.put(route('customers.update', [props.customer]), {
        preserveScroll: true,
        onSuccess: () => {
            // closeModal()
            router.get(route('customers.index'));
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
                    Edit Customer
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
                            <InputLabel value="Email" />

                            <TextInput type="email" required v-model="form.email" placeholder="Enter Email" />
                            <InputError :message="form.errors.email" />
                        </div>
                        <div class="col-span-12 sm:col-span-3">
                            <InputLabel value="Phone Number" />

                            <TextInput type="number" required v-model="form.phone" placeholder="Enter Phone Number" />
                            <InputError :message="form.errors.phone" />
                        </div>
                        <div class="col-span-12 sm:col-span-3">
                            <InputLabel value="Address" />

                            <Textarea type="text" required v-model="form.address" class="w-full"
                                placeholder="Enter Address" />
                            <InputError :message="form.errors.address" />
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