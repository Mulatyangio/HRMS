<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const props = defineProps({ status: String });

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <Head title="Email Verification" />

    <div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 px-4">
        <div class="w-full max-w-sm">
            <div class="mb-8 text-center">
                <div class="mb-4 flex items-center justify-center gap-2">
                    <ApplicationLogo class="h-8 w-auto" />
                    <span class="text-xl font-bold text-indigo-600">HRMS</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Verify your email</h1>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="mb-4 text-sm text-gray-600">
                    Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we'll gladly send you another.
                </div>

                <div v-if="verificationLinkSent" class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    A new verification link has been sent to your email address.
                </div>

                <form @submit.prevent="submit" class="flex items-center justify-between">
                    <button type="submit" :disabled="form.processing"
                        class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-50">
                        {{ form.processing ? 'Sending...' : 'Resend verification email' }}
                    </button>

                    <Link :href="route('logout')" method="post" as="button"
                        class="text-sm font-medium text-gray-500 underline hover:text-gray-700">
                        Log out
                    </Link>
                </form>
            </div>
        </div>
    </div>
</template>
