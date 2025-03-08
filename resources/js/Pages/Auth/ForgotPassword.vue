<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';
import { useToast } from 'primevue/usetoast';

defineProps({
	canResetPassword: {
		type: Boolean,
	},
	status: {
		type: String,
	},
});

const toast = useToast();

const form = useForm({
	email: '',
});

const success_mail = ref('')

const email_match_error = ref('')
function submit() {
	success_mail.value = ''
	form.post(route('forgot-password.check-mail'), {
		onSuccess: (success) => {
			email_match_error.value = ''
			success_mail.value = 'Mail has been sent! please check your mail'
			toast.add({ severity: 'success', summary: 'Updated', detail: 'Email has been sent! please check your mail', life: 3000 });
		},
		onError: (error) => {
			email_match_error.value = ''
			email_match_error.value = error.error;
		},
	});
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
					<form @submit.prevent="submit">
						<div class="px-6 py-4 overflow-hidden shadow-[0_0_8px_4px_rgba(0,0,0,0.07)] rounded-2xl ">
							<div class="text-center my-8">
								<h1 class="font-jakarta-semibold text-[28px]">Reset Password</h1>
								<p class="font-jakarta-normal text-[#B2B2B2]">Enter your registered email address, we will
									send
									instructions to help reset the password</p>
							</div>
							<div>

								<InputLabel value="Email *"
									:validation="form.errors.email || email_match_error ? true : false" />

								<TextInput type="text" required v-model="form.email" placeholder="Email">
									<template v-if="form.errors.email || email_match_error" #validationMessage>
										{{ form.errors.email ?? email_match_error }}
									</template>
								</TextInput>
							</div>

							<div class="block mb-1 text-sm font-medium text-red-700 dark:text-red-500 mt-3 text-center"
								v-if="success_mail">
								{{ success_mail }}
							</div>

							<div class="flex items-center justify-end mt-[42px] mb-[108px]">

								<button
									class="bg-[#171F4C] w-full text-white font-bold rounded-lg py-[13px] font-[16px] font-jakarta-semibold leading-5"
									@click="submit()">
									Submit
								</button>

							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

	</GuestLayout>
</template>
