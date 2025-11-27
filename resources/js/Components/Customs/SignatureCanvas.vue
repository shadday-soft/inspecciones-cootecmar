<template>
    <div class="my-4">
        <div class="container w-full max-w-[800px] mx-auto">
            <canvas 
                class="border-2 border-gray-300 rounded-lg mx-auto w-full" 
                ref="canvas" 
                id="draw-canvas" 
                width="800" 
                height="300"
            ></canvas>
            <div class="flex justify-between mt-4">
                <div class="space-x-4">
                    <Button @click="saveCanvas" label="Capturar Firma" icon="fa-solid fa-check" severity="success" size="small" />
                    <Button @click="clearCanvas" label="Limpiar" icon="fa-solid fa-eraser" severity="secondary" size="small" />
                </div>
                <div class="flex items-center gap-2">
                    <label for="penSize" class="font-semibold">Grosor:</label>
                    <input 
                        name="penSize" 
                        class="rounded-md border-gray-300 w-16" 
                        type="number" 
                        v-model="lineWidth" 
                        id="puntero" 
                        min="1" 
                        max="10" 
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue';

const emit = defineEmits(['signature-saved']);

const canvas = ref(null);
const color = ref('#000000');
const lineWidth = ref(2);
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
    ctx.lineJoin = 'round';
    
    canvas.value.addEventListener('mousedown', startDrawing);
    canvas.value.addEventListener('mouseup', stopDrawing);
    canvas.value.addEventListener('mousemove', draw);
    canvas.value.addEventListener('mouseleave', stopDrawing);
    canvas.value.addEventListener('touchstart', startTouch, { passive: false });
    canvas.value.addEventListener('touchend', stopTouch);
    canvas.value.addEventListener('touchmove', moveTouch, { passive: false });
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
    const touch = event.touches[0];
    const mouseEvent = new MouseEvent('mousedown', {
        clientX: touch.clientX,
        clientY: touch.clientY
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
    const imageData = canvas.value.toDataURL('image/png');
    emit('signature-saved', imageData);
}
</script>

<style scoped>
canvas {
    touch-action: none;
}
</style>
