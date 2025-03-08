<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const props = defineProps({
	canResetPassword: {
		type: Boolean,
	},
	status: {
		type: String,
	},
	user: {
		type: Object
	}
});


function submit() {
	router.visit(route('login'))
}

</script>

<template>
	<GuestLayout>

		<Head title="Forgot Password" />

		<div class="grid md:grid-cols-2 ">
			<div class="flex justify-center item-center">
				<div class="h-screen bg-[#F5F6FA] m-4 rounded-[20px] w-screen">
					<p class="ml-12 mt-16 text-[42px] leading-[60px] font-jakarta-bold">
						Welcome Back! <br>
						Please sign in to your <br>
						<u> Avenue Healthcare</u> account
					</p>
				</div>
			</div>
			<div class="flex items-center justify-center">
				<div class="w-full sm:max-w-lg">
					<div class="flex items-center justify-center mb-6">
						<ApplicationLogo />
					</div>
					<div class="px-6 py-4 overflow-hidden shadow-[0_0_8px_4px_rgba(0,0,0,0.07)] rounded-2xl ">
						<div class="text-center my-8">
							<div class="mt-4 mt-8 flex items-center justify-center">

								<svg xmlns="http://www.w3.org/2000/svg" width="130" height="130" viewBox="0 0 130 130"
									fill="none">
									<path
										d="M56.8187 13.0797L29.7896 23.263C23.5604 25.5922 18.4688 32.9589 18.4688 39.5672V79.813C18.4688 86.2047 22.6937 94.6005 27.8396 98.4464L51.1312 115.834C58.7687 121.576 71.3354 121.576 78.9729 115.834L102.265 98.4464C107.41 94.6005 111.635 86.2047 111.635 79.813V39.5672C111.635 32.9047 106.544 25.538 100.315 23.2089L73.2854 13.0797C68.6812 11.4005 61.3146 11.4005 56.8187 13.0797Z"
										fill="#28A138" stroke="#28A138" stroke-width="6" stroke-linecap="round"
										stroke-linejoin="round" />
									<path d="M49.0234 64.2974L57.7443 73.0182L81.0359 49.7266" fill="#28A138" />
									<path d="M49.0234 64.2974L57.7443 73.0182L81.0359 49.7266" stroke="white"
										stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />
								</svg>
							</div>

							<div class="mt-4 mt-8">
								<h1 class="font-jakarta-semibold text-[28px]">Successfully Reset Password</h1>
								<p class="font-jakarta-normal text-[#B2B2B2]">Successfully Reset Password</p>

							</div>
						</div>

						<div class="flex items-center justify-end mt-[42px] mb-[108px]">

							<button
								class="bg-[#171F4C] w-full text-white font-bold rounded-lg py-[13px] font-[16px] font-jakarta-semibold leading-5"
								@click="submit()">
								Back to sign in
							</button>

						</div>
					</div>
				</div>
			</div>
		</div>

	</GuestLayout>
</template>
