<template>
    <GuestLayout>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" />
                <TextInput id="name" v-model="form.name" type="text" required />
                <InputError :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="username" value="Username" />
                <TextInput id="username" v-model="form.username" type="text" required />
                <InputError :message="form.errors.username" />
            </div>
            <div>
                <InputLabel for="password" value="Password" />
                <TextInput id="password" v-model="form.password" type="password" required />
                <InputError :message="form.errors.password" />
            </div>
            <div>
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password" required />
                <InputError :message="form.errors.password_confirmation" />
            </div>
            <PrimaryButton :disable="form.processing">Register</PrimaryButton>
        </form>

    </GuestLayout>
</template>

<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    username: '',
    password: '',
    password_confirmation: ''
})
function submit() {
    form.post('/register')
}

</script>