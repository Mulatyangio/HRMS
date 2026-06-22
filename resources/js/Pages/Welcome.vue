<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: { type: Boolean },
    canRegister: { type: Boolean },
});

const features = [
    { title: 'Employee Management', description: 'Manage employee records, documents, and profiles in one place.', icon: 'users' },
    { title: 'Attendance Tracking', description: 'Track clock-ins, clock-outs, and working hours with ease.', icon: 'clock' },
    { title: 'Leave Management', description: 'Handle leave requests, approvals, and balances seamlessly.', icon: 'calendar' },
    { title: 'Payroll Processing', description: 'Automate payroll calculations, deductions, and disbursements.', icon: 'dollar' },
    { title: 'Performance Reviews', description: 'Conduct reviews, set goals, and track employee growth.', icon: 'chart' },
    { title: 'Reports & Analytics', description: 'Generate insights with detailed HR analytics and reports.', icon: 'report' },
];
</script>

<template>
    <Head title="Welcome" />

    <div class="bg-white">
        <!-- Nav -->
        <header class="sticky top-0 z-50 border-b border-gray-100 bg-white/80 backdrop-blur-lg">
            <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-2">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900">HRMS</span>
                </div>

                <nav v-if="canLogin" class="flex items-center gap-4">
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">
                        Dashboard
                    </Link>
                    <template v-else>
                        <Link :href="route('login')" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            Log in
                        </Link>
                        <Link v-if="canRegister" :href="route('register')" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">
                            Get Started
                        </Link>
                    </template>
                </nav>
            </div>
        </header>

        <main>
            <!-- Hero -->
            <section class="relative overflow-hidden pt-16 pb-20 sm:pt-24">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 via-white to-purple-50"></div>
                <div class="absolute right-0 top-0 h-96 w-96 translate-x-1/2 -translate-y-1/2 rounded-full bg-indigo-100/50 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 h-64 w-64 -translate-x-1/3 translate-y-1/3 rounded-full bg-purple-100/50 blur-3xl"></div>

                <div class="relative mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl lg:text-6xl">
                        Manage Your Workforce
                        <span class="text-indigo-600">Effortlessly</span>
                    </h1>
                    <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-gray-600">
                        A complete human resource management system to manage employees, attendance, leaves, payroll, and more — all in one place.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-4">
                        <Link v-if="canRegister && !$page.props.auth.user" :href="route('register')" class="rounded-lg bg-indigo-600 px-8 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-500">
                            Start Free Trial
                        </Link>
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="rounded-lg bg-indigo-600 px-8 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-500">
                            Go to Dashboard
                        </Link>
                        <a href="#features" class="rounded-lg border border-gray-300 bg-white px-8 py-3 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                            Learn More
                        </a>
                    </div>
                    <div class="mt-16 grid grid-cols-3 gap-8 border-t border-gray-200 pt-8">
                        <div>
                            <p class="text-3xl font-bold text-indigo-600">10K+</p>
                            <p class="mt-1 text-sm text-gray-500">Employees Managed</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-indigo-600">500+</p>
                            <p class="mt-1 text-sm text-gray-500">Companies Trust Us</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-indigo-600">99.9%</p>
                            <p class="mt-1 text-sm text-gray-500">Uptime Guarantee</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features -->
            <section id="features" class="py-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900">Everything you need to manage HR</h2>
                        <p class="mt-4 text-lg text-gray-600">Powerful features to streamline your HR operations.</p>
                    </div>
                    <div class="mt-16 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <div v-for="feature in features" :key="feature.title" class="rounded-xl border border-gray-200 p-6 transition hover:border-indigo-200 hover:shadow-md">
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                                <svg v-if="feature.icon === 'users'" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <svg v-else-if="feature.icon === 'clock'" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <svg v-else-if="feature.icon === 'calendar'" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <svg v-else-if="feature.icon === 'dollar'" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <svg v-else-if="feature.icon === 'chart'" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <svg v-else class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-semibold text-gray-900">{{ feature.title }}</h3>
                            <p class="mt-2 text-sm text-gray-600">{{ feature.description }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA -->
            <section class="bg-indigo-600 py-16">
                <div class="mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-bold text-white">Ready to simplify your HR?</h2>
                    <p class="mt-4 text-lg text-indigo-100">Get started today and take control of your workforce management.</p>
                    <div class="mt-8">
                        <Link v-if="canRegister && !$page.props.auth.user" :href="route('register')" class="rounded-lg bg-white px-8 py-3 text-base font-medium text-indigo-600 shadow-sm hover:bg-indigo-50">
                            Get Started Free
                        </Link>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="bg-gray-50 py-8">
                <div class="mx-auto max-w-7xl px-4 text-center text-sm text-gray-500 sm:px-6 lg:px-8">
                    &copy; {{ new Date().getFullYear() }} HRMS. All rights reserved.
                </div>
            </footer>
        </main>
    </div>
</template>
