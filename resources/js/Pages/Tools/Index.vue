<template>
    <AppLayout title="Equipos">
        <Datatable :data=[] :columnas=columns title="Listado de equipos"></Datatable>

    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Datatable from '@/Components/Customs/Datatable.vue';

const columns=[
    {
        field:'name', 
        header: 'Nombre',
    },
    {
        field:'cant', 
        header: 'Cantidad',
    },
    {
        field:'description', 
        header: 'Descripción',
    },
    {
        field:'type', 
        header: 'Tipo',
    },
    {
        field:'status', 
        header: 'Estado',
    },
    {
        field:'file', 
        header: 'Foto',
    },
]
</script>