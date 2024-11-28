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
        <div class="mb-4">
          <a
            :href="route('projects')"
            class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900"
          >
            Projects
          </a>
          /Create
        </div>

        <div class="bg-white p-6 shadow sm:rounded-lg">
          <form @submit.prevent="form.post(route('project.store'))">
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
                Create Project
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
