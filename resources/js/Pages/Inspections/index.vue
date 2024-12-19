<template>
    <AppLayout title="Inspecciones">
        <Datatable :add :data=inspections :columnas=columns :actions title="Inspecciones"></Datatable>
    </AppLayout>
    <Modal v-model="visible" title="Añadir inspección" close-on-escape>
        <Input label="Solicitante" v-model="form.solicitante"></Input>
        <Input label="Gerencia" v-model="form.gerencia" type="dropdown" :options="[
                'GEBOC',
                'GECON',
                'GEMAM',
                'GEDIN',
            ]"></Input>
        <Input label="Fecha" type="date" v-model="form.fecha" min-date="new Date()"></Input>
        <Input label="Tipo" v-model="form.tipo" type="text" :options="[
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
            ]"></Input>
        <Input label="Grafo" v-model="form.grafo" placeholder="xxxxxx_xx"></Input>
        <Input label="Supervisor" v-model="form.supervisor" placeholder="Escriba aquí el nombre del supervisor"></Input>
        <Input label="Prioridad" v-model="form.prioridad" type="number" :options="[
                'Alta',
                'Media',
                'Baja'
            ]" ></Input>
        <Input label="Descripción" type="textarea" v-model="form.descripcion"
            placeholder="Escriba una descripción"></Input>
        <template #footer>
            <div class="flex gap-x-2">
                <Button label="Cancelar" severity="danger" icon="fa-solid fa-xmark" @click="visible=false"></Button>
                <Button label="Guardar" severity="success" icon="fa-solid fa-save" @click="save()" :loading="form.processing"></Button>
            </div>
        </template>
    </Modal>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import Datatable from '@/Components/Customs/Datatable.vue';
import Input from '@/Components/Customs/Input.vue';
import Modal from '@/Components/Customs/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const visible = ref(false);

const columns = [
    {
        field: 'solicitante',
        header: 'Solicitante',
        filter: 'true'
    },
    {
        field: 'gerencia',
        header: 'Gerencia',
        filter: 'true'
    },
    {
        field: 'fecha',
        header: 'Fecha',
        filter: 'true'
    },
    {
        field: 'tipo',
        header: 'Tipo',
    },
    {
        field: 'grafo',
        header: 'Grafo',
        filter: 'true'
    },
    {
        field: 'supervisor',
        header: 'Supervisor',
        filter: 'true'
    },
    {
        field: 'prioridad',
        header: 'Prioridad',
        filter: 'true'
    },
    {
        field: 'descripcion',
        header: 'Descripción',
    }

]

const props = defineProps({
    inspections: {
        type: Array,
        Required: true,
    }
});

const form = useForm ({
    id : '',
    solicitante : '',
    gerencia : '',
    fecha : '',
    tipo : '',
    grafo : '',
    supervisor : '',
    prioridad : '',
    descripcion:'',
});

const add = {
    action: () => {
        visible.value = true;
        form.reset()
    }
}

const actions = [
    {
        action: (data) => {
            visible.value = true

            form.id = data.id,
            form.gerencia = data.gerencia,
            form.fecha = data.fecha,
            form.tipo = data.tipo,
            form.grafo = data.grafo,
            form.supervisor = data.supervisor,
            form.prioridad = data.prioridad
        },
        severity: 'info',
        icon: 'fa-solid fa-pencil text-sm',
    },
    {
        action: (data) => {
            form.delete(route('inspections.destroy', data.id), {
                onSuccess: () => {
                    form.reset();
                }
            });
        },
        severity: 'danger',
        icon: 'fa-solid fa-trash text-sm',
    }
]

const save = () => {

    if (form.id) {
        form.put(route('inspections.update', form.id), {
            onSuccess: () => {
                visible.value = false;
                form.reset();
            }
        });
        return;
    }
    form.post(route('inspections.store'), {
        onSuccess: () => {
            visible.value = false;
        }
    });
}
</script>