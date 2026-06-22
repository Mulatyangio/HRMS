<script setup>
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps({ status: String });

const form = useForm({ email: '' });

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Head title="Forgot Password" />

    <div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 px-4">
        <div class="w-full max-w-sm">
            <div class="mb-8 text-center">
                <div class="mb-4 flex items-center justify-center gap-2">
                    <ApplicationLogo class="h-8 w-auto" />
                    <span class="text-xl font-bold text-indigo-600">HRMS</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Reset your password</h1>
                <p class="mt-1 text-sm text-gray-500">Enter your email and we'll send you a reset link.</p>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div v-if="status" class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" v-model="form.email" type="email" required autofocus autocomplete="username" placeholder="you@company.com"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                        <InputError class="mt-1.5" :message="form.errors.email" />
                    </div>

                    <button type="submit" :disabled="form.processing"
                        class="w-full rounded-lg bg-indigo-600 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-50">
                        {{ form.processing ? 'Sending...' : 'Send reset link' }}
                    </button>
                </form>
            </div>

            <p class="mt-6 text-center text-sm text-gray-500">
                Remember your password?
                <Link :href="route('login')" class="font-medium text-indigo-600 hover:text-indigo-500">Sign in</Link>
            </p>
        </div>
    </div>
</template>
