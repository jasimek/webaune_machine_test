<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
	canResetPassword: {
		type: Boolean,
	},
	status: {
		type: String,
	},
	user: {
		type: Object
	},
	token: {
		type: Object
	}
});

const form = useForm({
	token: props.token,
	email: props.user?.email,
	password: '',
	confirm_password: '',
});

function submit() {
	form.post(route('password.update'), {
		onFinish: () => { },
		onError: (error) => {
			console.log(form.errors.email);
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
					<div class="px-6 py-4 overflow-hidden shadow-[0_0_8px_4px_rgba(0,0,0,0.07)] rounded-2xl ">
						<div class="text-center my-8">
							<h1 class="font-jakarta-semibold text-[28px]">Reset New Password</h1>
							<p class="font-jakarta-normal text-[#B2B2B2]">Enter a new password for<br></p>
							<p class="font-jakarta-normal">{{ user.email }}</p>
						</div>
						<div class="mt-4 mt-8">

							<InputLabel value="Password *" :validation="form.errors.password ? true : false" />

							<TextInput type="password" required v-model="form.password" placeholder="Password">
								<template v-if="form.errors.password" #validationMessage>
									{{ form.errors.password }}
								</template>
							</TextInput>
						</div>

						<div class="mt-4 mt-8">

							<InputLabel value="Confirm password *"
								:validation="form.errors.confirm_password ? true : false" />

							<TextInput type="password" required v-model="form.confirm_password"
								placeholder="Confirm password">
								<template v-if="form.errors.confirm_password" #validationMessage>
									{{ form.errors.confirm_password }}
								</template>
							</TextInput>
						</div>

						<div class="block mb-1 text-sm font-medium text-red-700 dark:text-red-500 mt-3 text-center"
                            v-if="form.errors.email">
                            {{ form.errors.email }}
                        </div>

						<div class="flex items-center justify-end mt-[42px] mb-[108px]">

							<button
								class="bg-[#171F4C] w-full text-white font-bold rounded-lg py-[13px] font-[16px] font-jakarta-semibold leading-5"
								@click="submit()">
								Reset password
							</button>

						</div>
					</div>
				</div>
			</div>
		</div>

	</GuestLayout>
</template>
