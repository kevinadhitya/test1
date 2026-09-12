<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
    appointments: Object,
});

const userTimezone = usePage().props.auth.user.preferred_timezone || 'UTC';

const formatTime = (utcString) => {
    if (!utcString) return '-';
    try {
        const date = new Date(utcString);
        return new Intl.DateTimeFormat('id-ID', {
            dateStyle: 'medium',
            timeStyle: 'short',
            timeZone: userTimezone
        }).format(date);
    } catch (e) {
        return utcString;
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Appointments" />

        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Appointments</h2>
                <Link :href="route('appointments.create')" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm transition-colors">
                    + New Appointment
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div class="mb-6 bg-indigo-50 border-l-4 border-indigo-500 text-indigo-700 p-4 rounded shadow-sm" role="alert">
                    <p class="font-medium">Waktu ditampilkan dalam zona waktu Anda: <strong>{{ userTimezone }}</strong></p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-gray-50 text-gray-700">
                                    <th class="border-b py-3 px-4 text-sm font-semibold">Title</th>
                                    <th class="border-b py-3 px-4 text-sm font-semibold">Creator</th>
                                    <th class="border-b py-3 px-4 text-sm font-semibold">Start (Local)</th>
                                    <th class="border-b py-3 px-4 text-sm font-semibold">End (Local)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="appointment in appointments.data" :key="appointment.id" class="hover:bg-gray-50 transition-colors border-b last:border-0">
                                    <td class="py-4 px-4 font-medium text-gray-800">{{ appointment.title }}</td>
                                    <td class="py-4 px-4">{{ appointment.creator.name }}</td>
                                    <td class="py-4 px-4 text-indigo-600">{{ formatTime(appointment.start) }}</td>
                                    <td class="py-4 px-4 text-rose-600">{{ formatTime(appointment.end) }}</td>
                                </tr>
                                <tr v-if="appointments.data.length === 0">
                                    <td colspan="4" class="text-center py-8 text-gray-500">Belum ada jadwal yang melibatkan Anda.</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <!-- Pagination -->
                        <div class="mt-6 flex justify-center space-x-1" v-if="appointments.meta && appointments.meta.links">
                            <template v-for="link in appointments.meta.links" :key="link.label">
                                <Link
                                    v-if="link.url"
                                    :href="link.url"
                                    class="px-3 py-1 border rounded text-sm transition-colors"
                                    :class="link.active ? 'bg-indigo-600 border-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                                    v-html="link.label"
                                />
                                <span v-else class="px-3 py-1 border rounded text-sm text-gray-400 bg-gray-50 cursor-not-allowed" v-html="link.label"></span>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
