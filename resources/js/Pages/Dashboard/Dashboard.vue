<script setup>
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TaskForm from './TaskForm.vue';
import UserList from './UserList.vue';
import PositionForm from './PositionForm.vue';
import { ref } from 'vue';

const showTaskModal = ref(false);
const showPositionModal = ref(false);
const showUserModal = ref(false);

</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex flex-wrap gap-4">
                            <PrimaryButton @click="showTaskModal = true">Create Task</PrimaryButton>
                            <PrimaryButton @click="showUserModal = true" class="ml-5">List User</PrimaryButton>
                            <PrimaryButton @click="showPositionModal = true" class="ml-5">Create Position
                            </PrimaryButton>
                        </div>
                        <div>{{ showPositionModal }}</div>
                        <div v-if="showTaskModal"
                            class="fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
                            <TaskForm @close="showTaskModal = false" />
                        </div>
                        <Modal v-if="showPositionModal" @close="showPositionModal = false">
                            <PositionForm />
                        </Modal>
                        <Modal v-if="showUserModal" @close="showUserModal = false">
                            <UserList />
                        </Modal>
                    </div>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
