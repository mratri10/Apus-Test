<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface User {
    uuid: string;
    name: string
}

const form = useForm({
    todo: '',
    userId: 0
})
const users = computed(() => usePage().props.users as User[]);
const emit = defineEmits(['close']);
function submit() {
    form.post('/tasks', {
        onSuccess: () => {
            emit('close')
        }
    })
}

function onClose() {
    emit('close')
}
</script>

<template>
    <div class="bg-white w-2/3 rounded-lg shadow-lg overflow-auto p-6 relative">
        <div class="h-2/3">
            <div class="flex justify-end">
                <button type="button" @click="onClose">Tutup Form</button>
            </div>
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="user_id" value="User" />
                    <select id="user_id" v-model="form.userId" class="mt-1 block w-full">
                        <option v-for="user in users" :key="user.uuid" :value="user.uuid">
                            {{ user.name }}
                        </option>
                    </select>
                    <InputError :message="form.errors.userId" />
                </div>
                <div class="mt-4">
                    <InputLabel for="todo" value="Tugas" />
                    <TextInput id="todo" v-model="form.todo" type="text" required class="w-full mb-4"
                        placeholder="Masukan Tugas" />
                    <InputError :message="form.errors.todo" />
                </div>
                <div class="flex justify-center">
                    <PrimaryButton :disabled="form.progress">Create Task</PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>