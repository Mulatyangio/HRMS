<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
const sidebarOpen = ref(false);
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-30 w-64 transform border-r border-gray-200 bg-white transition-transform duration-200 lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <div
                class="flex h-16 items-center justify-center border-b border-gray-200"
            >
                <Link
                    :href="route('dashboard')"
                    class="flex items-center gap-2"
                >
                    <ApplicationLogo class="h-8 w-auto" />
                    <span class="text-lg font-bold text-indigo-600">HRMS</span>
                </Link>
            </div>

            <nav class="mt-4 space-y-1 px-3">
                <Link
                    :href="route('dashboard')"
                    :class="
                        route().current('dashboard')
                            ? 'flex items-center gap-3 rounded-lg bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-700'
                            : 'flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900'
                    "
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                        />
                    </svg>
                    Home
                </Link>

                <div class="pt-4">
                    <p
                        class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-400"
                    >
                        Employee Management
                    </p>
                </div>

                <Link
                    :href="route('employees')"
                    :class="
                        route().current('employees*')
                            ? 'flex items-center gap-3 rounded-lg bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-700'
                            : 'flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900'
                    "
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                        />
                    </svg>
                    Employees
                </Link>

                <Link
                    :href="route('departments')"
                    :class="
                        route().current('departments*')
                            ? 'flex items-center gap-3 rounded-lg bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-700'
                            : 'flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900'
                    "
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                        />
                    </svg>
                    Departments
                </Link>

                <div class="pt-4">
                    <p
                        class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-400"
                    >
                        Time & Attendance
                    </p>
                </div>

                <Link
                    :href="route('dashboard')"
                    :class="
                        route().current('attendance*')
                            ? 'flex items-center gap-3 rounded-lg bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-700'
                            : 'flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900'
                    "
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
                        />
                    </svg>
                    Attendance
                </Link>

                <Link
                    :href="route('dashboard')"
                    :class="
                        route().current('leaves*')
                            ? 'flex items-center gap-3 rounded-lg bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-700'
                            : 'flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900'
                    "
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                        />
                    </svg>
                    Leave Management
                </Link>

                <div class="pt-4">
                    <p
                        class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-400"
                    >
                        Payroll
                    </p>
                </div>

                <Link
                    :href="route('dashboard')"
                    :class="
                        route().current('payroll*')
                            ? 'flex items-center gap-3 rounded-lg bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-700'
                            : 'flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900'
                    "
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                    Payroll
                </Link>

                <div class="pt-4">
                    <p
                        class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-400"
                    >
                        Reports
                    </p>
                </div>

                <Link
                    :href="route('dashboard')"
                    :class="
                        route().current('reports*')
                            ? 'flex items-center gap-3 rounded-lg bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-700'
                            : 'flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900'
                    "
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>
                    Reports
                </Link>
            </nav>
        </aside>

        <!-- Overlay for mobile -->
        <div
            v-if="sidebarOpen"
            class="fixed inset-0 z-20 bg-black/50 lg:hidden"
            @click="sidebarOpen = false"
        />

        <!-- Main content area -->
        <div class="lg:pl-64">
            <!-- Top navbar -->
            <nav class="sticky top-0 z-10 border-b border-gray-200 bg-white">
                <div
                    class="flex h-16 items-center justify-between px-4 sm:px-6"
                >
                    <div class="flex items-center gap-4">
                        <button
                            @click="sidebarOpen = !sidebarOpen"
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none lg:hidden"
                        >
                            <svg
                                class="h-6 w-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                            </svg>
                        </button>

                        <div class="relative">
                            <svg
                                class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>
                            <input
                                type="text"
                                placeholder="Search employees..."
                                class="w-64 rounded-lg border-gray-200 bg-gray-50 py-2 pl-10 pr-3 text-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500"
                            />
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <!-- Notifications -->
                        <button
                            class="relative rounded-full p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none"
                        >
                            <svg
                                class="h-6 w-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                                />
                            </svg>
                            <span
                                class="absolute -right-0.5 -top-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white"
                                >3</span
                            >
                        </button>

                        <!-- User Dropdown -->
                        <div class="relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button
                                        class="flex items-center gap-2 rounded-full p-1 hover:bg-gray-100 focus:outline-none"
                                    >
                                        <div
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-medium text-indigo-600"
                                        >
                                            {{
                                                $page.props.auth.user.name
                                                    .charAt(0)
                                                    .toUpperCase()
                                            }}
                                        </div>
                                        <span
                                            class="hidden text-sm font-medium text-gray-700 sm:block"
                                            >{{
                                                $page.props.auth.user.name
                                            }}</span
                                        >
                                        <svg
                                            class="h-4 w-4 text-gray-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 9l-7 7-7-7"
                                            />
                                        </svg>
                                    </button>
                                </template>
                                <template #content>
                                    <DropdownLink :href="route('profile.edit')"
                                        >Profile</DropdownLink
                                    >
                                    <DropdownLink
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        >Log Out</DropdownLink
                                    >
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow-sm" v-if="$slots.header">
                <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 sm:p-6 lg:p-8">
                <slot />
            </main>
        </div>
    </div>
</template>
