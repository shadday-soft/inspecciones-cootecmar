<script setup>
import { ref } from 'vue';
import { useCommonUtilities } from '@/composable/useCommonUtilities';
const { byteSizeFormatter } = useCommonUtilities()
import vueFilePond from "vue-filepond";
import FilePondPluginPdfPreview from "filepond-plugin-pdf-preview";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import "filepond-plugin-pdf-preview/dist/filepond-plugin-pdf-preview.min.css";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import Password from 'primevue/password';
import { root } from 'postcss';
import Select from 'primevue/select';

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginPdfPreview
);

const pond = ref();
const myFiles = ref([]);

const props = defineProps({
    //general
    autoResize: {
        type: Boolean,
        default: false
    },
    type: {
        type: String,
        default: 'text'
    },
    disabledDates: {
        type: Array,
        default: null
    },
    label: {
        type: String,
        default: null
    },
    loading: {
        type: Boolean,
        default: false
    },
    icon: {
        type: String,
        default: null
    },
    floatLabel: {
        type: Boolean,
        default: false
    },
    invalid: {
        type: Boolean,
        default: false
    },
    disabled: {
        type: Boolean,
        default: false
    },
    editable: {
        type: Boolean,
        default: false
    },
    id: {
        type: String,
        default: ''
    },
    help: {
        type: String,
        default: null
    },
    errorMessage: {
        type: String,
        default: null
    },
    placeholder: {
        type: String,
        default: null
    },
    filterPlaceholder: {
        type: String,
        default: null
    },
    //tipo number
    useGrouping: {
        type: Boolean,
        default: false
    },
    minFractionDigits: {
        type: Number,
        default: null
    },
    maxFractionDigits: {
        type: Number,
        default: null
    },
    currency: {
        type: String,
        default: 'COP'
    },
    mode: {
        type: String,
        default: 'decimal'
    },
    suffix: {
        type: String,
        default: null
    },
    prefix: {
        type: String,
        default: null
    },
    max: {
        type: Number,
        default: null
    },
    min: {
        type: Number,
        default: null
    },
    //tipo dropdown y multiselect
    options: {
        type: Array,
        default: null
    },
    optionLabel: {
        type: String,
        default: null
    },
    emptyMessage: {
        type: String,
        default: null
    },
    optionValue: {
        type: String,
        default: null
    },
    showClear: {
        type: Boolean,
        default: true
    },
    showButtons: {
        type: Boolean,
        default: true
    },
    step: {
        type: Number,
        default: 1
    },
    acceptFile: {
        type: String,
        default: null
    },
    maxSelectedLabels: {
        type: Number,
        default: 3
    },
    //tipo file
    maxFileSize: {
        type: Number,
        default: 100000000
    },
    multiple: {
        type: Boolean,
        default: false
    },
    selectionMode: {
        type: String,
        default: 'single'
    },
    previewImage: {
        type: Boolean,
        default: false
    },
    onLabel: {
        type: String,
        default: 'Si'
    },
    offLabel: {
        type: String,
        default: 'No'
    },
    required: {
        type: Boolean,
        default: false
    },
    //calendar
    minDate: {
        type: Date,
        default: null
    },
    maxDate: {
        type: Date,
        default: null
    },
    rowsTextarea: {
        type: Number,
        default: 4
    },
    stepMinute: {
        type: Number,
        default: 30
    },
    disabledDays: {
        type: Array,
        default: null
    },
    showIcon: {
        type: Boolean,
        default: true
    },
    manualInput: {
        type: Boolean,
        default: false
    },
    inputId: {
        type: String,
        default: null
    },
    binary: {
        type: Boolean,
        default: true
    },
    checkboxLabel: {
        type: String,
        default: null
    },
    name: {
        type: String,
        default: null
    },
    value: {
        type: String,
        default: null
    },
    enableTimePicker: {
        type: Boolean,
        default: false
    }
})

const countries = ref()
if (props.type == 'country') {
    axios.get('https://restcountries.com/v3.1/all?fields=flags,translations,name').then(
        (res) => {
            countries.value = res.data.map(country => {
                country.translations.spa.common = country.translations.spa.common.toUpperCase()
                return country
            })
        }
    )
}

const input = defineModel()

const onRemoveTemplatingFile = (removeFileCallback, index) => {
    if (props.multiple) {
        removeFileCallback(index);
    }
    else {
        input.value = null
        removeFileCallback(index);
    }
};
const src = ref(null)

