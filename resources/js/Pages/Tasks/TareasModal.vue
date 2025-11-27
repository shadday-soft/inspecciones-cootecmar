<template>
    <Modal v-model="visibleLocal" :title="modalTitle" closeOnEscape>
        <div class="flex flex-col gap-y-4">
            <List :inspeccion="inspeccion"></List>
        </div>
    </Modal>
</template>

<script setup>
import { ref, watch, computed } from 'vue'
import Modal from '@/Components/Customs/Modal.vue'
import List from '@/Pages/Tasks/List.vue'

const props = defineProps({
    modelValue: { type: Boolean, required: true },
    inspeccion: { type: Object, required: true }
})

const emit = defineEmits(['update:modelValue'])

const visibleLocal = ref(props.modelValue)
watch(() => props.modelValue, v => visibleLocal.value = v)
watch(visibleLocal, v => emit('update:modelValue', v))

const modalTitle = computed(() => `Listado de tareas de la solicitud ${props.inspeccion?.code ?? ''}`)
</script>
