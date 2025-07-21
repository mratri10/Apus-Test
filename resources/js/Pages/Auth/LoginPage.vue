<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { useForm } from '@inertiajs/vue3';

const loginForm = useForm({
    username: '',
    password: ''
})

function login() {
    loginForm.post('login');
}

const registerForm = useForm({
    name: '',
    username: '',
    password: '',
    password_confirmation: ''
})
function register() {
    registerForm.post('/register')
}
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl flex flex-col md:flex-row overflow-hidden">

            <!-- Login Form -->
            <div class="w-full md:w-1/2 p-8">
                <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
                <form @submit.prevent="login">
                    <div class="mb-4">
                        <InputLabel for="login_username" value="Username" />
                        <TextInput id="login_username" v-model="loginForm.username" type="text" required
                            class="w-full" />
                        <InputError :message="loginForm.errors.username" />
                    </div>
                    <div class="mb-4">
                        <InputLabel for="login_password" value="Password" />
                        <TextInput id="login_password" v-model="loginForm.password" type="password" required
                            class="w-full" />
                        <InputError :message="loginForm.errors.password" />
                    </div>
                    <PrimaryButton :disabled="loginForm.processing" class="w-full">Log in</PrimaryButton>
                </form>
            </div>

            <!-- Register Form -->
            <div class="w-full md:w-1/2 bg-gray-50 p-8">
                <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
                <form @submit.prevent="register">
                    <div class="mb-4">
                        <InputLabel for="name" value="Name" />
                        <TextInput id="name" v-model="registerForm.name" type="text" required class="w-full" />
                        <InputError :message="registerForm.errors.name" />
                    </div>
                    <div class="mb-4">
                        <InputLabel for="username" value="Username" />
                        <TextInput id="username" v-model="registerForm.username" type="text" required class="w-full" />
                        <InputError :message="registerForm.errors.username" />
                    </div>
                    <div class="mb-4">
                        <InputLabel for="password" value="Password" />
                        <TextInput id="password" v-model="registerForm.password" type="password" required
                            class="w-full" />
                        <InputError :message="registerForm.errors.password" />
                    </div>
                    <div class="mb-4">
                        <InputLabel for="password_confirmation" value="Confirm Password" />
                        <TextInput id="password_confirmation" v-model="registerForm.password_confirmation"
                            type="password" required class="w-full" />
                        <InputError :message="registerForm.errors.password_confirmation" />
                    </div>
                    <PrimaryButton :disabled="registerForm.processing" class="w-full">Register1</PrimaryButton>
                </form>
            </div>

        </div>
    </div>
</template>
