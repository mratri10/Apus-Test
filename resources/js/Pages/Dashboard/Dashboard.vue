<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import TaskForm from './TaskForm.vue';
import UserList from './UserList.vue';
import PositionForm from './PositionForm.vue';
import { ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const showTaskModal = ref(false);
const showPositionModal = ref(false);
const showUserModal = ref(false);

const users = ref(usePage().props.users);
// const usersByPosition = ref(usePage().props.usersByPosition);
const positions = ref(usePage().props.positions);
const tasks = ref(usePage().props.tasks);

const updateTodoForm = useForm({
    todo: '',
});
const todoSelect = ref(null)

function deleteTodo(uuid) {
    if (confirm('Apakah Kamu Yakin Delete?')) {
        router.delete(`/tasks/${uuid}`, {
            onSuccess: () => {
                tasks.value = [...usePage().props.tasks];
                alert("Berhasil Dihapus")
            }
        })
    } else {
        console.log("No")
    }
}

function submitUpdate() {
    updateTodoForm.put(`/tasks/${todoSelect.value.uuid}`, {
        onSuccess: () => {
            tasks.value = [...usePage().props.tasks]
            updateTodoForm.todo = '';
            todoSelect.value = null;
        }
    })
}

function updateTodo(params) {
    todoSelect.value = params
    updateTodoForm.todo = params.todo
}

watch(showUserModal, (newVal) => {
    if (newVal) {
        router.reload({
            only: ['positions'],
            preserveState: true,
        });
    }
});

watch(showTaskModal, (newVal) => {
    if (newVal) {
        router.reload({
            only: ['tasks'],
            preserveState: true,
        });
    }
});

watch(() => usePage().props.positions,
    (newVal) => {
        positions.value = newVal
    });
watch(() => usePage().props.users,
    (newVal) => {
        users.value = newVal
    });
watch(() => usePage().props.tasks,
    (newVal) => {
        tasks.value = newVal
    });


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
                        <div class="flex flex-wrap">
                            <PrimaryButton @click="showTaskModal = true">Create Task</PrimaryButton>
                            <PrimaryButton @click="showUserModal = true" class="ml-5">List User</PrimaryButton>
                            <PrimaryButton @click="showPositionModal = true" class="ml-5">Create Position
                            </PrimaryButton>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-2">
                            <div v-for="todo in tasks" :key="todo.uuid"
                                class="relative bg-white rounded-2xl shadow-md p-4 flex flex-col self-start">
                                <div class="absolute top-2 right-0 flex gap-2 z-50 flex-col bg-slate-100 rounded-md">
                                    <button @click="updateTodo(todo)" class="text-blue-500 hover:text-blue-700 px-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.232 5.232l3.536 3.536M9 13l6-6 3.536 3.536-6 6H9v-3.536zM4 20h16" />
                                        </svg>
                                    </button>
                                    <button @click="deleteTodo(todo.uuid)" class="text-red-500 hover:text-red-700 px-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="w-50 w-full">
                                    <p class="text-xs text-gray-400 truncate w-48">{{ todo.uuid }}</p>
                                    <h3 class="text-lg font-semibold text-gray-800 mt-1">{{ todo.todo }}</h3>
                                    <div class="flex justify-between items-center mt-4 text-sm text-gray-500">
                                        <span>{{ todo.name }}</span>
                                        <div class=" w-20">
                                            {{ todo.created_at }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div v-if="showTaskModal"
                            class="fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
                            <TaskForm @close="showTaskModal = false" :users="users" :positions="positions" />
                        </div>
                        <div v-if="showPositionModal"
                            class="fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
                            <PositionForm @close="showPositionModal = false" :positions="positions" />
                        </div>
                        <div v-if="showUserModal"
                            class="fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
                            <UserList @close="showUserModal = false" :users="users" :positions="positions" />
                        </div>
                        <div v-if="todoSelect != null && todoSelect != ''"
                            class="fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
                            <div class="bg-white w-2/3 rounded-lg shadow-lg overflow-auto p-6 relative">
                                <div class="h-2/3">
                                    <div class="flex justify-between mb-3">
                                        <p>{{ todoSelect.name }}</p>
                                        <button type="button" @click="todoSelect = ''">Tutup Form</button>
                                    </div>
                                    <form @submit.prevent="submitUpdate">
                                        <div>
                                            <InputLabel for="postion" value="Position" />
                                            <TextInput id="todo" v-model="updateTodoForm.todo" type="text" required
                                                class="w-full mb-4" />
                                            <InputError :message="updateTodoForm.errors.todo" />
                                        </div>
                                        <div class="flex flex-row">
                                            <PrimaryButton class="flex justify-center"
                                                :disable="updateTodoForm.processing">
                                                {{ "Update Task" }}</PrimaryButton>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
