<script setup>
import { Head, useForm, usePage, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    project: Object,
});

const project = usePage().props.project;

const form = useForm({
    id: project.id,
    name: project.name,
    description: project.description,
    start_date: project.start_date,
    end_date: project.start_date,
});
</script>

<template>
    <Head title="Edit User" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit User
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <!-- Menú para volver a la lista de usuarios -->
                <div class="mb-4">
                    <a
                    :href="route('projects')"
                    class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900"
                    >
                    Projects
                    </a>
                    /Edit
                </div>

                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p v-if="form.recentlySuccessful" class="text-sm text-green-600">
                            Project Updated.
                        </p>
                    </Transition>
                    <h2 class="text-lg font-bold mb-4">Edit Project</h2>
                    <form @submit.prevent="form.patch(route('project.update', form.id))">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        </div>

                        <div class="mt-6">
                            <button
                                type="submit"
                                class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                                :disabled="form.processing"
                            >
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
