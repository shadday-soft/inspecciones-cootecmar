<template>
    <div class="my-4">
        <div class=" container w-[800px] mx-auto">
            <canvas class="border border-blue-950 rounded-sm mx-auto" ref="canvas" id="draw-canvas" width="800" height="360"></canvas>
            <div class="flex justify-between mt-4">
                <div class="space-x-4">
                    <Button @click="saveCanvas">Guardar</Button>
                    <Button @click="clearCanvas">Limpiar</Button>
                </div>
                <div>
                    <!-- <input type="color" v-model="color" id="color" /> -->
                    <label for="penSize">Tamaño </label>
                    <input name="penSize" class="rounded-sm" type="number" v-model="lineWidth" id="puntero" min="1" max="10" />
                </div>
            </div>
        </div>
        <!-- <p class="mt-3 text-center font-bold italic" v-if="imageData">Imagen guardada: </p>
        <img class="border border-blue-950 rounded-sm mx-auto" v-if="imageData" :src="imageData" alt="Firma guardada" /> -->
    </div>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const canvas = ref(null);
const color = ref('#000000');
const lineWidth = ref(2);
const imageData = ref("");
let ctx = null;
let drawing = false;
let mousePos = { x: 0, y: 0 };
let lastPos = { x: 0, y: 0 };

onMounted(async () => {
    await nextTick();
    if (!canvas.value) return;
    canvas.value.width = canvas.value.offsetWidth;
    canvas.value.height = canvas.value.offsetHeight;

    ctx = canvas.value.getContext('2d');
    ctx.lineCap = 'round';
    canvas.value.addEventListener('mousedown', startDrawing);
    canvas.value.addEventListener('mouseup', stopDrawing);
    canvas.value.addEventListener('mousemove', draw);
    canvas.value.addEventListener('touchstart', startTouch), { passive: false };
    canvas.value.addEventListener('touchend', stopTouch);
    canvas.value.addEventListener('touchmove', moveTouch), { passive: false };
});

function getMousePos(event) {
    const rect = canvas.value.getBoundingClientRect();
    return {
        x: event.clientX - rect.left,
        y: event.clientY - rect.top
    };
}

function startDrawing(event) {
    drawing = true;
    lastPos = getMousePos(event);
}

function stopDrawing() {
    drawing = false;
}

function draw(event) {
    if (!drawing) return;
    mousePos = getMousePos(event);
    ctx.strokeStyle = color.value;
    ctx.lineWidth = lineWidth.value;
    ctx.beginPath();
    ctx.moveTo(lastPos.x, lastPos.y);
    ctx.lineTo(mousePos.x, mousePos.y);
    ctx.stroke();
    ctx.closePath();
    lastPos = mousePos;
}

function startTouch(event) {
    event.preventDefault();
    const tocuh = event.touches[0];
    const mouseEvent = new MouseEvent('mousedown', {
        clientX: tocuh.clientX,
        clientY: tocuh.clientY
    });
    canvas.value.dispatchEvent(mouseEvent);
}

function stopTouch(event) {
    event.preventDefault();
    canvas.value.dispatchEvent(new MouseEvent("mouseup", {}));
}

function moveTouch(event) {
    event.preventDefault();
    const touch = event.touches[0];
    const mouseEvent = new MouseEvent('mousemove', {
        clientX: touch.clientX,
        clientY: touch.clientY
    });
    canvas.value.dispatchEvent(mouseEvent);
}

function clearCanvas() {
    ctx.clearRect(0, 0, canvas.value.width, canvas.value.height);
}

function saveCanvas() {
    imageData.value = canvas.value.toDataURL('image/png');
    
    const form = useForm({
    signature: imageData.value,
    });

    form.post(route("users.signature"), {
        onSuccess: () => {
            Swal.fire('Firma actualizada', '', 'success');

            router.get(route('settings'));
        }
    });
}

</script>