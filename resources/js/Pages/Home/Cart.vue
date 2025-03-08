<script setup>
import { onMounted, ref } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';

const props = defineProps({
    cart_items: Object
})

const page = usePage()

onMounted(() => {
    getTotal()

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


function removeFromCart(cart_item) {

    console.log(cart_item, 'cart_item from remove from cart')

    quantity_error_message.value = ''
    router.post(route('customer.remove_from_carts', { cart: cart_item }))
}

const quantity_error_message = ref();

function increaseOrDecreaseQuantity(cart_item, value) {




    console.log(value, 'value from increase or decrease qunatity')


    // router.post(route('customer.increase_or_decrease_quantity', { cart: cart_item, is_decrement: value }))


    axios.post(route('customer.increase_or_decrease_quantity', { cart: cart_item, is_decrement: value }))
        .then(response => {
            // Handle success, update your component state, etc.
            // console.log('Success:', response.data);

            quantity_error_message.value = response.data.message
            if (!response.data.message) {
                router.visit(route('customer.carts'));
            }
        })
        .catch(error => {
            quantity_error_message.value = error.response?.data?.error
        });
}



function getTotal() {
    let cart_total = 0;
    props.cart_items.forEach(cart_item => {
        cart_total += Number(cart_item.price);
    });

    return cart_total;
}

function checkOut() {
    router.post(route('customer.add_to_orders', { cart_items: props.cart_items, total: getTotal() }))
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
                <!-- <a href="#" class="text-sm/6 font-semibold text-gray-900">Company</a> -->
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
        <div class="mx-auto max-w-full  lg:px-8 flex">


            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-12 lg:gap-2 xl:gap-x-8">
                <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
                    <div class="flex justify-between">

                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Shopping Cart</h2>
                        <div class=" p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                            v-if="quantity_error_message" role="alert">
                            <span class="font-medium">{{ quantity_error_message }}</span>
                        </div>
                    </div>
                    <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
                        <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl">


                            <template v-for="(cart_item, cart_tem_index) in cart_items">
                                <div class="space-y-6">
                                    <div
                                        class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:p-6">
                                        <div
                                            class="space-y-4 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">
                                            <a href="#" class="shrink-0 md:order-1">
                                                <img class="h-20 w-20 dark:hidden" src="" alt="Product Image" />

                                            </a>

                                            <label for="counter-input" class="sr-only">Choose quantity:</label>
                                            <div
                                                class="flex items-center justify-between md:order-3 md:justify-end gap-4">
                                                <div class="flex items-center">
                                                    <button type="button" id="decrement-button"
                                                        @click="increaseOrDecreaseQuantity(cart_item, true)"
                                                        data-input-counter-decrement="counter-input"
                                                        class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                                        <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 18 2">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                                        </svg>
                                                    </button>
                                                    <input type="text" id="counter-input" data-input-counter
                                                        class="w-10 shrink-0 border-0 bg-transparent text-center text-sm font-medium text-gray-900 focus:outline-none focus:ring-0 dark:text-white"
                                                        placeholder="" :value="cart_item.quantity" required />
                                                    <button type="button" id="increment-button"
                                                        @click="increaseOrDecreaseQuantity(cart_item, false)"
                                                        data-input-counter-increment="counter-input"
                                                        class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                                        <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 18 18">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M9 1v16M1 9h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="text-end md:order-4 md:w-32 me-4">
                                                    <p class="text-base font-bold text-gray-900 dark:text-white">${{
                                                        cart_item?.price }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md ms-4">
                                                <a href="#"
                                                    class="text-base font-medium text-gray-900 hover:underline dark:text-white">{{
                                                        cart_item.product?.name }},{{ cart_item.product?.description }}</a>

                                                <div class="flex items-center gap-4" @click="removeFromCart(cart_item)">

                                                    <button type="button"
                                                        class="inline-flex ms-5 mt-2 items-center text-sm font-medium text-red-600 hover:underline dark:text-red-500">
                                                        <svg class="me-1.5 h-5 w-5" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M6 18 17.94 6M18 18 6.06 6" />
                                                        </svg>
                                                        Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="mx-auto mt-6 max-w-auto   lg:mt-0 lg:w-full ms-5" v-if="cart_items.length">
                            <div
                                class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                                <p class="text-xl font-semibold text-gray-900 dark:text-white">Order summary</p>

                                <div class="space-y-4">


                                    <dl
                                        class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                                        <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                                        <dd class="text-base font-bold text-gray-900 dark:text-white">{{ getTotal() }}
                                        </dd>
                                    </dl>
                                </div>



                                <div class="flex items-center justify-center gap-2">

                                    <button type="button" @click="checkOut()"
                                        class="mt-4 text-white px-[40px] bg-blue-700 hover:bg-[#050708]/90 focus:ring-4 focus:outline-none focus:ring-[#050708]/50 font-medium rounded-lg text-sm px-5 py-1.5 text-center inline-flex items-center mr-2 mb-2">
                                        Place Order
                                    </button>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>