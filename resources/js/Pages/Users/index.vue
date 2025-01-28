<template>
    <AppLayout title="Equipos">
        <Datatable 
            title="Listado de usuarios"
            :data=users
            :columnas=columns>
        </Datatable>
    </AppLayout>
</template>

<script setup>
import Datatable from '@/Components/Customs/Datatable.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    users: {
        type: Array,
        required: true
    }
});

const columns = [
    {
        field: 'name',
        header: 'Nombre',
        filter: 'true',
    },
    {
        field: 'email',
        header: 'Correo',
    },
];

</script>