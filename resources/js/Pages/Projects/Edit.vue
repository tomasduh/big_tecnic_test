<script setup>
import { Head, useForm, usePage,} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TaskModal from './Partials/TaskModal.vue';
import { ref } from 'vue';

defineProps({
    project: Object,
    users: Object,
});

const project = usePage().props.project;
const users = usePage().props.users;
const errors = usePage().props.errors;

const form = useForm({
    id: project.id,
    name: project.name,
    description: project.description,
    start_date: project.start_date,
    end_date: project.end_date,
});

const openModal = ref(false);
const openTaskModal = () => {
    openModal.value = true;
};

const reloadTask = () => {
    Inertia.reload({ only: ['project'] });
};

const closeTaskModal = () => {
  openModal.value = false;
};
</script>

<template>
    <Head title="Edit Project" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit Project
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

                <div class="bg-white p-6 shadow sm:rounded-lg">
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
                    <form @submit.prevent="form.patch(route('project.update', form.id))">
                        <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Project Name</label>
                        <input
                            id="name"
                            type="text"
                            v-model="form.name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                        <span v-if="errors.name" class="text-red-600 text-xs mt-1">{{ errors.name }}</span>
                        </div>

                        <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea
                            id="description"
                            v-model="form.description"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            rows="4"
                        ></textarea>
                        <span v-if="errors.description" class="text-red-600 text-xs mt-1">{{ errors.description }}</span>
                        </div>

                        <div class="grid grid-cols-2 gap-6 mb-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input
                            id="start_date"
                            type="date"
                            v-model="form.start_date"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            />
                            <span v-if="errors.start_date" class="text-red-600 text-xs mt-1">{{ errors.start_date }}</span>
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input
                            id="end_date"
                            type="date"
                            v-model="form.end_date"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            />
                            <span v-if="errors.end_date" class="text-red-600 text-xs mt-1">{{ errors.end_date }}</span>
                        </div>
                        </div>

                        <div class="mt-6">
                        <button
                            type="submit"
                            class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                            :disabled="form.processing"
                        >
                            Save Project
                        </button>
                        </div>
                    </form>
                </div>

                <div>
                    <button 
                    type="button"
                    class="rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700"
                    @click="openTaskModal"
                    :disabled="form.processing"
                    >
                    Create Task
                    </button>

                    <TaskModal 
                        ref="taskModal" 
                        v-if="openModal"  
                        @close="closeTaskModal" 
                        @reload="reloadTask"
                        :users="users" 
                        :projectId="project.id"
                    />

                </div>

                <div v-for="task in project.tasks" :key="task.id">
                    <div class="bg-white p-6 shadow sm:rounded-lg">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="font-semibold">{{ task.name }}</h3>
                                <p class="text-gray-500 text-sm">{{ task.description }}</p>
                            </div>
                            <span class="text-sm text-gray-500">{{ task.status }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
