<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link, router } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
const sidebarOpen = ref(false);

const notifications = ref([]);
const unreadCount = ref(0);
const showNotifications = ref(false);

const notificationIcons = {
    employee_added: { color: 'bg-green-100 text-green-600', icon: 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z' },
    employee_removed: { color: 'bg-red-100 text-red-600', icon: 'M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6' },
    payroll_processed: { color: 'bg-blue-100 text-blue-600', icon: 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z' },
    leave_approved: { color: 'bg-emerald-100 text-emerald-600', icon: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' },
    leave_rejected: { color: 'bg-orange-100 text-orange-600', icon: 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z' },
};

const defaultIcon = { color: 'bg-gray-100 text-gray-600', icon: 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9' };

function getNotificationIcon(type) {
    return notificationIcons[type] || defaultIcon;
}

function getNotificationStyle(type) {
    return getNotificationIcon(type).color;
}

function getNotificationSvgPath(type) {
    return getNotificationIcon(type).icon;
}

async function fetchNotifications() {
    try {
        const response = await fetch(route('notifications.index'));
        const data = await response.json();
        notifications.value = data.notifications;
        unreadCount.value = data.unread_count;
    } catch (e) {
        console.error('Failed to fetch notifications:', e);
    }
}

async function markAsRead(id) {
    try {
        const response = await fetch(route('notifications.markRead', id), {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        });
        const data = await response.json();
        unreadCount.value = data.unread_count;
        const notif = notifications.value.find(n => n.id === id);
        if (notif) notif.is_read = true;
    } catch (e) {
        console.error('Failed to mark notification as read:', e);
    }
}

async function markAllAsRead() {
    try {
        const response = await fetch(route('notifications.markAllRead'), {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        });
        const data = await response.json();
        unreadCount.value = data.unread_count;
        notifications.value.forEach(n => n.is_read = true);
    } catch (e) {
        console.error('Failed to mark all as read:', e);
    }
}

function toggleNotifications() {
    showNotifications.value = !showNotifications.value;
    if (showNotifications.value) {
        fetchNotifications();
    }
}

function closeNotifications() {
    showNotifications.value = false;
}

function handleClickOutside(e) {
    if (!e.target.closest('.notification-bell-wrapper')) {
        showNotifications.value = false;
    }
}

function timeAgo(dateStr) {
    const now = new Date();
    const date = new Date(dateStr);
    const seconds = Math.floor((now - date) / 1000);
    if (seconds < 60) return 'just now';
    const minutes = Math.floor(seconds / 60);
    if (minutes < 60) return minutes + 'm ago';
    const hours = Math.floor(minutes / 60);
    if (hours < 24) return hours + 'h ago';
    const days = Math.floor(hours / 24);
    return days + 'd ago';
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
    fetchNotifications();
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});
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
                    :href="route('attendance')"
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
                    :href="route('leaves')"
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
                    :href="route('payroll')"
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
                    :href="route('reports')"
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
                        <div class="relative notification-bell-wrapper">
                            <button
                                @click.stop="toggleNotifications"
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
                                    v-if="unreadCount > 0"
                                    class="absolute -right-0.5 -top-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white"
                                >{{ unreadCount > 9 ? '9+' : unreadCount }}</span>
                            </button>

                            <Transition
                                enter-active-class="transition ease-out duration-200"
                                enter-from-class="opacity-0 scale-95"
                                enter-to-class="opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="opacity-100 scale-100"
                                leave-to-class="opacity-0 scale-95"
                            >
                                <div
                                    v-if="showNotifications"
                                    class="absolute right-0 z-50 mt-2 w-80 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5"
                                >
                                    <div class="border-b border-gray-100 px-4 py-3 flex items-center justify-between">
                                        <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                                        <button
                                            v-if="unreadCount > 0"
                                            @click.stop="markAllAsRead"
                                            class="text-xs text-indigo-600 hover:text-indigo-800 font-medium"
                                        >Mark all read</button>
                                    </div>
                                    <div class="max-h-80 overflow-y-auto">
                                        <div
                                            v-if="notifications.length === 0"
                                            class="py-8 text-center text-sm text-gray-500"
                                        >
                                            <svg class="mx-auto h-8 w-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                            </svg>
                                            No notifications yet
                                        </div>
                                        <button
                                            v-for="notification in notifications"
                                            :key="notification.id"
                                            @click.stop="markAsRead(notification.id)"
                                            class="w-full text-left px-4 py-3 hover:bg-gray-50 flex items-start gap-3 transition-colors"
                                            :class="{ 'bg-indigo-50/50': !notification.is_read }"
                                        >
                                            <div class="flex-shrink-0 mt-0.5">
                                                <div class="flex h-8 w-8 items-center justify-center rounded-full" :class="getNotificationStyle(notification.type)">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="getNotificationSvgPath(notification.type)" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-gray-900" :class="{ 'font-semibold': !notification.is_read }">{{ notification.title }}</p>
                                                <p class="text-xs text-gray-500 mt-0.5 truncate">{{ notification.message }}</p>
                                                <p class="text-xs text-gray-400 mt-1">{{ timeAgo(notification.created_at) }}</p>
                                            </div>
                                            <div v-if="!notification.is_read" class="flex-shrink-0 mt-2">
                                                <span class="h-2 w-2 rounded-full bg-indigo-500 block"></span>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </Transition>
                        </div>

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
                                                $page.props.auth.user?.name
                                                    ?.charAt(0)
                                                    ?.toUpperCase() ?? '?'
                                            }}
                                        </div>
                                        <span
                                            class="hidden text-sm font-medium text-gray-700 sm:block"
                                            >{{
                                                $page.props.auth.user?.name ?? 'User'
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
