<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-gray-900 min-h-screen flex flex-col font-sans antialiased">
        
        <!-- Header / Navigation -->
        <header class="w-full flex justify-end items-center p-6 lg:p-8">
            <div v-if="canLogin">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="rounded-md px-4 py-2 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 font-semibold transition-colors ring-1 ring-transparent focus:outline-none focus-visible:ring-indigo-500"
                >
                    Dashboard
                </Link>
                <Link
                    v-else
                    :href="route('login')"
                    class="rounded-md px-6 py-2.5 text-white bg-indigo-600 hover:bg-indigo-700 font-semibold transition-colors shadow-sm focus:outline-none focus-visible:ring-indigo-500"
                >
                    Log in
                </Link>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900 mb-4">
                    Manage Your Schedule
                </h1>
                <p class="text-lg text-gray-600 max-w-xl mx-auto">
                    Organize your time effectively across different timezones. Choose an option below to get started.
                </p>
            </div>

            <!-- The Two Rectangular Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-4xl">
                
                <!-- Appointment List Card -->
                <Link 
                    :href="route('appointments.index')" 
                    class="group relative overflow-hidden bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 ease-in-out transform hover:-translate-y-1 flex flex-col items-center justify-center text-center p-8 md:p-10 min-h-[16rem]"
                >
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-white opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="bg-indigo-100 text-indigo-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Appointment List Page</h2>
                        <p class="text-gray-500">View and manage all your scheduled appointments.</p>
                    </div>
                </Link>

                <!-- Appointment Creation Card -->
                <Link 
                    :href="route('appointments.create')" 
                    class="group relative overflow-hidden bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 ease-in-out transform hover:-translate-y-1 flex flex-col items-center justify-center text-center p-8 md:p-10 min-h-[16rem]"
                >
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-white opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="bg-emerald-100 text-emerald-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Appointment Creation Form</h2>
                        <p class="text-gray-500">Schedule a new meeting across multiple timezones.</p>
                    </div>
                </Link>

            </div>
        </main>
        
        <footer class="py-6 text-center text-sm text-gray-500">
            Technical Test - Full Stack Developer Assignment
        </footer>
    </div>
</template>
