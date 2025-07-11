<script setup lang="ts">
import PrimaryButton from '@/Components/PrimaryButton.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { router, usePage } from '@inertiajs/vue3';
import { reactive } from 'vue';

interface Users {
    uuid: string;
    name: string;
}
interface Positions {
    uuid: string;
    name: string;
}

const users = usePage().props.users as Users[];
const positions = usePage().props.positions as Positions[];

const positionsForm = reactive({})
function submit(userId) {
    router.post('/user-positions', {
        user_id: userId,
        position_id: positionsForm[userId]
    })
}
</script>

<template>
    <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
        <GuestLayout>
            <div v-for="user in users" :key="user.uuid" class="mb-4 border p-4 rounded">
                <div>{{ user.name }}</div>
                <form @submit.prevent="submit(user.uuid)" class="mt-2 block w-full">
                    <option value="">Select Position</option>
                    <option v-for="position in positions" :key="position.uuid" :value="position.uuid">
                        {{ position.name }}
                    </option>
                    <PrimaryButton class="mt-2">Assign Position</PrimaryButton>
                </form>
            </div>
        </GuestLayout>
    </div>
</template>