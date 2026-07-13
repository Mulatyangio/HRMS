<script setup>
const props = defineProps({
    filters: { type: Object, default: () => ({}) },
});

const exportReport = (type) => {
    const params = { type };

    if (props.filters.from) params.from = props.filters.from;
    if (props.filters.to) params.to = props.filters.to;
    if (props.filters.department) params.department = props.filters.department;
    if (props.filters.status) params.status = props.filters.status;

    const url = route('reports.export', params);
    window.open(url, '_blank');
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
