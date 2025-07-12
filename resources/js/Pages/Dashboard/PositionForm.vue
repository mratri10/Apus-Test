<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
const emit = defineEmits(['close']);
const form = useForm({
    name: '',
    uuid: ''
});
const positions = ref([...usePage().props.positions])
function submit() {
    if (form.uuid == null || form.uuid == '') {
        form.post('/positions', {
            onSuccess: () => {
                positions.value = [...usePage().props.positions];
                form.name = ""
            }
        })
    } else {
        form.put(`/positions/${form.uuid}`, {
            onSuccess: () => {
                positions.value = [...usePage().props.positions];
                form.name = "";
                form.uuid = null
            }
        })
    }
}
function onClose() {
    emit('close')
}

function onDelete(uuid) {
    if (confirm('Apakah Kamu Yakin Delete?')) {
        router.delete(`/positions/${uuid}`, {
            onSuccess: () => {
                positions.value = [...usePage().props.positions];
                alert("Berhasil Dihapus")
            }
        })
    } else {
        console.log("No")
    }
}
function onEdit(position) {
    form.name = position.name;
    form.uuid = position.uuid;
}
function onClear() {
    form.name = "";
    form.uuid = null;
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
                    <InputLabel for="postion" value="Position" />
                    <TextInput id="name" v-model="form.name" type="text" required class="w-full mb-4"
                        placeholder="Masukan Nama Posisi" />
                    <InputError :message="form.errors.name" />
                </div>
                <div class="flex flex-row">
                    <PrimaryButton class="flex justify-center" :disable="form.processing">
                        {{ form.uuid ? "Update Position" : "Add Position" }}</PrimaryButton>
                    <DangerButton v-if="form.name != ''" type="button" @click="onClear" class="ml-4 flex justify-center"
                        :disable="form.processing">
                        Clear</DangerButton>
                </div>
            </form>
            <div v-for="position of positions" :key="position.uuid"
                class="p-2 border rounded-none w-full flex justify-between mt-1">
                <span>{{ position.name }}</span>
                <div class=" flex">
                    <button @click="onEdit(position)" class="text-blue-500 hover:text-blue-700 transition px-1"
                        title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.232 5.232l3.536 3.536M9 13l6-6 3.536 3.536-6 6H9v-3.536zM4 20h16" />
                        </svg>
                    </button>
                    <button @click="onDelete(position.uuid)" class="text-red-500 hover:text-red-700 transition px-1"
                        title="Delete">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M6 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-3H5a1 1 0 000 2h.293l.853 9.192A2 2 0 008.138 18h3.724a2 2 0 001.992-1.808L14.707 7H15a1 1 0 100-2zM7 7l.75 8h4.5l.75-8H7z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>