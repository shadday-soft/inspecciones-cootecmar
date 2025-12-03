<template>
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 rounded-lg border-2 border-blue-200 dark:border-gray-600 p-6 mt-6">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b-2 border-blue-300 dark:border-gray-600">
            <div class="bg-blue-600 dark:bg-blue-500 rounded-full p-2">
                <i class="fa-solid fa-signature text-white text-xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">FIRMAS</h3>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Elaborado Por -->
            <div class="bg-white dark:bg-gray-800 border-2 border-blue-300 dark:border-gray-600 rounded-xl p-5 shadow-md hover:shadow-lg transition-shadow">
                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-200 dark:border-gray-600">
                    <i class="fa-solid fa-user-edit text-blue-600 dark:text-blue-400"></i>
                    <h4 class="font-bold text-gray-800 dark:text-gray-100">ELABORADO POR (Done by)</h4>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-id-card text-gray-500 mr-1"></i>
                            Nombre:
                        </label>
                        <input 
                            type="text" 
                            v-model="localElaboradoPorNombre"
                            @input="emitElaboradoPor"
                            placeholder="Ingrese nombre completo"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all dark:bg-gray-700 dark:text-gray-200" 
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-briefcase text-gray-500 mr-1"></i>
                            Cargo:
                        </label>
                        <input 
                            type="text" 
                            v-model="localElaboradoPorCargo"
                            @input="emitElaboradoPor"
                            placeholder="Ingrese cargo"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all dark:bg-gray-700 dark:text-gray-200" 
                        />
                    </div>
                    <div>
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-pen-nib text-gray-500"></i>
                            Firma:
                        </label>
                        <SignatureCanvas @signature-saved="handleElaboradoPorSignature" />
                        <transition
                            enter-active-class="transition-all duration-300 ease-out"
                            enter-from-class="opacity-0 scale-95"
                            enter-to-class="opacity-100 scale-100"
                        >
                            <div v-if="localElaboradoPorFirma" class="mt-3 p-3 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg">
                                <p class="text-green-700 dark:text-green-300 font-semibold mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Firma capturada correctamente
                                </p>
                                <img :src="localElaboradoPorFirma" alt="Firma" class="border-2 border-green-300 dark:border-green-600 rounded-lg max-w-full shadow-sm" style="max-height: 100px;" />
                            </div>
                        </transition>
                    </div>
                </div>
            </div>

            <!-- Revisado y Autorizado Por -->
            <div class="bg-white dark:bg-gray-800 border-2 border-green-300 dark:border-gray-600 rounded-xl p-5 shadow-md hover:shadow-lg transition-shadow">
                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-200 dark:border-gray-600">
                    <i class="fa-solid fa-user-check text-green-600 dark:text-green-400"></i>
                    <h4 class="font-bold text-gray-800 dark:text-gray-100">REVISADO Y AUTORIZADO POR (Authorized by)</h4>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-id-card text-gray-500 mr-1"></i>
                            Nombre:
                        </label>
                        <input 
                            type="text" 
                            v-model="localRevisadoPorNombre"
                            @input="emitRevisadoPor"
                            placeholder="Ingrese nombre completo"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all dark:bg-gray-700 dark:text-gray-200" 
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-briefcase text-gray-500 mr-1"></i>
                            Cargo:
                        </label>
                        <input 
                            type="text" 
                            v-model="localRevisadoPorCargo"
                            @input="emitRevisadoPor"
                            placeholder="Ingrese cargo"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all dark:bg-gray-700 dark:text-gray-200" 
                        />
                    </div>
                    <div>
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-pen-nib text-gray-500"></i>
                            Firma:
                        </label>
                        <SignatureCanvas @signature-saved="handleRevisadoPorSignature" />
                        <transition
                            enter-active-class="transition-all duration-300 ease-out"
                            enter-from-class="opacity-0 scale-95"
                            enter-to-class="opacity-100 scale-100"
                        >
                            <div v-if="localRevisadoPorFirma" class="mt-3 p-3 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg">
                                <p class="text-green-700 dark:text-green-300 font-semibold mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Firma capturada correctamente
                                </p>
                                <img :src="localRevisadoPorFirma" alt="Firma" class="border-2 border-green-300 dark:border-green-600 rounded-lg max-w-full shadow-sm" style="max-height: 100px;" />
                            </div>
                        </transition>
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
