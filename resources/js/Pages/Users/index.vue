<template>
    <AppLayout title="Usuarios">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Gestión de Usuarios</h1>
            </div>

            <!-- Tabla de usuarios -->
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    <li v-for="user in users" :key="user.id" class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <img
                                    class="h-12 w-12 rounded-full"
                                    :src="user.profile_photo_url"
                                    :alt="user.name"
                                />
                                <div class="flex-1">
                                    <h3 class="text-lg font-medium text-gray-900">{{ user.name }}</h3>
                                    <p class="text-sm text-gray-500">{{ user.email }}</p>
                                    <div class="mt-1 flex flex-wrap gap-1">
                                        <span
                                            v-for="role in user.roles"
                                            :key="role.id"
                                            class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full"
                                        >
                                            {{ role.name }}
                                        </span>
                                        <span
                                            v-if="!user.roles || user.roles.length === 0"
                                            class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full"
                                        >
                                            Sin roles asignados
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <Link
                                    :href="route('users.manage-roles', user.id)"
                                    class="text-indigo-600 hover:text-indigo-900 text-sm font-medium"
                                >
                                    Gestionar Roles
                                </Link>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    users: {
        type: Array,
        required: true
    },
    roles: {
        type: Array,
        default: () => []
    }
});
</script>