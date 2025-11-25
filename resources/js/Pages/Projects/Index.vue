<template>
    <AppLayout>
        <Datatable :add :actions :data="projects" :columnas="columns" title="Listado de Proyectos" >
        </Datatable>
    </AppLayout>
    <ProjectForm v-model="visible" :form="form" />
</template>

<script setup>
import Datatable from '@/Components/Customs/Datatable.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ProjectForm from './ProjectForm.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

// Importar piezas extraídas
import initialForm from './formData';
import columns from './columns';
import createActions from './actions';

const props = defineProps({
    projects: {
        type: Array,
        required: true
    },
});

const visible = ref(false);

const form = useForm(initialForm);

const add = {
    action: () => {
        visible.value = true;
    },
};

// Crear las acciones pasando referencias necesarias
const actions = createActions({ form, visible });
</script>