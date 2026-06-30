<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    head: '',
});
const submit = () => {
    form.post(route('departments.store'));
};
</script>

<template>
    <Head title="Create Department" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">
                    Create Department
                </h2>

                <Link
                    :href="route('departments.index')"
                    class="rounded-md bg-gray-700 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
                >
                    Back
                </Link>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-3xl">
                <div class="rounded-lg bg-white p-6 shadow">
                    <form @submit.prevent="submit" class="space-y-6">

                        <!-- Department Name -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Department Name
                            </label>

                            <input
                                v-model="form.name"
                                type="text"
                                placeholder="e.g. Human Resources"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-indigo-500"
                            />

                            <p
                                v-if="form.errors.name"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.name }}
                            </p>
                        </div>

                        <!-- Department Head -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Department Head
                            </label>

                            <input
                                v-model="form.head"
                                type="text"
                                placeholder="Department Head (Optional)"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-indigo-500"
                            />

                            <p
                                v-if="form.errors.head"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.head }}
                            </p>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3">
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="rounded-lg bg-indigo-600 px-5 py-2 text-white hover:bg-indigo-700 disabled:opacity-50"
                            >
                                {{
                                    form.processing
                                        ? 'Saving...'
                                        : 'Create Department'
                                }}
                            </button>

                            <Link
                                :href="route('departments.index')"
                                class="rounded-lg bg-gray-500 px-5 py-2 text-white hover:bg-gray-600"
                            >
                                Cancel
                            </Link>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>