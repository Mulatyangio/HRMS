<script setup>
import { ref } from 'vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Sign In" />

    <div class="flex min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50">
        <!-- Left Panel - Branding -->
        <div class="hidden w-1/2 flex-col items-center justify-center bg-indigo-600 p-12 lg:flex">
            <div class="max-w-md text-center">
                <div class="mb-8 flex items-center justify-center gap-3">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-white/20">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="text-3xl font-bold text-white">HRMS</span>
                </div>
                <h1 class="text-4xl font-bold text-white">Manage your workforce with ease</h1>
                <p class="mt-4 text-lg text-indigo-100">Complete HR management solution for your organization.</p>
                <div class="mt-12 grid grid-cols-3 gap-6">
                    <div class="rounded-xl bg-white/10 p-4">
                        <p class="text-2xl font-bold text-white">10K+</p>
                        <p class="mt-1 text-xs text-indigo-200">Employees</p>
                    </div>
                    <div class="rounded-xl bg-white/10 p-4">
                        <p class="text-2xl font-bold text-white">500+</p>
                        <p class="mt-1 text-xs text-indigo-200">Companies</p>
                    </div>
                    <div class="rounded-xl bg-white/10 p-4">
                        <p class="text-2xl font-bold text-white">98%</p>
                        <p class="mt-1 text-xs text-indigo-200">Satisfaction</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Form -->
        <div class="flex w-full items-center justify-center px-4 lg:w-1/2">
            <div class="w-full max-w-sm">
                <div class="mb-8 text-center lg:text-left">
                    <div class="mb-6 flex items-center justify-center gap-2 lg:justify-start">
                        <ApplicationLogo class="h-8 w-auto" />
                        <span class="text-xl font-bold text-indigo-600">HRMS</span>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">Welcome back</h1>
                    <p class="mt-1 text-sm text-gray-500">Sign in to your account to continue.</p>
                </div>

                <div v-if="status" class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-5">
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" v-model="form.email" type="email" name="email" required autofocus autocomplete="username" placeholder="you@company.com"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                        <InputError class="mt-1.5" :message="form.errors.email" />
                    </div>

                    <div>
                        <div class="mb-1.5 flex items-center justify-between">
                            <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                            <Link v-if="canResetPassword" :href="route('password.request')" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                Forgot password?
                            </Link>
                        </div>
                        <div class="relative">
                            <input id="password" v-model="form.password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="Enter your password"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 pr-11 text-gray-900 placeholder-gray-400 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg v-if="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5s8.577 3.01 9.964 7.183a1.012 1.012 0 010 .639C20.577 16.49 16.64 19.5 12 19.5s-8.577-3.01-9.964-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3l18 18M10.5 8.5A3.5 3.5 0 0114 12M6.5 12a5.49 5.49 0 002.12 4.23M17.5 12a5.49 5.49 0 00-2.12-4.23" />
                                </svg>
                            </button>
                        </div>
                        <InputError class="mt-1.5" :message="form.errors.password" />
                    </div>

                    <div class="flex items-center">
                        <label class="flex items-center gap-2 text-sm text-gray-600">
                            <Checkbox v-model:checked="form.remember" />
                            Remember me
                        </label>
                    </div>

                    <button type="submit" :disabled="form.processing"
                        class="w-full rounded-lg bg-indigo-600 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-50">
                        {{ form.processing ? 'Signing in...' : 'Sign in' }}
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-gray-500">
                    Don't have an account?
                    <Link :href="route('register')" class="font-medium text-indigo-600 hover:text-indigo-500">Create one</Link>
                </p>
            </div>
        </div>
    </div>
</template>