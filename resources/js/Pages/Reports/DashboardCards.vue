<script setup>
const props = defineProps({
    summary: {
        type: Object,
        default: () => ({
            employees: 0,
            departments: 0,
            presentToday: 0,
            absentToday: 0,
            leaveToday: 0,
            monthlyPayroll: 0,
        }),
    },
});

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-KE', {
        style: 'currency',
        currency: 'KES',
        maximumFractionDigits: 2,
    }).format(amount || 0);
};
</script>

<template>
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-6">

        <!-- Employees -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition"
        >
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">
                        Total Employees
                    </p>

                    <h2 class="text-3xl font-bold text-gray-900 mt-2">
                        {{ summary.employees }}
                    </h2>
                </div>

                <div
                    class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center"
                >
                    👥
                </div>
            </div>
        </div>

        <!-- Departments -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition"
        >
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">
                        Departments
                    </p>

                    <h2 class="text-3xl font-bold text-gray-900 mt-2">
                        {{ summary.departments }}
                    </h2>
                </div>

                <div
                    class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center"
                >
                    🏢
                </div>
            </div>
        </div>

        <!-- Present -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition"
        >
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">
                        Present Today
                    </p>

                    <h2 class="text-3xl font-bold text-green-600 mt-2">
                        {{ summary.presentToday }}
                    </h2>
                </div>

                <div
                    class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center"
                >
                    ✅
                </div>
            </div>
        </div>

        <!-- Absent -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition"
        >
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">
                        Absent Today
                    </p>

                    <h2 class="text-3xl font-bold text-red-600 mt-2">
                        {{ summary.absentToday }}
                    </h2>
                </div>

                <div
                    class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center"
                >
                    ❌
                </div>
            </div>
        </div>

        <!-- On Leave -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition"
        >
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">
                        On Leave
                    </p>

                    <h2 class="text-3xl font-bold text-yellow-600 mt-2">
                        {{ summary.leaveToday }}
                    </h2>
                </div>

                <div
                    class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center"
                >
                    🏖️
                </div>
            </div>
        </div>

        <!-- Payroll -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition"
        >
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">
                        Monthly Payroll
                    </p>

                    <h2 class="text-2xl font-bold text-indigo-600 mt-2">
                        {{ formatCurrency(summary.monthlyPayroll) }}
                    </h2>
                </div>

                <div
                    class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center"
                >
                    💰
                </div>
            </div>
        </div>

    </div>
</template>