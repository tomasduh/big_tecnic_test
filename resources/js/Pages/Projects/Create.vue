<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const errors = usePage().props.errors;
const form = useForm({
    name: '',
    description: '',
    start_date: '',
    end_date: '',
});

const submitForm = () => {
    form.post(route('projects.store')); // Aquí estamos haciendo el POST al controlador para crear el proyecto.
};
</script>

<template>
  <Head title="Create Project" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Create Project
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
        <!-- Menú para volver a la lista de proyectos -->
        <div class="mb-4">
          <a
            :href="route('projects')"
            class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900"
          >
            Projects
          </a>
          /Create
        </div>

        <!-- Formulario para crear un proyecto -->
        <div class="bg-white p-6 shadow sm:rounded-lg">
          <form @submit.prevent="submitForm">
            <!-- Nombre del Proyecto -->
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

            <!-- Descripción del Proyecto -->
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

            <!-- Fechas en dos columnas -->
            <div class="grid grid-cols-2 gap-6 mb-4">
              <!-- Fecha de inicio -->
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

              <!-- Fecha de finalización -->
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

            <!-- Botón para enviar el formulario -->
            <div class="mt-6">
              <button
                type="submit"
                class="w-full inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-white font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
              >
                Create Project
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
