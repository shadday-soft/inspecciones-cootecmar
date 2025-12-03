<template>
    <div class="border p-4 space-y-3 rounded-lg shadow-sm bg-white dark:bg-gray-800 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-2 mb-3 pb-2 border-b border-gray-200 dark:border-gray-600">
            <i v-if="icon" :class="icon" class="text-blue-600 dark:text-blue-400"></i>
            <span class="font-bold text-sm text-gray-700 dark:text-gray-300">{{ label }}</span>
        </div>
        <div class="flex flex-wrap gap-4 items-center">
            <label 
                v-for="option in options" 
                :key="option" 
                class="flex items-center gap-2 cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-700 px-3 py-2 rounded-lg transition-colors"
            >
                <input 
                    type="checkbox" 
                    :value="option" 
                    v-model="localValue"
                    @change="emitChange"
                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700" 
                />
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ option }}</span>
            </label>
            <input 
                v-if="hasOtroOption && isOtroSelected"
                type="text"
                v-model="otroValue"
                @input="emitOtroChange"
                placeholder="especificar"
                class="border-b-2 border-gray-400 dark:border-gray-500 px-3 py-2 w-48 bg-transparent focus:outline-none focus:border-blue-500 dark:focus:border-blue-400 text-gray-800 dark:text-gray-200 text-sm rounded-t transition-colors"
            />
        </div>
    </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue';

const props = defineProps({
    label: {
        type: String,
        required: true
    },
    options: {
        type: Array,
        required: true
    },
    modelValue: {
        type: Array,
        default: () => []
    },
    icon: {
        type: String,
        default: null
    },
    otroModelValue: {
        type: String,
        default: ''
    }
});

const emit = defineEmits(['update:modelValue', 'update:otroModelValue']);

const localValue = ref(Array.isArray(props.modelValue) ? [...props.modelValue] : []);
const otroValue = ref(props.otroModelValue || '');

// Verificar si existe la opción "OTRO" en las opciones
const hasOtroOption = computed(() => {
    return props.options.some(option => option.toUpperCase() === 'OTRO');
});

// Verificar si "OTRO" está seleccionado
const isOtroSelected = computed(() => {
    return localValue.value.some(value => value.toUpperCase() === 'OTRO');
});

watch(() => props.modelValue, (newVal) => {
    if (Array.isArray(newVal)) {
        localValue.value = [...newVal];
    }
}, { deep: true });

watch(() => props.otroModelValue, (newVal) => {
    otroValue.value = newVal || '';
});

function emitChange() {
    emit('update:modelValue', localValue.value);
}

function emitOtroChange() {
    emit('update:otroModelValue', otroValue.value);
}
</script>
