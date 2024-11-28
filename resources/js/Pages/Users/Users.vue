<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

// Se espera que los usuarios sean pasados como una prop desde el backend
defineProps({
    users: Array, // Lista de usuarios
});
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Users
            </h2>
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
                    /Users
                </div>
                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                >
                    <!-- Tabla de usuarios -->
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                >
                                    Name
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                >
                                    Email
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                >
                                    Role
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr
                                v-for="user in users"
                                :key="user.id"
                            >
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ user.name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ user.email }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ user.role == 1 ? 'admin' : 'user' }}
                                </td>
                                <td class="px-6 py-4 text-right text-sm">
                                    <button
                                        class="text-indigo-600 hover:text-indigo-900"
                                        @click="editUser(user.id)"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        class="ml-4 text-red-600 hover:text-red-900"
                                        @click="deleteUser(user.id)"
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

<script>

const editUser = (id) => {
    router.get(route('user.edit', id));
};

const deleteUser = (id) => {
    if (confirm('Are you sure you want to delete this user?')) {
        console.log('Eliminar usuario con ID:', id);
        // Lógica para eliminar usuario
    }
};
</script>
