<template>
    <div class="w-full flex flex-col  px-2 py-4 gap-y-6">
        <h3 class="text-lg font-bold text-center text-primary">Crear una solicitud de Inspección/Ensayo </h3>
        <div class="flex flex-col px-2 gap-y-4">
            <Input label="Nombre del solicitante" placeholder="Nombre del solicitante" v-model="form.name"
                :disabled="true" />
            <Input label="Gerencia" type="dropdown" :options="[
                'GEBOC',
                'GECON',
                'GEMAM',
                'GEDIN',
            ]" placeholder="" v-model="form.prioridad" />
            <Input type="date" label="Fecha de la inspección" :min-date="new Date()"></Input>
            <Input type="multiselect" :options="[
                'Líquidos penetrantes',
                'Partículas magnéticas',
                'Ultrasonido',
                'Medición de espesores',
                'Medición de flujo',
                'Medición de vibraciones',
                'Termografía',
                'Análisis químico',
                'Medición de rugosidad',
                'Prueba de presión',
                'Prueba de fugas por ultrasonido',
                'Inspección visual',
                'Control dimensional',
                'Medición de dureza'
            ]" v-model="form.type" label="Tipo de Solicitud"></Input>
            <Input label="Grafo" placeholder="xxxxxx_xx" v-model="form.grafo" />
            <Input label="Supervisor" placeholder="" v-model="form.supervisorr" />
            <Input label="Prioridad" type="dropdown" :options="[
                'Alta',
                'Media',
                'Baja'
            ]" placeholder="" v-model="form.prioridad" />
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import Input from './Customs/Input.vue';
import { useForm, usePage } from '@inertiajs/vue3';

const form = useForm({
    name: usePage().props.auth.user.name,
    type: '',
    description: '',
    date: '',
    supervisorr: '',
    prioridad: '',
    status: '',
    grafo: '',
    inspector_id: '',
    company_id: '',
    service_id: '',
    created_at: '',
    updated_at: '',
    deleted_at: ''
})
</script>