<script setup>
import { useForm } from '@inertiajs/vue3'; // Asegúrate de importar useForm

const emit = defineEmits();
const props = defineProps({
    users: {
        type: Array,
        required: true,
    },
    projectId: {
        type: Number,
        required: true,
    },
});

const project_id = props.projectId
const form = useForm({
    user_id: '',
    project_id: project_id,
    name: '',
    description: '',
    start_date: '',
    end_date: '',
});

const emitClose = () => {
    emit('close');
};

const emitReload = () => {
    emit('reload');
};

const submitForm = () => {
    form.post(route('task.store'), {
        onSuccess: () => {
            emitClose();
            emitReload();
        },
        onError: (errors) => {
            console.log(errors);
        }
    });
};

</script>

<template>
    <div 
      class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50"
      @click="emitClose"
    >
        <div 
            class="bg-white p-6 rounded-lg shadow-lg w-[40rem]"
            @click.stop
        >
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Create New Task</h2>
        
            <!-- Aquí usamos el formulario con useForm -->
            <form @submit.prevent="submitForm">
                <input type="hidden" value="projectId" name="project_id" v-model="form.project_id" />
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Task Name</label>
                    <input
                    id="name"
                    type="text"
                    v-model="form.name"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                </div>
        
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea
                    id="description"
                    v-model="form.description"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    rows="4"
                    ></textarea>
                </div>

                <div class="mb-4">
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input
                        id="start_date"
                        type="date"
                        v-model="form.start_date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                </div>

                <div class="mb-4">
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                    <input
                        id="end_date"
                        type="date"
                        v-model="form.end_date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                </div>

                <div class="mb-4">
                    <label for="user_id" class="block text-sm font-medium text-gray-700">Responsable</label>
                    <select
                        id="user_id"
                        v-model="form.user_id"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                        <option value="" disabled selected>Select a user</option>
                        <option 
                            v-for="user in users" 
                            :key="user.id" 
                            :value="user.id"
                        >
                            {{ user.name }}
                        </option>
                    </select>
                </div>
        
                <div class="mt-6 flex justify-between">
                    <button
                    type="submit"
                    class="rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700"
                    >
                    Create Task
                    </button>
                    <button
                    type="button"
                    class="rounded-md bg-red-600 px-4 py-2 text-white hover:bg-red-700"
                    @click="emitClose"
                    >
                    Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
