<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const emit = defineEmits(['close', 'users', 'positions']);
const props = defineProps({
    users: Array,
    positions: Array,
});
const localUsers = ref([...props.users]);
const positions = props.positions

const userName = ref('');
const userId = ref('');
const process = ref(false);

const selectUser = (userData) => {
    userName.value = userData.name
    userId.value = userData.uuid
}
const postPositionUser = (id, positionId) => {
    process.value = true
    router.post('/user-positions', {
        userId: id,
        positionId: positionId
    }, {
        onSuccess: () => {
            setTimeout(() => {
                router.reload({
                    only: ['users'],
                    preserveState: true,
                    preserveScroll: true,
                });
            }, 100);
            userName.value = "";
            process.value = false
        }
    })
}

watch(
    () => props.users,
    (newVal) => {
        localUsers.value = [...newVal];
    }
);
watch(() => props.users, (newVal) => {
    localUsers.value = [...newVal];
});
</script>

<template>
    <div class="bg-white w-2/3 rounded-lg shadow-lg overflow-auto p-6 relative">
        <div class="h-2/3">
            <div class="flex justify-end">
                <button type="button" @click="emit('close')">Tutup Form</button>
            </div>
            <div v-for="user in localUsers" :key="user.uuid"
                class="mb-4 border p-2 rounded flex justify-between w-full">
                <div>{{ user.name }} - {{ user.position }}</div>
                <PrimaryButton @click="selectUser(user)" v-if="user.position == null">Pilih Posisi</PrimaryButton>
                <PrimaryButton @click="selectUser(user)" v-else>Ubah Posisi</PrimaryButton>
            </div>

        </div>
        <div v-if="userName" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white w-1/3 rounded-lg shadow-lg overflow-auto p-6 relative">
                <div>
                    <div class="flex justify-between">
                        <div>{{ userName }}</div>
                        <button type="button" @click="userName = ''">Tutup Form</button>
                    </div>
                    <div class="pt-4">
                        <span>Pilih Posisi Karyawan</span>
                    </div>
                    <button @click="postPositionUser(userId, position.uuid)" v-for="position in positions"
                        :key="position.uuid" class="p-2 border rounded w-full flex justify-start items-center mb-1">
                        <span>{{ position.name }}</span>
                    </button>
                </div>
                <div v-if="process" class="mt-2">
                    .... Mohon Tunggu
                </div>
            </div>
        </div>
    </div>
</template>