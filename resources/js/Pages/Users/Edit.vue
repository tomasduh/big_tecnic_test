<script setup>
import { Head, useForm, usePage} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    user: Object,
});

const user = usePage().props.user;

const form = useForm({
    id: user.id,
    name: user.name,
    email: user.email,
    role: user.role,
});
</script>

<template>
    <Head title="Edit User" />

    <AuthenticatedLayout>    
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Edit User
            </h2>
        </template>  
        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p
                            v-if="form.recentlySuccessful"
                            class="text-sm text-green-600"
                        >
                            User Updated.
                        </p>
                    </Transition>
                    <h2 class="text-lg font-bold mb-4">Edit User</h2>
                    <form @submit.prevent="form.patch(route('user.update', form.id))">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            <!-- Campo Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input
                                    type="text"
                                    id="name"
                                    v-model="form.name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input
                                    type="email"
                                    id="email"
                                    v-model="form.email"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                            </div>

                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                <select
                                    id="role"
                                    v-model="form.role"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option value="1">Admin</option>
                                    <option value="2">User</option>
                                </select>
                            </div>
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
