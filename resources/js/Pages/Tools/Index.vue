<template>
    <AppLayout title="Equipos">
        <Datatable :add :data="[]" :columnas></Datatable>
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
    { label: 'Nombre', field: 'name' },
    { label: 'Marca', field: 'brand' },
    { label: 'Modelo', field: 'model' },
    { label: 'Serie', field: 'serial' },
    { label: 'Estado', field: 'status' },
    { label: 'Acciones', field: 'actions' },

]

</script>