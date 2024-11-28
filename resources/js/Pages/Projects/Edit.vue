<script setup>
import { Head, useForm, usePage, router} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TaskModal from './Partials/TaskModal.vue';
import TaskModalEdit from './Partials/TaskModalEdit.vue';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

defineProps({
    project: Object,
    users: Object,
});

const project = usePage().props.project;
const users = usePage().props.users;
const errors = usePage().props.errors;
const user = usePage().props.auth.user

const form = useForm({
    id: project.id,
    name: project.name,
    description: project.description,
    start_date: project.start_date,
    end_date: project.end_date,
});

const openModal = ref(false);
const openModalEdit = ref(false);

const openTaskModal = () => {
    openModal.value = true;
};

const closeTaskModal = () => {
  openModal.value = false;
};

const closeTaskModalEdit = () => {
    openModalEdit.value = false;
};
const reloadTask = () => {
    Inertia.reload({ only: ['project'] });
};

const selectedTaskId = ref(null);

const editTask = (taskId) => {
    selectedTaskId.value = taskId;
    openModalEdit.value = true;
};

const deleteTask = (taskId) => {
    if (confirm('Are you sure you want to delete this task?')) {
        router.delete(route('task.destroy', taskId));
        reloadTask()
    }
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
                    /Update
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
                        
                        <div class="mt-6" v-if="user && user.role === 1" >
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

                <div v-if="user && user.role === 1">
                    <button 
                    type="button"
                    class="rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700"
                    @click="openTaskModal"
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
                        <div class="flex justify-between items-start">
                            <!-- Información de la tarea -->
                            <div class="flex flex-col space-y-2">
                                <h3 class="font-semibold text-lg">{{ task.name }}</h3>
                                <p class="text-gray-500 text-sm">{{ task.description }}</p>
                                <label class="text-gray-500 text-sm">Responsable: {{ task.user?.name || user.name }}</label>

                                <!-- Fechas -->
                                <div class="text-sm text-gray-500">
                                    <p><strong>Start Date:</strong> {{ task.start_date }}</p>
                                    <p><strong>End Date:</strong> {{ task.end_date }}</p>
                                </div>
                            </div>

                            <!-- Estado de la tarea -->
                            <div class="flex items-center">
                                <span class="text-sm text-gray-500">
                                    {{ task.status == 0 ? 'Pending' : task.status == 1 ? 'In Process' : 'Finished' }}
                                </span>
                            </div>
                        </div>

                        <!-- Botones de acción: Editar y Eliminar -->
                        <div class="flex justify-end mt-4 space-x-4">
                            <!-- Botón Editar -->
                            <button 
                                @click="editTask(task.id)"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700"
                            >
                                Edit
                            </button>

                            <TaskModalEdit
                                ref="taskModal" 
                                v-if="openModalEdit && selectedTaskId === task.id"
                                @close="closeTaskModalEdit" 
                                @reload="reloadTask"
                                :task="task" 
                                :users="users"
                                :user="user"
                            />

                            <!-- Botón Eliminar -->
                            <button 
                                @click="deleteTask(task.id)"
                                class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700"
                                v-if="user && user.role === 1"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </AuthenticatedLayout>
</template>
