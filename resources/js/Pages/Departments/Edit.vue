<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    department: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    name: props.department.name,
});

const headName = props.department.head_name || 'N/A';

const submit = () => {
    form.put(route('departments.update', department.id));
};
</script>

<template>
    <Head title="Edit Department" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Edit Department</h2>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-2xl">
                <div class="rounded-lg bg-white p-6 shadow">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Name</label>
                            <input v-model="form.name" type="text" class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm" required />
                            <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Department Head</label>
                            <p class="rounded-lg bg-gray-100 py-2 px-3 text-sm text-gray-700">{{ headName }}</p>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500" :disabled="form.processing">
                                Update
                            </button>
                            <Link :href="route('departments')" class="text-sm text-gray-600 hover:text-gray-900">Cancel</Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
