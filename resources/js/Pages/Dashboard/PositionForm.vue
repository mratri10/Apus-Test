<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { useForm } from '@inertiajs/vue3';
const form = useForm({
    name: '',
    position: '',
    user_id: 0
})
function submit() {
    form.post('/positions')
}
</script>

<template>
    <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
        <GuestLayout>
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="postion" value="Position" />
                    <TextInput id="position" v-model="form.position" type="text" required />
                    <InputError :message="form.errors.name" />
                </div>
                <PrimaryButton :disable="form.processing">Add Position</PrimaryButton>
            </form>
        </GuestLayout>
    </div>
</template>