function onFileSelect(event) {
    const file = event.files[0];
    const reader = new FileReader();
    input.value = file;
    reader.onload = async (e) => {
        src.value = e.target.result;
    };

    reader.readAsDataURL(file);
}

defineEmits(['valueChange'])

</script>
<template>
    <div class="flex flex-col">
        <div v-if="type == 'radiobutton'" class="w-full">
            <label v-if="label" :for="id" class="mb-0.5 font-bold">{{ label }}</label>
            <div class="flex" :class="options.length > 2 ? 'justify-between' : 'space-x-4'">
                <div v-for="option in options" :key="option.key" class="flex items-center">
                    <RadioButton v-model="input" :inputId="option.key" name="dynamic" :value="option.name" />
                    <label :for="option.key" class="ml-2 -mb-0.5">{{ option.name }}</label>
                </div>
            </div>
        </div>
        <span v-else>
            <label v-if="label && !floatLabel" :for="id" class="mb-0.5 font-bold">{{ label }}</label>
            <span :class="!(label && !floatLabel) ? 'p-float-label' : undefined">

                <InputNumber v-if="type == 'number'" :max :min :id :disabled :placeholder :minFractionDigits
                    :maxFractionDigits class="w-full" :class="invalid ? 'p-invalid' : ''" v-model="input"
                    :aria-describedby="id + '-help'" :required :useGrouping="mode == 'currency' ? '' : useGrouping"
                    :currency="currency" :mode="mode" :suffix :prefix :showButtons :step />
                <Textarea v-else-if="type == 'textarea'" :id :disabled :rows="rowsTextarea" class="w-full" :required
                    :placeholder :class="invalid ? 'p-invalid' : ''" v-model="input" :aria-describedby="id + '-help'" />
                <Select v-else-if="type == 'dropdown'" :virtualScrollerOptions="{ itemSize: 38 }" :optionValue :id
                    :disabled :placeholder :options :optionLabel :editable :emptyMessage :loading
                    @change="$emit('valueChange', $event)" showClear :filter="optionLabel ? true : false"
                    :class="invalid ? 'p-invalid' : ''" v-model="input" :aria-describedby="id + '-help'" class="w-full"
                    :pt="{
                        root: '!h-10',
                        input: '!py-0 !flex !items-center !text-sm !font-normal',
                        item: '!py-1 !px-3 !text-sm !font-normal',
                        filterInput: '!h-8'
                    }">
                    <template #option="slotProps">
                        <slot name="optionDropdown" :slotProps="slotProps" />
                    </template>
                </Select>
                <Dropdown v-else-if="type == 'country'" :optionValue :id :disabled :placeholder :filterPlaceholder
                    filter resetFilterOnHide :options="countries" :loading :class="invalid ? 'p-invalid' : ''"
                    v-model="input" optionLabel="translations.spa.common" :aria-describedby="id + '-help'"
                    class="w-full" :pt="{
                        root: '!h-8 ',
                        input: '!py-0 !flex !items-center !text-sm !font-normal',
                        item: '!py-1 !px-3 !text-sm !font-normal',
                        filterInput: '!h-8'
                    }">
                    <template #value="slotProps">
                        <div v-if="slotProps.value" class="flex space-x-1">
                            <img :src="slotProps.value.flags.svg" width="30" :alt="slotProps.value">
                            <p class="">{{ slotProps.value.translations.spa.common }}</p>
                        </div>
                        <span v-else>
                            {{ slotProps.placeholder }}
                        </span>
                    </template>

                    <template #option="slotProps">
                        <div class="flex space-x-1">
                            <img :src="slotProps.option.flags.svg" width="30"
                                :alt="slotProps.option.translations.spa.common">
                            <p>{{ slotProps.option.translations.spa.common }}</p>
                        </div>
                    </template>
                </Dropdown>
                <MultiSelect v-else-if="type == 'multiselect'" :optionValue :id display="chip" v-model="input" :options
                    :optionLabel :loading :maxSelectedLabels :placeholder :disabled :filter="optionLabel ? true : false"
                    :class="invalid ? 'p-invalid' : ''" class="w-full" :aria-describedby="id + '-help'" :pt="{
                        root: '!h-8',
                        label: '!py-0.5 !flex !h-full !items-center !text-sm !font-normal',
                        token: '!py-0 !px-1',
                        tokenLabel: '!text-sm',
                        item: '!py-1 !px-3 !text-sm !font-normal',
                        filterInput: '!h-8',
                        header: '!h-min !py-0.5'
                    }" />
                <div v-else-if="type == 'checkbox'">
                    <div class="flex w-full gap-x-2">
                        <Checkbox v-model="input" :inputId :name :value :binary />
                        <label class="" :for="inputId">{{ checkboxLabel }}</label>
                    </div>
                </div>
                <span v-else-if="type == 'groupcheckbox'">
                    <div class="flex flex-wrap justify-content-center gap-3">
                        <div class="flex h-8 space-x-1 items-center" v-for="option in options" :key="option.key">
                            <Checkbox v-model="input" :inputId="option.key" name="category" :value="option.name" />
                            <label :for="option.key">{{ option.name }}</label>
                        </div>
                    </div>
                </span>
                <div v-else-if="type == 'tooglebutton'" class="">
                    <ToggleButton v-model="input" :onLabel :offLabel :pt="{ root: '!h-8' }" />
                </div>
                <div v-else-if="type == 'boolean'" class="">
                    <InputSwitch v-model="input" />
                </div>
                <!-- <span v-else-if="type == 'datetime'">
                    <Calendar :manualInput :disabled :id v-model="input" :minDate :maxDate :placeholder showTime
                        :required hourFormat="24" showIcon :stepMinute dateFormat="dd/mm/yy"
                        @date-select="$emit('valueChange', $event)" :disabledDays :pt="{
                            root: '!w-full',
                            input: '!h-8'
                        }" />
                </span> -->

                <span v-else-if="type == 'datetime'">
                    <VueDatePicker :disabledDates class="w-full" :name hide-offset-dates :min-date="minDate"
                        v-model="input" :teleport="true" model-type="yyyy-MM-dd,HH:mm" ac :enable-time-picker="true"
                        locale="es" timezone="America/Bogota">
                    </VueDatePicker>
                    <!-- <Calendar :manualInput :disabled :id  :minDate :maxDate :placeholder :required
                        showIcon :disabledDays :selectionMode @date-select="$emit('valueChange', $event)"
                        dateFormat="yy-mm-dd" :pt="{
                            root: '!w-full',
                            input: '!h-8 !text-center '
                        }" /> -->
                </span>
                <span v-else-if="type == 'date'">
                    <VueDatePicker :disabledDates class="w-full" :name hide-offset-dates :min-date="minDate"
                        v-model="input" :teleport="true" model-type="yyyy-MM-dd" :enable-time-picker="false" locale="es"
                        timezone="America/Bogota" auto-apply>
                    </VueDatePicker>
                    <!-- <Calendar :manualInput :disabled :id  :minDate :maxDate :placeholder :required
                        showIcon :disabledDays :selectionMode @date-select="$emit('valueChange', $event)"
                        dateFormat="yy-mm-dd" :pt="{
                            root: '!w-full',
                            input: '!h-8 !text-center '
                        }" /> -->
                </span>

                <IconField v-else-if="loading || icon" iconPosition="left" class="w-full">
                    <InputIcon :class="loading ? 'fa-solid fa-spinner animate-spin' : icon" />
                    <InputText size="small" :id :disabled :placeholder :class="invalid ? 'p-invalid' : ''"
                        v-model="input" :type :required :aria-describedby="id + '-help'" class="w-full" />
                </IconField>
                <file-pond v-else-if="type == 'file-pond'" name="test" ref="input" storeAsFile="true"
                    label-idle="Archvios" :allow-multiple="true" accepted-file-types="image/*" />
                <span v-else-if="type == 'file-basic'">
                    <div class="flex w-full  items-center gap-6">
                        <FileUpload :accept="acceptFile" chooseLabel="Seleccionar Archivo" mode="basic"
                            @select="onFileSelect" customUpload auto severity="secondary" class="w-full" />
                        <img v-if="src" :src="src" alt="Image"
                            class="shadow-md rounded-xl w-full h-96 object-contain" />
                    </div>
                    <!-- <FileUpload mode="basic" :multiple :accept="acceptFile" :maxFileSize
                        @input="input = $event.target.files[0]" class="w-full h-8" customUpload /> -->
                </span>

                <span v-else class="w-full">
                    <InputText size="small" :id :disabled :placeholder :class="invalid ? 'p-invalid' : ''"
                        @change="$emit('valueChange', $event)" v-model="input" :type :required
                        :aria-describedby="id + '-help'" class="w-full" :pt="{
                            input: '!text-sm'
                        }" />
                </span>
                <label v-if="floatLabel && label" :for="id" class="">{{ label }}</label>
            </span>

        </span>
        <small class="text-sm italic text-red-400 mt-1">{{ errorMessage }}</small>
    </div>
</template>
