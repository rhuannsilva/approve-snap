<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">

            <div class="flex flex-col gap-2">

                <label for="email">E-mail</label>

                <input type="text"
                    id="email"
                    class="block w-full rounded-md border-[#d0d7e7] "
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

            </div>

            <div class="flex flex-col gap-2">

                <label for="email">Senha</label>

                <input
                    id="password"
                    type="password"
                    class="block w-full rounded-md border-[#d0d7e7] "
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <span v-if="form.errors" class="mb-4 text-red-400">{{ form.errors.email }}</span>

            </div>

            <div class="flex items-center justify-between mt-4">
                <div class="flex gap-2">
                    <p>Não tem cadastro ?</p> 
                    <a href="/register" class="text-blue-500">  Cadastre-se</a>
                </div>
                <button class="ms-4 bg-gray-300 p-2 rounded-md" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Login
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
