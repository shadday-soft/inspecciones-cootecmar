<template>
    <AppLayout title="Equipos">
        <Datatable :add :data=[] :columnas=columns title="Listado de equipos"></Datatable>

    </AppLayout>
    <Modal v-model="visible" title="Añadir Equipo" close-on-escape>
        <Input label="Nombre" placeholder="Escriba el nombre del Equipo"></Input>
        <Input label="Cantidad" placeholder="Escriba la cantidad de estos equipos"></Input>
    </Modal>
</template>

<script setup>
import Datatable from '@/Components/Customs/Datatable.vue';
import Input from '@/Components/Customs/Input.vue';
import Modal from '@/Components/Customs/Modal.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';

const visible = ref(false);

const add = {
    action: () => {
        visible.value = true;
    }
}
const columns = [
    {
        field: 'name',
        header: 'Nombre',
    },
    {
        field: 'cant',
        header: 'Cantidad',
    },
    {
        field: 'description',
        header: 'Descripción',
    },
    {
        field: 'type',
        header: 'Tipo',
    },
    {
        field: 'status',
        header: 'Estado',
    },
    {
        field: 'file',
        header: 'Foto',
    },
]
</script>