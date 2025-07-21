<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { router, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const form = useForm({
    todo: '',
    userId: "",
    positionId: ""
});

const props = defineProps({
    users: Array,
    positions: Array,
    disabled: Boolean
});

const localUsers = ref([...props.users]);
const positions = props.positions

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
                <div class="mt-2">
                    <InputLabel for="user_id" value="User" />
                    <select id="user_id" v-model="form.userId" class="mt-1 block w-full border rounded p-2">
                        <option disabled value="">-- Pilih User --</option>
                        <option v-for="user in localUsers" :key="user.uuid" :value="user.uuid">
                            {{ user.name }} - {{ user.position ?? 'Tidak Ada Posisi' }}
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
                    <h2 v-if="form.processing">
                        Processing...
                    </h2>
                    <PrimaryButton v-else :disable="form.processing">
                        Create Task
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>