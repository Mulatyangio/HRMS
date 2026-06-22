<script setup>
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Create Account" />

    <div class="flex min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50">
        <!-- Left Panel -->
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
                <h1 class="text-4xl font-bold text-white">Streamline your HR operations</h1>
                <p class="mt-4 text-lg text-indigo-100">Join thousands of companies using HRMS to manage their workforce.</p>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="flex w-full items-center justify-center px-4 lg:w-1/2">
            <div class="w-full max-w-sm">
                <div class="mb-8 text-center lg:text-left">
                    <div class="mb-6 flex items-center justify-center gap-2 lg:justify-start">
                        <ApplicationLogo class="h-8 w-auto" />
                        <span class="text-xl font-bold text-indigo-600">HRMS</span>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">Create an account</h1>
                    <p class="mt-1 text-sm text-gray-500">Get started with your HRMS account.</p>
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700">Full Name</label>
                        <input id="name" v-model="form.name" type="text" required autofocus autocomplete="name" placeholder="John Doe"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                        <InputError class="mt-1.5" :message="form.errors.name" />
                    </div>

                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" v-model="form.email" type="email" required autocomplete="username" placeholder="you@company.com"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                        <InputError class="mt-1.5" :message="form.errors.email" />
                    </div>

                    <div>
                        <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" v-model="form.password" type="password" required autocomplete="new-password" placeholder="Create a password"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                        <InputError class="mt-1.5" :message="form.errors.password" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input id="password_confirmation" v-model="form.password_confirmation" type="password" required autocomplete="new-password" placeholder="Confirm your password"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 placeholder-gray-400 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" />
                        <InputError class="mt-1.5" :message="form.errors.password_confirmation" />
                    </div>

                    <button type="submit" :disabled="form.processing"
                        class="w-full rounded-lg bg-indigo-600 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-50">
                        {{ form.processing ? 'Creating account...' : 'Create account' }}
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-gray-500">
                    Already have an account?
                    <Link :href="route('login')" class="font-medium text-indigo-600 hover:text-indigo-500">Sign in</Link>
                </p>
            </div>
        </div>
    </div>
</template>
