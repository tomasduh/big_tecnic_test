<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const user = usePage().props.auth.user
</script>


<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 my-2">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <!-- Verifica que user exista antes de acceder a 'role' -->
                <div v-if="user && user.role === 1" class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <Link :href="route('users')" class="text-sm">
                        <div class="p-6 text-gray-900 flex flex-col items-center space-y-2">
                            <i class="fas fa-user-circle text-2xl"></i>
                            Users
                        </div>
                    </Link>
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <Link :href="route('projects')" class="text-sm">
                        <div class="p-6 text-gray-900 flex flex-col items-center space-y-2">
                            <i class="fas fa-clipboard-list text-2xl"></i>
                            Projects and Tasks
                        </div>
                    </Link>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
  props: {
    user: Object,
  },
};

</script>
