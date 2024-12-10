<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Input from '@/Components/Customs/Input.vue';
import { Button } from 'primevue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>

    <Head title="Log in" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <Input type="email" label="Email" v-model="form.email" :error-message="form.errors.emaial" />

            </div>

            <div class="mt-4">
                <Input type="password" label="Contraseña" v-model="form.password"
                    :error-message="form.errors.password"></Input>
            </div>

            <div class="flex flex-row justify-between mt-4">
                <label class="flex items-center">
                    <Input type="checkbox"></Input>
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
                <!-- <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm font-medium text-indigo-500 hover:text-indigo-500 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Forgot your password?
                </Link> -->
            </div>

            <div class="flex items-center justify-center mt-10">
                <Button :loading="form.processing" type="submit">
                    Log in
                </Button>
            </div>
        </form> 
    </AuthenticationCard>
</template>
