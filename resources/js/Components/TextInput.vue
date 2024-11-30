<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        ref="input"
        class=" text-base bg-gray-50 border-b border-t-0 border-x-0 border-gray-300 rounded-sm focus:outline-none focus:border-b-indigo-500"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
</template>
