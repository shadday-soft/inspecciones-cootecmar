<template>
    <AppLayout>
        <Datatable :add :actions :data="projects" :columnas="columns" title="Listado de Proyectos" >
        </Datatable>
    </AppLayout>
    <Modal v-model="visible" title="Añadir Proyecto" close-on-escape>
        <Input 
            label="Nombre"
            v-model="form.name"
            placeholder="Escriba el nombre del Proyecto"
            :error-message="form.errors.name"
        ></Input>
        <Input 
            label="Gerencia"
            v-model="form.gerencia"
            type="dropdown"
            :options="['GEBOC', 'GECON', 'GEMAM', 'GEDIN']"
            :errorMessage="form.errors.gerencia"
        ></Input>
        <Input 
            label="Code-SAP"
            v-model="form.code_sap"
            placeholder="Escriba el Code-SAP del Proyecto"
            :error-message="form.errors.code_sap"
        ></Input>
        <Input 
            label="Fecha"
            v-model="form.date"
            placeholder="Escriba la fecha del Proyecto"
            type="date"
            :error-message="form.errors.date"
        ></Input>
        <template #footer>
            <div class="flex gap-x-2">
                <Button 
                    label="Cancelar"
                    severity="danger"
                    icon="fa-solid fa-xmark"
                    @click="visible = false"
                ></Button>
                <Button 
                    label="Guardar"
                    severity="success"
                    icon="fa-solid fa-save"
                    @click="save()"
                    :loading="form.processing"
                ></Button>
            </div>
        </template>
    </Modal>
</template>

<script setup>
import Datatable from '@/Components/Customs/Datatable.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Modal from '@/Components/Customs/Modal.vue';
import Input from '@/Components/Customs/Input.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Swal from 'sweetalert2';

const props = defineProps({
    projects: {
        type: Array,
        required: true
    },
});

const visible = ref(false);

const columns = [
    {
        field: "name",
        header: "Nombre",
        filter: true,
    },
    {
        field: "gerencia",
        header: "Gerencia",
        filter: true,
    },
    {
        field: "code_sap",
        header: "Code-SAP",
        filter: true,
    },
    {
        field: "date",
        header: "Fecha",
    } 
];

const form = useForm({
    id: "",
    name: "",
    gerencia: "",
    code_sap: "",
    date: "",
});

const add = {
    action: () => {
        visible.value = true;
    },
};

const actions = [
    {
        action: (data) => {
            visible.value = true;
            (form.id = data.id),
            (form.name = data.name),
            (form.gerencia = data.gerencia),
            (form.code_sap = data.code_sap),
            (form.date = data.date);
        },
        severity: "info",
        icon: "fa-solid fa-pencil text-sm",
    },
    {
        action: (data) => {
            let timerInterval;
            Swal.fire({
                title: "Quieres eliminar el registro?",
                text: "No podrás recuperar esta información!",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: "Cancelar",
                confirmButtonText: "Sí, eliminar"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Eliminado!',
                        text: 'El registro ha sido eliminado.',
                        icon: 'success',
                        timer: 2500,
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    });
                    form.delete(route('projects.destroy', data.id), {
                        onSuccess: () => {
                            form.reset();
                        },
                    });
                };
            });
        },
        severity: "danger",
        icon: "fa-solid fa-trash text-sm",
    },
];

const save = () => {
    if (form.id) {
        form.put(route("projects.update", form.id), {
            onSuccess: () => {
                visible.value = false;
                form.reset();
                let timerInterval;
                Swal.fire({
                    title: 'Actualizado!',
                    text: 'El registro fue actualizado con exito.',
                    icon: 'success',
                    timer: 2500,
                    willClose: () => {
                        clearInterval(timerInterval)
                    },
                });
            },
        });
        return;
    }
    form.post(route("projects.store"), {
        onSuccess: () => {
            visible.value = false;
            form.reset();
            let timerInterval;
            Swal.fire({
                title: 'Guardado!',
                text: 'El registro fue guardado con exito.',
                icon: 'success',
                timer: 2500,
                willClose: () => {
                    clearInterval(timerInterval)
                },
            });
        },
    });
};
</script>