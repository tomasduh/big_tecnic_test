<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue'; 

const errors = usePage().props.errors;
const form = useForm({
    name: '',
    email: '',
    role: '',
    password: '',
    password_confirmation: '',
});

const passwordMismatch = ref(false);

const validatePasswords = () => {
  passwordMismatch.value = form.password !== form.password_confirmation;
};
</script>

<template>
  <Head title="Create User" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Create User
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
        <!-- Menú para volver a la lista de usuarios -->
        <div class="mb-4">
          <a
            :href="route('users')"
            class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900"
          >
            Users
          </a>
          /Create
        </div>

        <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
          <h2 class="text-lg font-bold mb-4">Create User</h2>
          <form @submit.prevent="form.post(route('user.store'))">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input
                  type="text"
                  id="name"
                  v-model="form.name"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  required
                />
                <div v-if="errors.name" class="text-red-600 text-sm mt-1">{{ errors.name }}</div>
              </div>

              <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                  type="email"
                  id="email"
                  v-model="form.email"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  required
                />
                <div v-if="errors.email" class="text-red-600 text-sm mt-1">{{ errors.email }}</div>
              </div>

              <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select
                  id="role"
                  v-model="form.role"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  required
                >
                  <option value="1">Admin</option>
                  <option value="2">User</option>
                </select>
              </div>

              <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input
                  type="password"
                  id="password"
                  v-model="form.password"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  @input="validatePasswords"
                  required
                />
                <div v-if="errors.password" class="text-red-600 text-sm mt-1">{{ errors.password }}</div>
              </div>

              <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input
                  type="password"
                  id="password_confirmation"
                  v-model="form.password_confirmation"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  :class="{'border-red-800': passwordMismatch}"
                  @input="validatePasswords"
                  required
                />
                <p v-if="passwordMismatch" class="text-red-800 text-xs mt-1">
                  Passwords do not match.
                </p>
              </div>
            </div>

            <div class="mt-6">
              <button
                type="submit"
                class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                :disabled="form.processing || passwordMismatch"
              >
                Create User
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
