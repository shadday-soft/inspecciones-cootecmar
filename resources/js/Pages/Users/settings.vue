<template>
    <AppLayout title="Configuraciones del usuario">
        <Toast />
        <div class="text-xl h-ful flex items-center font-extrabold leading-6 mb-2 capitalize text-primary">
            Firma
        </div>
        <div v-if="!user.signature">
            <p class="mb-2">Aun no tienes firma registrada!</p>
            <Button label="Subir firma" icon="fa-solid fa-upload" @click="visibleUpload = true"></Button>
            <Button label="Dibujar firma" icon="fa-solid" @click="visibleDraw = true"></Button>
        </div>
        <div v-else>
            <img :src="userSignature" alt="Firma" class="w-2/5 my-4 border rounded-sm">
            <Button class="mr-3" label="Cambiar firma" icon="fa-solid fa-upload" @click="alertChangeImage"></Button>
            <Button label="Dibujar una firma nueva" @click="alertChangeDraw"></Button>
        </div>
        
        <Modal v-model="visibleUpload" title="Subir Firma" close-on-escape>
            <div class="card">
                <FileUpload name="signature" @select="handleFile" @before-upload="uploadImage" :multiple="false" :file-limit="1" accept="image/*" :maxFileSize="1000000">
                    <template #empty>
                        <span>Drag and drop files to here to upload.</span>
                    </template>
                </FileUpload>
            </div>
        </Modal>

        <Modal v-model="visibleDraw" title="Dibujar firma" @close="closeDraw" close-on-escape>
            <Signatue  />
        </Modal>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Modal from '@/Components/Customs/Modal.vue';
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import Signatue from '@/Components/Customs/Signatue.vue';
import Swal from 'sweetalert2';

const toast = useToast();

const props = defineProps({
    user: {
        type: Object,
        required: true,
    }
});

const user = props.user;
const userSignature = user.signature ? `/storage/${user.signature}` : null;

const form = useForm({
    signature: null
});

const visibleDraw = ref(false);
const closeDraw = () => {
    visibleDraw.value = false;
};

const visibleUpload = ref(false);
const file = ref(null);

const handleFile = (event) => {
    file.value = event.files[0];
};

const alertChangeImage = () => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Estás a punto de cambiar tu firma, esta acción no se puede deshacer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, cambiar firma!'
    }).then((result) => {
        if (result.isConfirmed) {
            visibleUpload.value = true;
        }
    });
};

const alertChangeDraw = () => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Estás a punto de cambiar tu firma, esta acción no se puede deshacer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, cambiar firma!'
    }).then((result) => {
        if (result.isConfirmed) {
            visibleDraw.value = true;
        }
    });
};

const uploadImage = async () => {
    const formData = new FormData();
    formData.append('signature', file.value);

    router.post(route('users.signature'), formData, {
        onSuccess: () => {
            Swal.fire('Firma actualizada', '', 'success');
            // toast.add({ severity: 'info', summary: 'Success', detail: 'File Uploaded', life: 3000 });
            visibleUpload.value = false;
            router.get(route('settings'));
        }
    });
};
</script>