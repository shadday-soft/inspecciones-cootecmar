<script setup>
const props = defineProps({
    width: {
        type: String,
        default: '60rem'
    },
    footer: {
        type: Boolean,
        default: true
    },
    maximizable: {
        type: Boolean,
        default: false
    },
    closable: {
        type: Boolean,
        default: true
    },
    closeOnEscape: {
        type: Boolean,
        default: false
    },
    icon: {
        type: String,
        default: null
    },
    title: {
        type: String,
        default: null
    },
    baseZIndex: {
        type: Number,
        default: null
    },
    autoZIndex: {
        type: Boolean,
        default: true
    },
    severity: {
        type: String,
        default: 'primary'
    },
    modal: {
        type: Boolean,
        default: true
    }
})

const visible = defineModel()
</script>

<template>
    <Dialog pt:mask:class="backdrop-blur-sm" v-model:visible="visible" :maximizable="maximizable" :modal :closable
        :closeOnEscape :autoZIndex :baseZIndex :style="{ width: props.width }"
        :breakpoints="{ '1199px': '75vw', '575px': '90vw' }" :pt="{
            header: { class: 'bg-black !h-10 rounded-t-lg -m-1' },
            headerActions: { class: '!text-white !p-0' },
            content: { class: '!pb-0 !pt-2' },
            footer: { class: '!p-2 !h-min !items-end !flex !justify-end' }
        }">
        <template #header>
            <div class="flex items-center space-x-2 text-white">
                <i v-if="icon" :class="icon" />
                <slot v-else name="icon" />
                <span v-if="title" class="text-xl font-bold truncate">
                    {{ title }}
                </span>
                <slot v-else name="title" />
            </div>
        </template>
        <!-- <template  #header>
            <div class="flex items-center space-x-2 text-white">
                <i v-if="icon" :class="icon" />
                <slot v-else name="icon" />
                <span v-if="title" class="text-xl font-bold truncate">
                    {{ title }}
                </span>
                <slot v-else name="titulo" />
                askdjsdkj
            </div>
        </template> -->
        <template #default>
            <div class="h-full">
                <slot />
            </div>
        </template>
        <template #footer v-if="footer">
            <slot name="footer" />
        </template>
        <template #maximizeicon="{ maximized }">
            <i :class="maximized ? 'fa-compress' : 'fa-expand'" class="text-white fa-solid"></i>
        </template>
    </Dialog>
</template>
