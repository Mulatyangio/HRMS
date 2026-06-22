<script setup>
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const props = defineProps({
    email: { type: String, required: true },
    token: { type: String, required: true },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Reset Password" />

    <div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 px-4">
        <div class="w-full max-w-sm">
            <div class="mb-8 text-center">
                <div class="mb-4 flex items-center justify-center gap-2">
                    <ApplicationLogo class="h-8 w-auto" />
                    <span class="text-xl font-bold text-indigo-600">HRMS</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Set new password</h1>
                <p class="mt-1 text-sm text-gray-500">Choose a strong password for your account.</p>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" v-model="form.email" type="email" required autofocus autocomplete="username"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                        <InputError class="mt-1.5" :message="form.errors.email" />
                    </div>

                    <div>
                        <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700">New Password</label>
                        <input id="password" v-model="form.password" type="password" required autocomplete="new-password" placeholder="Enter new password"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                        <InputError class="mt-1.5" :message="form.errors.password" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input id="password_confirmation" v-model="form.password_confirmation" type="password" required autocomplete="new-password" placeholder="Confirm new password"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                        <InputError class="mt-1.5" :message="form.errors.password_confirmation" />
                    </div>

                    <button type="submit" :disabled="form.processing"
                        class="w-full rounded-lg bg-indigo-600 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-50">
                        {{ form.processing ? 'Resetting...' : 'Reset password' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
