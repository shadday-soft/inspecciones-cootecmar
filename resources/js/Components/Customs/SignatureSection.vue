<template>
    <div class="border-t-2 pt-6 mt-6">
        <h3 class="text-xl font-bold mb-4 text-primary">FIRMAS</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Elaborado Por -->
            <div class="border-2 border-gray-300 rounded-lg p-4">
                <h4 class="font-bold mb-3">ELABORADO POR (Done by):</h4>
                <div class="mb-3">
                    <label class="font-semibold">Nombre:</label>
                    <input 
                        type="text" 
                        v-model="localElaboradoPorNombre"
                        @input="emitElaboradoPor"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" 
                    />
                </div>
                <div class="mb-3">
                    <label class="font-semibold">Cargo:</label>
                    <input 
                        type="text" 
                        v-model="localElaboradoPorCargo"
                        @input="emitElaboradoPor"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" 
                    />
                </div>
                <div>
                    <label class="font-semibold block mb-2">Firma:</label>
                    <SignatureCanvas @signature-saved="handleElaboradoPorSignature" />
                    <div v-if="localElaboradoPorFirma" class="mt-2">
                        <p class="text-success font-semibold mb-1">✓ Firma capturada</p>
                        <img :src="localElaboradoPorFirma" alt="Firma" class="border rounded-lg max-w-full" style="max-height: 100px;" />
                    </div>
                </div>
            </div>

            <!-- Revisado y Autorizado Por -->
            <div class="border-2 border-gray-300 rounded-lg p-4">
                <h4 class="font-bold mb-3">REVISADO Y AUTORIZADO POR (Authorized by):</h4>
                <div class="mb-3">
                    <label class="font-semibold">Nombre:</label>
                    <input 
                        type="text" 
                        v-model="localRevisadoPorNombre"
                        @input="emitRevisadoPor"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" 
                    />
                </div>
                <div class="mb-3">
                    <label class="font-semibold">Cargo:</label>
                    <input 
                        type="text" 
                        v-model="localRevisadoPorCargo"
                        @input="emitRevisadoPor"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" 
                    />
                </div>
                <div>
                    <label class="font-semibold block mb-2">Firma:</label>
                    <SignatureCanvas @signature-saved="handleRevisadoPorSignature" />
                    <div v-if="localRevisadoPorFirma" class="mt-2">
                        <p class="text-success font-semibold mb-1">✓ Firma capturada</p>
                        <img :src="localRevisadoPorFirma" alt="Firma" class="border rounded-lg max-w-full" style="max-height: 100px;" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import SignatureCanvas from '@/Components/Customs/SignatureCanvas.vue';

const props = defineProps({
    elaboradoPorNombre: {
        type: String,
        default: ''
    },
    elaboradoPorCargo: {
        type: String,
        default: ''
    },
    elaboradoPorFirma: {
        type: String,
        default: null
    },
    revisadoPorNombre: {
        type: String,
        default: ''
    },
    revisadoPorCargo: {
        type: String,
        default: ''
    },
    revisadoPorFirma: {
        type: String,
        default: null
    }
});

const emit = defineEmits([
    'update:elaboradoPorNombre',
    'update:elaboradoPorCargo',
    'update:elaboradoPorFirma',
    'update:revisadoPorNombre',
    'update:revisadoPorCargo',
    'update:revisadoPorFirma'
]);

const localElaboradoPorNombre = ref(props.elaboradoPorNombre);
const localElaboradoPorCargo = ref(props.elaboradoPorCargo);
const localElaboradoPorFirma = ref(props.elaboradoPorFirma);
const localRevisadoPorNombre = ref(props.revisadoPorNombre);
const localRevisadoPorCargo = ref(props.revisadoPorCargo);
const localRevisadoPorFirma = ref(props.revisadoPorFirma);

// Watch para sincronizar con props externos
watch(() => props.elaboradoPorNombre, (val) => localElaboradoPorNombre.value = val);
watch(() => props.elaboradoPorCargo, (val) => localElaboradoPorCargo.value = val);
watch(() => props.elaboradoPorFirma, (val) => localElaboradoPorFirma.value = val);
watch(() => props.revisadoPorNombre, (val) => localRevisadoPorNombre.value = val);
watch(() => props.revisadoPorCargo, (val) => localRevisadoPorCargo.value = val);
watch(() => props.revisadoPorFirma, (val) => localRevisadoPorFirma.value = val);

function handleElaboradoPorSignature(signatureData) {
    localElaboradoPorFirma.value = signatureData;
    emit('update:elaboradoPorFirma', signatureData);
}

function handleRevisadoPorSignature(signatureData) {
    localRevisadoPorFirma.value = signatureData;
    emit('update:revisadoPorFirma', signatureData);
}

function emitElaboradoPor() {
    emit('update:elaboradoPorNombre', localElaboradoPorNombre.value);
    emit('update:elaboradoPorCargo', localElaboradoPorCargo.value);
}

function emitRevisadoPor() {
    emit('update:revisadoPorNombre', localRevisadoPorNombre.value);
    emit('update:revisadoPorCargo', localRevisadoPorCargo.value);
}
</script>
