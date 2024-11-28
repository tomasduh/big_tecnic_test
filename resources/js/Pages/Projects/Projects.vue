<script setup>
import { router, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
  projects: Array,
});

const editProject = (id) => {
  router.get(route('project.edit', { id })); 
};

const deleteProject = (id) => {
  if (confirm('Are you sure you want to delete this project?')) {
    router.delete(route('project.destroy', { id })); 
  }
};
</script>

<template>
  <Head title="Projects" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Projects</h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
        <div class="mb-4">
          <a
            :href="route('dashboard')"
            class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900"
          >
            Home
          </a>
          /Projects
        </div>

        <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Projects</h2>
            <a
              :href="route('project.create')"
              class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
              Create
            </a>
          </div>

          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                  Name
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                  Start Date
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                  End Date
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                  Num Task
                </th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              <tr v-for="project in projects" :key="project.id">
                <td class="px-6 py-4 text-sm text-gray-900">{{ project.name }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ project.start_date }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ project.end_date }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ project.tasks_count }}</td>
                <td class="px-6 py-4 text-right text-sm">
                  <button
                    class="text-indigo-600 hover:text-indigo-900"
                    @click="editProject(project.id)"
                  >
                    Update
                  </button>
                  <button
                    class="ml-4 text-red-600 hover:text-red-900"
                    @click="deleteProject(project.id)"
                  >
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

