<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    username: '',
    password: ''
})

function submit() {
    form.post('login');
}
</script>

<template>
    <GuestLayout>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="username" value="Username" />
                <TextInput id="username" v-model="form.username" type="text" required autofocus />
                <InputError :message="form.errors.username" />
            </div>
            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput id="password" v-model="form.password" type="password" required
                    autocomplete="current-password" />
                <InputError :message="form.errors.password" />
            </div>
            <div class="mt-4">
                <PrimaryButton :disabled="form.processing">Log in</PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>