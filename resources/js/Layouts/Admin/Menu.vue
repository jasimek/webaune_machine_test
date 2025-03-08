<script setup>
import DashboardIcon from '@/Components/Icons/DashboardIcon.vue';
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3'
import { initFlowbite } from 'flowbite'
import { onMounted } from 'vue';

const page = usePage()

const menu_data = [
	{ title: 'Dashboard', icon: '', route: route('dashboard'), page_url: page.url.startsWith('/admin/dashboard'), page_access: true },
	{ title: 'Customers', icon: '', route: route('customers.index'), page_url: page.url.startsWith('/admin/customers'), page_access: true },
	{ title: 'Products', icon: '', route: route('products.index'), page_url: page.url.startsWith('/admin/products'), page_access: true },
	{ title: 'Orders', icon: '', route: route('orders.index'), page_url: page.url.startsWith('/admin/orders'), page_access: true },
]

onMounted(() => {
	initFlowbite();
})

</script>
<template>
	<aside id="sidebar"
		class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 hidden w-[270px] h-full pt-14 font-normal duration-75 lg:flex transition-width"
		aria-label="Sidebar">
		<div class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200">
			<div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
				<div class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200">
					<ul class="pb-2 space-y-2">
						<template v-for="(item, item_index) in menu_data" :key="item_index">
							<!-- {{ item }} -->
							<li class="" v-if="item.page_access">
								<Link :href=item.route v-if="item.title != 'User Management' && item.title != 'Design'"
									class="pl-4 py-2 font-jakarta-medium text-[16px] text-[#B2B2B2] flex items-center rounded-lg group"
									:class="{ 'bg-[#171F4C] text-white hover:bg-[#171F4C]': item.page_url, 'hover:bg-gray-100': !item.page_url }">
								<DashboardIcon v-if="item.title == 'Dashboard'" :active="item.page_url" />
								<component :is="item.icon" />
								<span class="ml-3" sidebar-toggle-item>{{ item.title }}</span>
								</Link>
							</li>
						</template>
					</ul>
				</div>
			</div>
		</div>
	</aside>
</template>