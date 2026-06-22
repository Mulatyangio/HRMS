<script setup>
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const form = useForm({ password: '' });

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Confirm Password" />

    <div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 px-4">
        <div class="w-full max-w-sm">
            <div class="mb-8 text-center">
                <div class="mb-4 flex items-center justify-center gap-2">
                    <ApplicationLogo class="h-8 w-auto" />
                    <span class="text-xl font-bold text-indigo-600">HRMS</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Confirm password</h1>
                <p class="mt-1 text-sm text-gray-500">This is a secure area. Please confirm your password before continuing.</p>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" v-model="form.password" type="password" required autocomplete="current-password" autofocus placeholder="Enter your password"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                        <InputError class="mt-1.5" :message="form.errors.password" />
                    </div>

                    <button type="submit" :disabled="form.processing"
                        class="w-full rounded-lg bg-indigo-600 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-50">
                        {{ form.processing ? 'Confirming...' : 'Confirm' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
