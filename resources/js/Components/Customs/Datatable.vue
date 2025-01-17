<script setup>
import { FilterMatchMode } from "@primevue/core/api";
import { onMounted, ref } from "vue";
import { useCommonUtilities } from "@/composable/useCommonUtilities";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import { Link } from "@inertiajs/vue3";

const {
  byteSizeFormatter,
  currencyFormat,
  formatTime,
  truncateString,
} = useCommonUtilities();

const confirm = useConfirm();
const toast = useToast();
const dt = ref();

const props = defineProps({
  add: {
    type: Object,
    default: null,
  },
  data: {
    type: Array,
    default: [],
  },
  routecreate: {
    type: Object,
    required: false,
  },
  parameterData: {
    default: null,
  },
  requestData: {
    type: Object,
    default: {},
  },
  changeRows: {
    type: Boolean,
    default: true,
  },
  cacheName: {
    type: String,
    default: null,
  },
  columnas: {
    type: Array,
    default: [],
  },
  exportRute: {
    type: String,
    default: "",
  },
  actions: {
    type: Array,
    default: [],
  },
  showAdd: {
    type: Boolean,
    default: false,
  },
  filter: {
    type: Boolean,
    default: true,
  },
  filterButtons: {
    type: Array,
    default: null,
  },
  title: {
    type: String,
    default: "",
  },
  showColumns: {
    type: Boolean,
    default: true,
  },
  paginator: {
    type: Boolean,
    default: true,
  },
  loading: {
    type: Boolean,
    default: false,
  },
  rowsDefault: {
    type: Number,
    default: 10,
  },
  showHeader: {
    type: Boolean,
    default: true,
  },
  selectionMode: {
    type: String,
    default: "single",
  },
  showItem: {
    default: false,
    type: Boolean,
  },
  labelEvenMultiple: {
    type: String,
    default: "Gestionar",
  },
  emptyMessage: {
    type: String,
    default: "Sin datos",
  },
});

const dataResponse = defineModel("dataResponse", {
  required: false,
  type: Array,
  default: [],
});
const selectAll = defineModel("selectAll");

defineEmits(["rowClick", "buttonRowClick", "addClick", "buttonClick"]);

const dataLoading = ref(false);

const selectedElement = ref([]);

onMounted(() => {
  rows.value = props.rowsDefault;
});

//#region Filtros de tabla y visor columnas
const rows = ref();
const filters = ref({});
const globalFilterFields = ref([]);
const filterOK = ref(false);

const initFilters = async () => {
  globalFilterFields.value = ["id"];
  filters.value.global = { value: null, matchMode: FilterMatchMode.CONTAINS };
  for await (var columna of props.columnas) {
    if (columna.filter) {
      filters.value[columna.field] = {
        value: null,
        matchMode: FilterMatchMode[columna.filtertype ? columna.filtertype : "CONTAINS"],
      };
      globalFilterFields.value.push(columna.field);
    }
  }
  filterOK.value = true;
};

initFilters();

onMounted(() => {
  initFilters();
});

const clearFilter = () => {
  initFilters();
};

//#region formato de campo
const formatDate = (date) => {
  if (date == undefined || date == null) {
    return "Sin definir";
  } else {
    var fecha = new Date(date).toLocaleString("es-CO", {
      day: "2-digit",
      month: "2-digit",
      year: "numeric",
    });
    return fecha == "30/11/2" ? "INDEFINIDO" : fecha;
  }
};
const formatDateTime = (date) => {
  if (date == undefined || date == null) {
    return "Sin definir";
  } else {
    return new Date(date).toLocaleString("es-CO");
  }
};

// #endregion
const mensaje =
  "Funcion en desuso, se recomienda no usar el event dentro de button. Lea mas en la documentacion...Que hare algun dia : v";
</script>

