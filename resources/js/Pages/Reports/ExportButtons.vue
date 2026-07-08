<script setup>
import { router } from '@inertiajs/vue3';

const exportReport = (type) => {
    window.open(route('reports.export', { type }), '_blank');
};
</script>

<template>
    <div class="flex flex-wrap items-center gap-3">

        <button
            @click="exportReport('pdf')"
            class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-white shadow hover:bg-red-700 transition"
        >
            📄
            <span>PDF</span>
        </button>

        <button
            @click="exportReport('excel')"
            class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-white shadow hover:bg-green-700 transition"
        >
            📊
            <span>Excel</span>
        </button>

        <button
            @click="exportReport('csv')"
            class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-white shadow hover:bg-blue-700 transition"
        >
            📁
            <span>CSV</span>
        </button>

    </div>
</template>