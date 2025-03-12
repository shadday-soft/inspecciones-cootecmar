<template>
  <div>
    <label for="" class="font-bold">Novedades presentes (ANOMALY):</label>
    <div class="rounded-lg border border-gray-300">
      <QuillEditor
        theme="snow"
        v-model:content="text"
        contentType="html"
        toolbar="full"
      />
    </div>
  </div>
  <div>
    <Button @click="submit" />
  </div>
</template>
<script setup>
import { ref } from "vue";
import ImageUploader from "quill-image-uploader";
import axios from "axios";

const text = ref(null);

const modules = {
  name: "imageUploader",
  module: ImageUploader,
  options: {
    upload: (file) => {
      return new Promise((resolve, reject) => {
        const formData = new FormData();
        formData.append("image", file);
        axios
          .post(route("upload.photos"), formData)
          .then((res) => {
            console.log(res.data.url);
            resolve(
              "https://upload.wikimedia.org/wikipedia/commons/thumb/6/6a/JavaScript-logo.png/480px-JavaScript-logo.png"
            );
          })
          .catch((err) => {
            reject("Upload failed");
            console.error("Error:", err);
          });
      });
    },
  },
};

function submit() {
  axios.post(route("upload.photos"), { text: text.value });
  console.log(text.value);
}
</script>
