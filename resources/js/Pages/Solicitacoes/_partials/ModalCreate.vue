<script setup lang="ts">

import { ref, defineEmits, watch } from 'vue';
import Modal from '@/Components/Modal.vue';

const images = ref<Array<{ name: string; url: string }>>([]);
const fileInput = ref<HTMLInputElement | null>(null);

const emit = defineEmits(['files', 'save']);

watch(images.value, (newValue) => {
    emit('files', images.value)
})

const removeImage = (index: number) => {
    images.value.splice(index, 1);
};

const onFileChange = (event: Event) => {

    const target = event.target as HTMLInputElement;

    if (target.files) {
        processFiles(target.files);
    }
};

const onDrop = (event: DragEvent) => {
    const files = event.dataTransfer?.files;

    if (files) {
        processFiles(files);
    }
};

const triggerFileInput = () => {
    fileInput.value?.click();
};

const processFiles = (files: FileList) => {
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        reader.onload = (e: ProgressEvent<FileReader>) => {
            const imageUrl = e.target?.result as string;
            images.value.push({ name: file.name, url: imageUrl });
        };
        reader.readAsDataURL(file);
    }
};

const saveImages = () => {
    emit('save')
}

</script>

<template>
    <Modal>
        <div id="header">
            <div class="p-5">
                <h1>Upload de Arquivos</h1>
            </div>
        </div>
        <div id="content">
            <div class="bg-[#ffff] m-auto p-4">

                <input type="file" ref="fileInput" class="hidden" @change="onFileChange" accept="image/*" />

                <div v-if="images.length == 0" @click="triggerFileInput" class="image-upload-wrap cursor-pointer" @dragover.prevent @drop.prevent="onDrop">
                    <div class="drag-text">
                        <h3>Arraste e solte uma imagem ou clique para selecionar</h3>
                    </div>
                </div>

                <div v-if="images.length > 0" class="flex flex-col gap-4">
                    <div v-for="(image, index) in images" :key="index" class="flex justify-between flex-row items-center gap-5">
                        <div class="flex items-center gap-5">
                            <img :src="image.url" class="w-20 rounded-md" />
                            <p>{{ image.name }}</p>
                        </div>
                        
                        <img @click="removeImage(index)" class="fill-red-900 w-5 h-5 bg-white cursor-pointer" src="/trash-icon.svg" alt="">
                    </div>
                </div>

                <div v-if="images.length > 0" class="mt-4 grid grid-cols-3 gap-4">
                    <button  @click="triggerFileInput" class="w-full col-span-2 bg-slate-300 p-2 rounded-md">
                        Adicionar Imagem
                    </button>

                    <button @click="saveImages()" class="col-span-1 bg-blue-500 text-white p-2 rounded-md text-center">
                        Salvar Imagens
                    </button>
                </div>
            </div>
        </div>
    </Modal>
</template>

<style scoped>


.file-upload-input {
    display: none;
}

.image-upload-wrap {
    margin-top: 20px;
    border: 4px dashed #1fb264;
    position: relative;
    text-align: center;
}

.image-dropping,
.image-upload-wrap:hover {
    background-color: #1fb264;
    border: 4px dashed #ffffff;
}

.drag-text {
    text-align: center;
}

.drag-text h3 {
    font-weight: 100;
    text-transform: uppercase;
    color: #15824b;
    padding: 60px 0;
}

.file-upload-content {
    display: block;
    text-align: center;
}

.file-upload-image {
    max-height: 200px;
    max-width: 200px;
    margin: auto;
    padding: 20px;
}

.remove-image {
    width: 200px;
    margin: 0;
    color: #fff;
    background: #cd4535;
    border: none;
    padding: 10px;
    border-radius: 4px;
    border-bottom: 4px solid #b02818;
    transition: all 0.2s ease;
    outline: none;
    text-transform: uppercase;
    font-weight: 700;
}

.remove-image:hover {
    background: #c13b2a;
    cursor: pointer;
}
</style>
