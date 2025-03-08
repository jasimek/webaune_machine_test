<script setup>
import { onMounted } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';

const props = defineProps({
    products: Object
})

const page = usePage()

onMounted(() => {


})

function SignIn() {
    router.visit(route('customer_login'));
}


function signOut() {
    router.post(route('customer.logout'));
}

function addToCart(product) {
    console.log('ad to cart clicked')

    router.post(route('customer.add_to_cart', [product]))
}


</script>


<template>
    <div class="bg-grey-800">
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only text-black">Your Company</span>
                    <img class="h-8 w-auto" src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600"
                        alt="">
                </a>
                <h3 class="text-3xl font-bold dark:text-white">E commerce</h3>
            </div>

            <div class="hidden lg:flex lg:gap-x-12">
                <Link :href="route('customer.carts')" class="text-sm/6 font-semibold text-gray-900">Cart</Link>
                <Link href="#" class="text-sm/6 font-semibold text-gray-900">Orders</Link>
                <a href="#" class="text-sm/6 font-semibold text-gray-900">Company</a>
                <button type="button" @click="SignIn()" v-if="!page.props.auth?.user"
                    class="text-white px-[40px] bg-blue-700 hover:bg-[#050708]/90 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 font-medium rounded-lg text-sm px-5 py-1.5 text-center inline-flex items-center mr-2 mb-2">
                    Sign In
                </button>
                <button type="button" @click="signOut()" v-if="page.props.auth?.user"
                    class="text-white px-[40px] bg-blue-700 hover:bg-[#050708]/90 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 font-medium rounded-lg text-sm px-5 py-1.5 text-center inline-flex items-center mr-2 mb-2">
                    Sign Out
                </button>
            </div>

        </nav>
        <!-- Mobile menu, show/hide based on menu open state. -->

    </div>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Products</h2>

            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
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
                    <Column header="Action">
                        <template #body="{ data }">
                            <div class="flex">
                                <EditIcon @click="edit(data)" />
                                <DeleteIcon @click="deleteData(data)" />
                            </div>
                        </template>
                    </Column>

                </DataTable>
            </div>
        </div>
    </div>

</template>