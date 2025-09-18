<template>
    <div class="text-xl h-ful flex items-center font-extrabold leading-6 mb-4 capitalize text-primary">
        Gestión de Firma
    </div>
    <div v-if="!user.signature">
        <p class="mb-4">Aun no tienes firma registrada!</p>
        <div class="flex gap-3">
            <Button label="Subir firma" icon="fa-solid fa-upload" @click="$emit('openUpload')"></Button>
            <Button label="Dibujar firma" icon="fa-solid fa-pen" @click="$emit('openDraw')"></Button>
        </div>
    </div>
    <div v-else>
        <img :src="userSignature" alt="Firma" class="w-2/5 my-4 border rounded-sm">
        <div class="flex gap-3">
            <Button class="mr-3" label="Cambiar firma" icon="fa-solid fa-upload" @click="$emit('changeImage')"></Button>
            <Button label="Dibujar una firma nueva" @click="$emit('changeDraw')"></Button>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    user: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['openUpload', 'openDraw', 'changeImage', 'changeDraw']);

const userSignature = computed(() => 
    props.user.signature ? `/storage/${props.user.signature}` : null
);
</script>
