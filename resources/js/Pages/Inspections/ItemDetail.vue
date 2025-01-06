<template>
  <div
    v-tooltip="`${value}`"
    class="p-2 border border-gray-200 shadow-md rounded-md text-center cursor-default"
  >
    <h2 class="font-semibold text-sm">{{ label }}</h2>
    <p class="text-sm">{{ truncateString(value) }}</p>
  </div>
</template>

<script setup>
import { useCommonUtilities } from "@/composable/useCommonUtilities";

const { truncateString } = useCommonUtilities();
const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  value: {
    type: String,
    required: true,
  },
});
</script>
