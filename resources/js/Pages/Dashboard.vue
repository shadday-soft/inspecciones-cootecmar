<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import Schedule from '@/Pages/Dashboards/Scheduler.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="p-2">
            <Schedule></Schedule>        
        </div>
    </AppLayout>
</template>
