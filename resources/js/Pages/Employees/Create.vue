<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    departments: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    name: '',
    email: '',
    department: '',
    phone: '',
    position: '',
    status: 'active',
    salary: '',
    hired_at: '',
    is_department_head: false,
    password: '',
    password_confirmation: '',
});

const deptSearch = ref('');
const deptOpen = ref(false);

const filteredDepts = computed(() => {
    const term = deptSearch.value.toLowerCase();
    if (!term) return props.departments;
    return props.departments.filter(d => d.name.toLowerCase().includes(term));
});

const selectDept = (name) => {
    form.department = name;
    deptSearch.value = name;
    deptOpen.value = false;
};

const onDeptInput = () => {
    form.department = '';
    deptOpen.value = true;
};

const submit = () => {
    form.post(route('employees.store'));
};
</script>

<template>
    <Head title="Create Employee" />

    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto py-8 px-4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    Add Employee
                </h1>

                <Link
                    :href="route('employees')"
                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700"
                >
                    Back
                </Link>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name
                            </label>
                            <input
                                v-model="form.name"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                placeholder="John Doe"
                            />
                            <p
                                v-if="form.errors.name"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.name }}
                            </p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address
                            </label>
                            <input
                                v-model="form.email"
                                type="email"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                placeholder="john@example.com"
                            />
                            <p
                                v-if="form.errors.email"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <!-- Department -->
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Department
                            </label>
                            <input
                                v-model="deptSearch"
                                @input="onDeptInput"
                                @focus="deptOpen = true"
                                @blur="setTimeout(() => deptOpen = false, 200)"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                placeholder="Search department..."
                            />
                            <ul
                                v-if="deptOpen && filteredDepts.length > 0"
                                class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-48 overflow-y-auto"
                            >
                                <li
                                    v-for="dept in filteredDepts"
                                    :key="dept.id"
                                    @mousedown.prevent="selectDept(dept.name)"
                                    class="px-4 py-2 text-sm cursor-pointer hover:bg-blue-50"
                                    :class="{ 'bg-blue-100': form.department === dept.name }"
                                >
                                    {{ dept.name }}
                                </li>
                            </ul>
                            <p
                                v-if="form.errors.department"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.department }}
                            </p>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number
                            </label>
                            <input
                                v-model="form.phone"
                                type="text"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                placeholder="+254712345678"
                            />
                            <p
                                v-if="form.errors.phone"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.phone }}
                            </p>
                        </div>
                        <!-- Position -->
                        <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Position
                        </label>
                        <input
                            v-model="form.position"
                            type="text"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Software Engineer"
                        />
                        <p v-if="form.errors.position" class="text-red-500 text-sm mt-1">
                            {{ form.errors.position }}
                        </p>
                        </div>

                        <!-- Status -->
                        <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Status
                        </label>
                        <select
                            v-model="form.status"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="on_leave">On Leave</option>
                        </select>
                        <p v-if="form.errors.status" class="text-red-500 text-sm mt-1">
                            {{ form.errors.status }}
                        </p>
                        </div>

                        <!-- Salary -->
                        <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Salary
                        </label>
                        <input
                            v-model="form.salary"
                            type="number"
                            min="0"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="50000"
                        />
                        <p v-if="form.errors.salary" class="text-red-500 text-sm mt-1">
                            {{ form.errors.salary }}
                        </p>
                        </div>

                        <!-- Hire Date -->
                        <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Hire Date
                        </label>
                        <input
                            v-model="form.hired_at"
                            type="date"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        />
                        <p v-if="form.errors.hired_at" class="text-red-500 text-sm mt-1">
                            {{ form.errors.hired_at }}
                        </p>
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Login Password
                            </label>
                            <input
                                v-model="form.password"
                                type="password"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                placeholder="Min. 8 characters"
                            />
                            <p
                                v-if="form.errors.password"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ form.errors.password }}
                            </p>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Confirm Password
                            </label>
                            <input
                                v-model="form.password_confirmation"
                                type="password"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                placeholder="Re-enter password"
                            />
                        </div>

                        <!-- Department Head -->
                        <div class="md:col-span-2">
                        <label class="flex items-center gap-3">
                            <input
                                v-model="form.is_department_head"
                                type="checkbox"
                                class="rounded border-gray-300"
                            />
                            <span class="text-sm font-medium text-gray-700">
                                Department Head
                            </span>
                        </label>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 disabled:opacity-50"
                        >
                            {{ form.processing ? 'Saving...' : 'Create Employee' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>