<template>
  <DataTable
    ref="dt"
    id="tabla"
    :value="props.routes == null ? props.data : dataResponse"
    v-model:selection="selectedElement"
    :selectAll="selectAll"
    :paginator="(dataResponse.length > 0 || data.length > 0) && paginator"
    :rows
    :selectionMode
    sortMode="multiple"
    scrollable
    scrollHeight="flex"
    :loading="props.routes == null ? props.loading : dataLoading"
    currentPageReportTemplate="{first} al {last} de un total de {totalRecords}"
    removableSort
    v-model:filters="filters"
    stripedRows
    filterDisplay="menu"
    class="p-datatable-sm p-1 rounded-md"
    stateStorage="session"
    :stateKey="cacheName ? 'dt-' + cacheName + '-state-session' : null"
    :globalFilterFields="globalFilterFields"
    @row-click="$emit('rowClick', $event)"
    paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
    :pt="{
      paginator: {
        paginatorWrapper: '!p-0',
        current: 'text-sm font-bold cursor-default !h-8 hidden sm:flex item-center',
        pagebutton: {
          class: '!font-bold !h-8 !rounded-md !w-6',
        },
        firstPageButton: '!h-8 !rounded-md',
        previousPageButton: '!h-8 !rounded-md',
        nextPageButton: '!h-8 !rounded-md',
        lastPageButton: '!h-8 !rounded-md',
      },
      loadingOverlay: '!bg-white',
    }"
  >
    <template #header>
      <div class="space-y-1 w-full">
        <span class="hidden lg:flex justify-between">
          <div class="flex space-x-3">
            <p
              v-if="title"
              class="text-xl h-ful flex items-center font-extrabold leading-6 mb-2 capitalize text-primary"
            >
              {{ title }}
            </p>
            <slot name="title" />
          </div>
        </span>
        <div
          class="flex gap-2 w-full border border-gray-300 py-1.5 px-2 rounded-xl h-10 items-center"
        >
          <Button
            v-tooltip.top="'Nuevo ' + title"
            v-if="add"
            @click="add.action($event)"
            text
            icon="fa-solid fa-plus text-sm"
          />
          <Button
            v-tooltip.top="'Quitar Filteros'"
            @click="clearFilter()"
            icon="fa-solid fa-filter-circle-xmark text-sm"
            text
          />
          <IconField class="w-full flex items-center">
            <InputText
              v-model="filters.global.value"
              class="w-full !border-0"
              type="search"
              size="small"
              placeholder="Buscar"
            />
            <InputIcon class="fa-solid fa-magnifying-glass" />
          </IconField>
        </div>
      </div>
    </template>

    <!-- #region ajustes de tabla -->
    <template #empty>
      <div class="flex flex-col items-center space-y-1">
        <!-- <ApplicationLogo class="w-32" /> -->
        <p class="text-center font-bold italic">
          {{ emptyMessage ?? "Sin datos" }}
        </p>
      </div>
    </template>
    <template #loading>
      <div class="flex justify-center">Cargando...</div>
    </template>
    <template #paginatorstart>
      <div class="flex items-center" v-if="changeRows">
        <Dropdown
          v-model="rows"
          :options="[1, 5, 10, 20, 50, 100]"
          :pt="{
            root: '!h-8 !border-0 !ring-0',
            input: '!py-0 !flex !items-center',
            item: '!p-1 w-full text-center',
          }"
        />
      </div>
    </template>
    <template #paginatorfirstpagelinkicon>
      <i class="fa-solid fa-angles-left"></i>
    </template>
    <template #paginatorprevpagelinkicon>
      <i class="fa-solid fa-angle-left"></i>
    </template>
    <template #paginatornextpagelinkicon>
      <i class="fa-solid fa-angle-right"></i>
    </template>
    <template #paginatorlastpagelinkicon>
      <i class="fa-solid fa-angles-right"></i>
    </template>
    <template #paginatorrowsperpagedropdownicon>
      <i class="fa-solid fa-angle-down"></i>
    </template>
    <!-- #endregion -->

    <!-- #region Columnas -->
    <Column
      :selectionMode
      v-if="selectionMode == 'multiple'"
      headerStyle="width: 3rem"
    ></Column>
    <span v-for="(col, index) in columnas">
      <Column
        v-if="col.visible == null || col.visible == true"
        :field="col.field"
        :filterField="col.field"
        :class="col.class"
        :sortable="col.sortable"
        :show-filter-match-modes="false"
        :filterMenuStyle="{ width: '16rem' }"
        :frozen="col.frozen"
        :pt="{
          headerContent: { class: '!h-8' },
          headerCell: { class: '!p-0.5' },
        }"
      >
        <template #header>
          <p class="text-sm text-primary uppercase font-extrabold truncate">
            {{ col.header }}
          </p>
        </template>
        <template #filtericon>
          <i class="fa-solid fa-filter"></i>
        </template>
        <template #sorticon="{ sortOrder, sorted }">
          <i
            :class="
              sorted
                ? sortOrder == 1
                  ? 'fa-solid fa-arrow-up-1-9'
                  : 'fa-solid fa-arrow-up-9-1'
                : 'fa-solid fa-sort'
            "
            class="text-gray-500 flex justify-center items-center ml-1 h-5 w-5"
          ></i>
        </template>

        <template #filter="{ filterModel }" v-if="col.filter">
          <input
            v-if="col.type == 'date'"
            class="w-full rounded-md p-column-filter"
            type="date"
            v-model="filterModel.value"
            dateFormat="mm/dd/yy"
            placeholder="mm/dd/yyyy"
            mask="99/99/9999"
          />
          <InputNumber
            v-else-if="col.type == 'number'"
            v-model="filterModel.value"
            class="p-column-filter"
            placeholder="Numero a buscar"
          />
          <Dropdown
            v-else-if="col.type == 'tag' || col.type == 'customtag'"
            v-model="filterModel.value"
            :options="col.severitys.map((option) => option.text)"
            placeholder="Selecciona una opcion"
            class="p-column-filter w-full md:w-14rem"
            showClear
          />
          <Dropdown
            v-else-if="col.filterType == 'dropdown'"
            :option-label="col.filterLabel"
            :option-value="col.filterValue"
            v-model="filterModel.value"
            :options="col.filterOptions"
            placeholder="Selecciona una opcion"
            class="p-column-filter w-full md:w-14rem"
            showClear
          />
          <InputText
            v-else
            v-model="filterModel.value"
            type="text"
            class="p-column-filter"
            placeholder="Escriba algo para buscar"
          />
        </template>

        <template #body="{ data }" v-if="col.field.indexOf('.') == -1">
          <span v-if="col.type == 'image'">
            <img :src="data[col.field]" :class="col.classImage" />
          </span>
          <p v-else-if="col.type == 'datetime'" class="text-left">
            {{ formatDateTime(data[col.field]) }}
          </p>
          <p v-else-if="col.type == 'date'" class="text-left">
            {{ formatDate(data[col.field]) }}
          </p>
          <div v-else-if="col.type == 'link'" class="text-left flex gap-2 max-w-40">
            {{ data[col.field] }}
            <a
              :href="urlHref(data[col.field])"
              v-tooltip="'Nueva pestaña'"
              target="_blank"
              rel="noopener noreferrer"
            >
              <i class="fa-solid fa-up-right-from-square"></i>
            </a>
          </div>
          <p v-else-if="col.type == 'currency'" class="text-right">
            {{
              currencyFormat(
                data[col.field],
                !Array.isArray(data[col.field]) ? "COP" : data[col.field][1]
              )
            }}
          </p>
          <p v-else-if="col.type == 'time'" class="text-left">
            {{ formatTime(data[col.field]) }}
          </p>
          <p
            v-else-if="col.type == 'customtag'"
            :class="
              col.severitys.find((severity) => severity.text == data[col.field]).class
            "
            class="text-center rounded-lg px-2 py-1"
          >
            {{ data[col.field] }}
          </p>
          <Tag
            v-else-if="col.type == 'tag'"
            class="w-full truncate"
            :title="data[col.field]"
            :class="
              col.severitys.find((severity) => severity.text == data[col.field]).class
            "
            :severity="
              col.severitys.find((severity) => severity.text == data[col.field]).severity
            "
            :value="data[col.field]"
          />

          <span v-else-if="col.type == 'button'" class="w-full">
            <Button
              :label="String(data[col.field])"
              class="w-full truncate"
              :class="col.rowClass"
              :icon="col.icon"
              :outlined="col.outlined"
              :text="col.text"
              :severity="col.severity"
              :rounded="col.rounded"
              @click="
                col.event(data);
                $emit('buttonRowClick', $event, data, col.field);
              "
            >
            </Button>
          </span>
          <span v-else-if="col.type == 'array'" class="w-full flex space-x-1">
            <p
              v-for="(item, index) in data[col.field]"
              :class="
                col.itemsClass.find((itemClass) => itemClass.text == item)?.class ??
                col.itemClass
              "
            >
              {{ item }}
            </p>
          </span>
          <span v-else-if="col.type == 'fileSize'">
            {{ byteSizeFormatter(data[col.field]) }}
          </span>
          <span
            v-else-if="col.type == 'boolean'"
            class="flex items-center justify-center"
          >
            <InputSwitch v-model="data[col.field]" :disabled="true" />
          </span>
          <span
            v-else-if="col.type == 'html'"
            v-html="
              typeof col.renderer === 'function'
                ? col.renderer(data[col.field])
                : col.renderer
            "
          >
          </span>
          <p v-else class="">
            {{
              col.format
                ? col.format(truncateString(data[col.field] + " ", 80))
                : truncateString(data[col.field] + " ", 80)
            }}
            <!-- {{ truncateString(data[col.field], 80) }} -->
          </p>
        </template>
      </Column>
    </span>
    <Column
      frozen
      alignFrozen="right"
      class="w-[8%]"
      v-if="props.actions.length > 0 || routes?.update || routes?.delete || showItem"
    >
      <template #body="{ data }">
        <div
          class="flex items-center justify-center bg-white rounded-md shadow-sm gap-0.5"
        >
          <span v-for="button in props.actions">
            {{ button.event ? console.log(mensaje) : undefined }}
            <Button
              @click="
                button.event
                  ? $emit(button.event, $event, data)
                  : button.action(data, $event)
              "
              :text="button.text == undefined ? true : button.text"
              :severity="button.severity == undefined ? 'primary' : button.severity"
              :outlined="button.outlined == undefined ? false : button.outlined"
              :rounded="button.rounded == undefined ? false : button.rounded"
              :icon="
                typeof button.icon === 'function'
                  ? button.icon(data, $event)
                  : button.icon
              "
              v-tooltip.left="{ pt: { root: 'text-center' }, value: button.label }"
              :class="button.class"
              v-if="
                typeof button.show === 'function'
                  ? button.show(data, $event)
                  : button.show == undefined
                  ? true
                  : button.show
              "
            />
          </span>
          <Button
            v-if="showItem"
            v-tooltip.left="'Ver'"
            @click="open($event, data, 'show')"
            text
            icon="fa-solid fa-eye"
            severity="success"
          />
          <Button
            v-if="routes?.update"
            v-tooltip.left="'Editar'"
            @click="open($event, data, 'edit')"
            text
            icon="fa-solid fa-pencil"
            severity="warning"
          />
          <Button
            v-if="routes?.delete"
            v-tooltip.left="'Eliminar'"
            @click="deleteItem($event, data)"
            text
            icon="fa-solid fa-trash-can"
            severity="danger"
          />
        </div>
      </template>
    </Column>
    <!-- #endregion -->
  </DataTable>
</template>
