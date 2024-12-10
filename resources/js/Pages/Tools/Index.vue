<template>
    <AppLayout title="Equipos">
        <Datatable :add :data=tools :columnas=columns :actions title="Listado de equipos"></Datatable>
    </AppLayout>
    <Modal v-model="visible" title="Añadir Equipo" close-on-escape>
        <Input label="Nombre" v-model="form.name" placeholder="Escriba el nombre del Equipo"
            :error-message="form.errors.name"></Input>
        <Input label="Cantidad" v-model="form.cant" placeholder="Escriba la cantidad de estos equipos"
            type="number"></Input>
        <Input label="Tipo" v-model="form.type" placeholder="Escriba el tipo de equipo"></Input>
        <Input label="Estado" v-model="form.status" placeholder="Escriba el estado del equipo"></Input>
        <Input label="Descripción" type="textarea" v-model="form.description"
            placeholder="Escriba una descripción"></Input>
        <template #footer>
            <div class="flex gap-x-2">
                <Button label="Cancelar" severity="danger" icon="fa-solid fa-xmark"></Button>
                <Button label="Guardar" severity="success" icon="fa-solid fa-save" @click="save()"></Button>
            </div>
        </template>
    </Modal>
</template>

<script setup>
import Datatable from '@/Components/Customs/Datatable.vue';
import Input from '@/Components/Customs/Input.vue';
import Modal from '@/Components/Customs/Modal.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const visible = ref(false);

const props = defineProps({
    tools: {
        type: Array,
        required: true
    }
});

const actions = [
    {
        action: (data) => {
            visible.value = true
            form.id = data.id,
                form.name = data.name,
                form.cant = data.cant,
                form.description = data.description,
                form.type = data.type,
                form.status = data.status,
                form.file = data.file

        },
        severity: 'info',
        icon: 'fa-solid fa-pencil text-sm',
    },
    {
        action: (data) => {
            form.delete(route('tools.destroy', data.id), {
                onSuccess: () => {
                    form.reset();
                }
            });
        },
        severity: 'danger',
        icon: 'fa-solid fa-trash text-sm',
    }
]

const form = useForm({
    id: '',
    name: '',
    cant: '',
    description: '',
    type: '',
    status: '',
    file: '',
});


const add = {
    action: () => {
        visible.value = true;
    }
}
const columns = [
    {
        field: 'name',
        header: 'Nombre',
        filter: true
    },
    {
        field: 'cant',
        header: 'Cantidad',
        type: 'number',
        filter: true
    },
    {
        field: 'description',
        header: 'Descripción',
        filter: true
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


const save = () => {

    if (form.id) {
        form.put(route('tools.update', form.id), {
            onSuccess: () => {
                visible.value = false;
                form.reset();
            }
        });
        return;
    }
    form.post(route('tools.store'), {
        onSuccess: () => {
            visible.value = false;
        }
    });
}
</script>