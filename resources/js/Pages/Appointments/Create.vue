<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    users: Array,
});

const userTimezone = usePage().props.auth.user.preferred_timezone || 'UTC';

const form = useForm({
    title: '',
    start: '',
    end: '',
    invitees: [],
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        // Convert local datetime input to UTC ISO String before sending to backend
        start: data.start ? new Date(data.start).toISOString() : '',
        end: data.end ? new Date(data.end).toISOString() : '',
    })).post(route('appointments.store'));
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Create Appointment" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Appointment</h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-800 p-4 mb-6 rounded shadow-sm">
                    <p class="text-sm">
                        <strong>Aturan:</strong> Jadwal hanya bisa dibuat jika jam mulai dan selesai berada pada <strong>jam kerja (08:00 - 17:00)</strong> di zona waktu lokal <strong>seluruh partisipan</strong> yang terlibat.
                    </p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit" class="space-y-6">
                            
                            <div>
                                <InputLabel for="title" value="Title" />
                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.title"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel for="start" :value="'Start Time (' + userTimezone + ')'" />
                                    <TextInput
                                        id="start"
                                        type="datetime-local"
                                        class="mt-1 block w-full"
                                        v-model="form.start"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.start" />
                                </div>

                                <div>
                                    <InputLabel for="end" :value="'End Time (' + userTimezone + ')'" />
                                    <TextInput
                                        id="end"
                                        type="datetime-local"
                                        class="mt-1 block w-full"
                                        v-model="form.end"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.end" />
                                </div>
                            </div>

                            <div>
                                <InputLabel for="invitees" value="Invitees (Optional)" />
                                <select
                                    id="invitees"
                                    multiple
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm h-32"
                                    v-model="form.invitees"
                                >
                                    <option v-for="user in users" :key="user.id" :value="user.id">
                                        {{ user.name }} ({{ user.preferred_timezone }})
                                    </option>
                                </select>
                                <p class="text-xs text-gray-500 mt-2">Tahan tombol Ctrl (Windows) / Cmd (Mac) untuk memilih lebih dari satu orang.</p>
                                <InputError class="mt-2" :message="form.errors.invitees" />
                            </div>

                            <div class="flex items-center justify-end">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Save Appointment
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
