<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">

            <div class="flex flex-col gap-2">

                <label for="name">Nome</label>

                <input
                    id="name"
                    type="text"
                    class="block w-full rounded-md border-[#d0d7e7]"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <span class="mb-4 text-red-400">{{ form.errors.name }}</span>

            </div>

            <div class="flex flex-col gap-2">

                <label for="email">E-mail</label>

                <input
                    id="email"
                    type="email"
                    class="block w-full rounded-md border-[#d0d7e7] "
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <span class="mb-4 text-red-400">{{ form.errors.email }}</span>

            </div>

            <div class="flex flex-col gap-2">

                <label for="email">Senha</label>

                <input
                    id="password"
                    type="password"
                    class="block w-full rounded-md border-[#d0d7e7] "
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <span class="mb-4 text-red-400">{{ form.errors.password }}</span>

            </div>

            <div class="flex flex-col gap-2">

                <label for="email">Confirme a senha</label>

                <input
                    id="password_confirmation"
                    type="password"
                    class="block w-full rounded-md border-[#d0d7e7] "
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <span class="mb-4 text-red-400">{{ form.errors.password_confirmation }}</span>

            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-blue-500 text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    Já está cadastrado?
                </Link>

                <button class="ms-4 bg-gray-300 p-2 rounded-md">
                    Register
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
