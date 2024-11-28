<script setup>
import { useForm } from '@inertiajs/vue3'; // Asegúrate de importar useForm

const emit = defineEmits();
const props = defineProps({
    task: {
        type: Object,
        required: true,
    },
    users: {
        type: Array,
        required: true,
    },
    user: {
        type: Array,
        required: true,
    },
});
const task_id = props.task.id
const user_id = props.task.user_id
const name = props.task.name
const description = props.task.description
const start_date = props.task.start_date
const end_date = props.task.end_date
const status = props.task.status

const form = useForm({
    user_id: user_id,
    name: name,
    description: description,
    start_date: start_date,
    end_date: end_date,
    status: status,
});

const emitClose = () => {
    emit('close');
};

const emitReload = () => {
    emit('reload');
};

const submitForm = () => {
    form.patch(route('task.update', task_id), {
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

                <div class="mb-4" v-if="user && user.role === 1">
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

                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select
                        id="status"
                        v-model="form.status"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                        <option 
                            value="0"
                            :selected="status == 0"
                        >
                            Pending
                        </option>
                        <option 
                            value="1"
                            :selected="status == 1"
                        >
                            In Process
                        </option>
                        <option 
                            value="2"
                            :selected="status == 2"
                        >
                            Finished
                        </option>
                    </select>
                </div>
        
                <div class="mt-6 flex justify-between">
                    <button
                    type="submit"
                    class="rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700"
                    >
                    Save Task
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
